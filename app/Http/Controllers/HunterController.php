<?php

namespace App\Http\Controllers;

use App\Models\HunterModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\HunterRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class HunterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hunter = HunterModel::all();
        return view('index', compact('hunter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HunterRequest $request)
    {
        $validacoes = $request->validated();
        $validacoes['serial'] = Str::upper(Str::random(10));
        $validacoes['imagem_hunter'] = implode(',', $validacoes['imagem_hunter']);
        $registro = HunterModel::create($validacoes);
        $registro_id = $registro->id;
        $imagens_paths = [];
        foreach ($request->file('imagem_hunter') as $imagem) {
            $imagens_paths[] = $imagem->store("avatars/$registro_id");
        }
        if(!empty($imagens_paths)){
            $registro->imagem_hunter = implode(',', $imagens_paths);
            $registro->save();
        } else {
            dd("Não foi possível inserir as imagens de {$validacoes['nome_hunter']}, refaça a operação.");
        }
        return redirect('/')->with('success_store',"{$validacoes['nome_hunter']} está presente no sistema.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hunter = HunterModel::find(Crypt::decrypt($id));
        return view('update', compact('hunter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HunterRequest $request, $id)
    {
        $validacoes = $request->validated();
        $decriptado_id = Crypt::decrypt($id);
        $imagens_antigas = explode(',', HunterModel::find($decriptado_id)->imagem_hunter);
        $imagens_paths = [];
        foreach ($imagens_antigas as $imagem) {
            if(Storage::exists($imagem)){
                Storage::delete($imagem);
            }
        }
        foreach ($request->file('imagem_hunter') as $imagem) {
            $imagens_paths[] = $imagem->store("avatars/$decriptado_id");
        }
        if(!empty($imagens_paths)){
            HunterModel::where('id', $decriptado_id)->update(['imagem_hunter' => implode(',', $imagens_paths)]);
        } else {
            dd("Não foi possível atualizar as imagens de {$validacoes['nome_hunter']}, refaça a operação.");
        }
        return redirect('/')->with('success_update',"{$validacoes['nome_hunter']} obteve atualização em suas informações.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $decriptado_id = Crypt::decrypt($id);
        $imagens_hunter = explode(',', HunterModel::find($decriptado_id)->imagem_hunter);
        $nome = HunterModel::find($decriptado_id)->nome_hunter;
        if(!empty($imagens_hunter)){
            foreach ($imagens_hunter as $imagem) {
                if(Storage::exists($imagem)){
                    Storage::delete($imagem);
                }
            }
            Storage::deleteDirectory("avatars/$decriptado_id");
        }
        HunterModel::where('id', $decriptado_id)->delete();
        return redirect('/')->with('success_destroy',"$nome não está mais presente no sistema.");
    }

    public function exportPDF()
    {
        $hunter = HunterModel::all();
        if ($hunter->isNotEmpty()){
            $pdf = PDF::loadView('table_export', compact('hunter'));
            $pdf->setPaper('A4','landscape');
            $pdf->render();
            $pdf->stream();
            return $pdf->download(Str::random(10).'.pdf');
        } else {
            return redirect('/')->with('export_pdf_error',"É necessário haver no mínimo 1 registro para exportar em arquivo PDF.");
        }
    }

    public function downloadZip($id){
        $zip_archive = new ZipArchive();
        $nome_hunter = DB::table('hunters')->where('id','=', Crypt::decrypt($id))->value('nome_hunter');
        $name_zip = "Hunter $nome_hunter".'.zip';
        if ($zip_archive->open(storage_path($name_zip), ZipArchive::CREATE) == TRUE){
            $file = File::files(storage_path('app/avatars/'.Crypt::decrypt($id)));
            foreach($file as $key => $value){
                $name_file = basename($value);
                $zip_archive->addFile($value, $name_file);
            }
            $zip_archive->close();
        } else {
            dd("Não foi possível realizar a zipagem do avatar de $nome_hunter.");
        }
        return response()->download(storage_path($name_zip))->deleteFileAfterSend(true);
    }

}
