<?php

namespace App\Http\Controllers;

use App\Http\Requests\CidadeRequest;
use App\Models\Cidade;
use Illuminate\Http\Requests;

class CidadeController extends Controller
{
    public function index()
    {
        return view('cidade.index');
    }

    public function create()
    {
        return view('cidade.create');
    }

    public function store(CidadeRequest $request)
    {
        $cidade = new Cidade();
        $cidade->nome = $request->get('nome');
        $cidade->save();

        return redirect()->route('cidade.index')->with('success', 'Cidade cadastrada com sucesso!');
}

}