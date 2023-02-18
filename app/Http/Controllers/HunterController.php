<?php

namespace App\Http\Controllers;

use App\Models\HunterModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\HunterRequest;
use App\Models\LoggingModel;
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
            $original_names = $imagem->getClientOriginalName();
            $imagens_paths[] = $imagem->storeAs("avatars/$registro_id", $original_names);
        }
        if(!empty($imagens_paths)){
            $registro->imagem_hunter = implode(',', $imagens_paths);
            $registro->save();
        } else {
            dd("Não foi possível inserir a(s) imagem(ns) de {$validacoes['nome_hunter']}, refaça a operação.");
        }

        $data = Carbon::now()->format('d/m/Y H:i:s');
        $ip_user = request()->ip();
        $mensagem = "Hunter {$validacoes['nome_hunter']} foi cadastrado(a) utilizando o IP {$ip_user} em {$data}.";
        Log::channel('logRegisterHunter')->info($mensagem);

        $log = new LoggingModel();
        $log->descricao = $mensagem;
        $log->save();

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
        $decriptado_id = Crypt::decrypt($id);
        $validacoes = $request->validated();
        unset($validacoes['imagem_hunter']);
        HunterModel::where('id', $decriptado_id)->update($validacoes);
        $imagens_antigas = explode(',', HunterModel::find($decriptado_id)->imagem_hunter);
        $imagens_paths = [];
        if ($request->hasFile('imagem_hunter')) {
            foreach ($imagens_antigas as $imagem) {
                if(Storage::exists($imagem)){
                    Storage::delete($imagem);
                }
            }
            foreach ($request->file('imagem_hunter') as $imagem) {
                $original_names = $imagem->getClientOriginalName();
                $imagens_paths[] = $imagem->storeAs("avatars/$decriptado_id", $original_names);
            }
            if(!empty($imagens_paths)) {
                HunterModel::where('id', $decriptado_id)->update(['imagem_hunter' => implode(',', $imagens_paths)]);
            } else {
                dd("Não foi possível atualizar a(s) imagem(ns) de {$validacoes['nome_hunter']}, refaça a operação.");
            }
        }

        $data = Carbon::now()->format('d/m/Y H:i:s');
        $ip_user = request()->ip();
        $mensagem = "Hunter {$validacoes['nome_hunter']} teve suas informações atualizadas utilizando o IP {$ip_user} em {$data}.";
        Log::channel('logUpdateHunter')->info($mensagem);

        $log = new LoggingModel();
        $log->descricao = $mensagem;
        $log->save();

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
            File::copyDirectory(storage_path("app/avatars/$decriptado_id"), storage_path("app/trashed/avatars/$decriptado_id"));
            foreach ($imagens_hunter as $imagem) {
                if(Storage::exists($imagem)){
                    Storage::delete($imagem);
                }
            }
        }
        Storage::deleteDirectory("avatars/$decriptado_id");
        HunterModel::where('id', $decriptado_id)->delete();

        $data = Carbon::now()->format('d/m/Y H:i:s');
        $ip_user = request()->ip();
        $mensagem = "Hunter $nome foi redirecionado(a) para a lixeira utilizando o IP {$ip_user} em {$data}.";
        Log::channel('logTrashHunter')->info($mensagem);

        $log = new LoggingModel();
        $log->descricao = $mensagem;
        $log->save();

        return redirect('/')->with('success_destroy',"$nome agora está na lixeira.");
    }

    public function trashRegister()
    {
        $hunter = HunterModel::onlyTrashed()->get();
        return view('trash', compact('hunter'));
    }

    public function restoreRegisterTrash($id)
    {
        $decriptado_id = Crypt::decrypt($id);
        $nome = HunterModel::onlyTrashed()->find($decriptado_id)->nome_hunter;
        $hunter = HunterModel::onlyTrashed()->find($decriptado_id);
        File::moveDirectory(storage_path("app/trashed/avatars/$decriptado_id"), storage_path("app/avatars/$decriptado_id"));
        $hunter->restore();

        $data = Carbon::now()->format('d/m/Y H:i:s');
        $ip_user = request()->ip();
        $mensagem = "Hunter $nome foi restaurado(a) da lixeira para a página principal utilizando o IP {$ip_user} em {$data}.";
        Log::channel('logRestoreHunter')->info($mensagem);

        $log = new LoggingModel();
        $log->descricao = $mensagem;
        $log->save();

        return redirect('/')->with('success_store',"$nome retornou a listagem de Hunters.");
    }

    public function destroyRegisterTrash($id)
    {
        $decriptado_id = Crypt::decrypt($id);
        $nome = HunterModel::onlyTrashed()->find($decriptado_id)->nome_hunter;
        $imagens_hunter = explode(',', HunterModel::onlyTrashed()->find($decriptado_id)->imagem_hunter);
        $hunter = HunterModel::onlyTrashed()->find($decriptado_id);
        $hunter->forceDelete();
        if(!empty($imagens_hunter)){
            foreach ($imagens_hunter as $imagem) {
                if(Storage::exists("trashed/$imagem")){
                    Storage::delete("trashed/$imagem");
                }
            }
            Storage::deleteDirectory("trashed/avatars/$decriptado_id");
        }

        $data = Carbon::now()->format('d/m/Y H:i:s');
        $ip_user = request()->ip();
        $mensagem = "HUnter foi excluído(a) permanentemente da lixeira $nome utilizando o IP {$ip_user} em {$data}.";
        Log::channel('logDestroyHunter')->info($mensagem);

        $log = new LoggingModel();
        $log->descricao = $mensagem;
        $log->save();

        return redirect('/')->with('success_destroy',"$nome foi excluído(a) permanentemente do sistema.");
    }

    public function exportPDF()
    {
        $hunter = HunterModel::all();
        if ($hunter->isNotEmpty()){
            $pdf = PDF::loadView('table_export', compact('hunter'));
            $pdf->setPaper('A4','landscape');
            $pdf->render();
            $pdf->stream();

            $data = Carbon::now()->format('d/m/Y H:i:s');
            $ip_user = request()->ip();
            $mensagem = "Foi feito a exportação dos Hunters para PDF utilizando o IP {$ip_user} em {$data}.";
            Log::channel('logExportPDFHunter')->info($mensagem);

            $log = new LoggingModel();
            $log->descricao = $mensagem;
            $log->save();

            return $pdf->download(Str::random(10).'.pdf');
        } else {
            return redirect('/')->with('export_pdf_error',"É necessário haver no mínimo 1 registro para exportar em arquivo PDF.");
        }
    }

    public function downloadZip($id)
    {
        $zip_archive = new ZipArchive();
        $nome_hunter = DB::table('hunters')->where('id','=', Crypt::decrypt($id))->value('nome_hunter');
        $name_zip = "Hunter $nome_hunter".'.zip';
        if ($zip_archive->open(storage_path($name_zip), ZipArchive::CREATE) == TRUE){
            $files = File::files(storage_path('app/avatars/' . Crypt::decrypt($id)));
            foreach($files as $key => $value){
                $name_file = basename($value);
                $zip_archive->addFile($value, $name_file);
            }
            $zip_archive->close();
        } else {
            dd("Não foi possível realizar a zipagem da(s) imagem(ns) de $nome_hunter.");
        }

        $data = Carbon::now()->format('d/m/Y H:i:s');
        $ip_user = request()->ip();
        $mensagem = "Foi feito a zipagem da(s) imagem(ns) de $nome_hunter na página inicial utilizando o IP {$ip_user} em {$data}.";
        Log::channel('logZipHunter')->info($mensagem);

        $log = new LoggingModel();
        $log->descricao = $mensagem;
        $log->save();

        return response()->download(storage_path($name_zip))->deleteFileAfterSend(true);
    }

    public function downloadZipRegisterTrash($id)
    {
        $zip_archive = new ZipArchive();
        $nome_hunter = DB::table('hunters')->where('id','=', Crypt::decrypt($id))->value('nome_hunter');
        $name_zip = "Hunter $nome_hunter (at trashed)".'.zip';
        if ($zip_archive->open(storage_path($name_zip), ZipArchive::CREATE) == TRUE){
            $files = File::files(storage_path('app/trashed/avatars/' . Crypt::decrypt($id)));
            foreach($files as $key => $value){
                $name_file = basename($value);
                $zip_archive->addFile($value, $name_file);
            }
            $zip_archive->close();
        } else {
            dd("Não foi possível realizar a zipagem da(s) imagem(ns) de $nome_hunter, sendo esse registro localizado na lixeira.");
        }

        $data = Carbon::now()->format('d/m/Y H:i:s');
        $ip_user = request()->ip();
        $mensagem = "Foi feito a zipagem da(s) imagem(ns) de $nome_hunter que está na lixeira utilizando o IP {$ip_user} em {$data}.";
        Log::channel('logZipTrashHunter')->info($mensagem);

        $log = new LoggingModel();
        $log->descricao = $mensagem;
        $log->save();

        return response()->download(storage_path($name_zip))->deleteFileAfterSend(true);
    }

}
