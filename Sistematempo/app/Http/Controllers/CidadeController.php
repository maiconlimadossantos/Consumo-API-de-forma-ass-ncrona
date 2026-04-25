<?php

namespace App\Http\Controllers;

use App\Http\Requests\CidadeRequest;
use Illuminate\Http\Requests;

class CidadeController extends Controller
{
    public function index()
    {
        $cidades = \App\Models\Cidade::all();
        return view('cidade.index', compact('cidades'));
    }

    public function create()
    {
        return view('cidade.create');
    }

    public function store(CidadeRequest $request)
    {
        $cidade = new \App\Models\Cidade();
        $cidade->nome = $request->input('nome');
        $cidade->save();

        return redirect()->route('cidade.index');
    }
}
