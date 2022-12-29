<?php

namespace App\Http\Controllers;

use App\Models\HunterModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\HunterRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class HunterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hunter = HunterModel::paginate(5);
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
        $validacoes['propriedades'] = $validacoes;
        $path = $request->file('imagem_hunter')->store('avatars');
        if(!empty($path)){
            $validacoes['imagem_hunter'] = $path;
        } else {
            dd("Não foi possível inserir a imagem de {$validacoes['nome_hunter']}, refaça a operação.");
        }
        HunterModel::create($validacoes);
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
        $validacoes['propriedades'] = $validacoes;
        $hunter = HunterModel::find(Crypt::decrypt($id));
        if(Storage::exists($hunter->imagem_hunter)){
            Storage::delete($hunter->imagem_hunter);
            $path = $request->file('imagem_hunter')->store('avatars');
            $validacoes['imagem_hunter'] = $path;
        } else {
            dd("Não foi possível atualizar a imagem de {$validacoes['nome_hunter']}, refaça a operação.");
        }
        HunterModel::where('id', Crypt::decrypt($id))->update($validacoes);
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
        $hunter = HunterModel::find(Crypt::decrypt($id));
        $nome = DB::table('hunters')->where('id','=', Crypt::decrypt($id))->value('nome_hunter');
        HunterModel::where('id', Crypt::decrypt($id))->delete();
        if(Storage::exists($hunter->imagem_hunter)) {
            Storage::delete($hunter->imagem_hunter);
        } else {
            dd("Não foi possível excluir a imagem de $nome do projeto, refaça a operação.");
        }
        return redirect('/')->with('success_destroy',"$nome não está mais presente no sistema.");
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        if (!empty($search))
        {
            $hunter = HunterModel::where('nome_hunter','LIKE',"%{$search}%")->get();
            return view('search', compact('hunter'));
        } else {
            return redirect('/')->with('search_error',"Campo de pesquisa não aceita valores vazios ou nulos.");
        }
    }

    public function exportPDF()
    {
        $hunter = HunterModel::all();
        if ($hunter->isNotEmpty()){
            $pdf = PDF::loadView('table_export', compact('hunter'));
            return $pdf->download(Str::random(10).'.pdf');
        } else {
            return redirect('/')->with('export_pdf_error',"É necessário haver registros para exportar em arquivo PDF.");
        }
    }

}
