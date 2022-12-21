<?php

namespace App\Http\Controllers;

use App\Models\HunterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\HunterRequest;
use Illuminate\Support\Facades\Crypt;

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
        $nome_hunter = DB::table('hunters')->where('id','=',Crypt::decrypt($id))->value('nome_hunter');
        HunterModel::where('id', Crypt::decrypt($id))->delete();
        return redirect('/')->with('success_destroy',"$nome_hunter não está mais presente no sistema.");
    }

}
