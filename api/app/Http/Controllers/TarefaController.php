<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarefas = Tarefa::all();
        return response()->json($tarefas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tarefa = new Tarefa;
        $tarefa->titulo = $request->input('titulo');
        $tarefa->descricao = $request->input('descricao');
        $tarefa->concluido = $request->input('concluido') || false;
        $tarefa->save();

        return response()->json($tarefa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        return response()->json($tarefa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->titulo = $request->input('titulo');
        $tarefa->descricao = $request->input('descricao');
        $tarefa->concluido = $request->input('concluido');
        $tarefa->save();

        return response()->json($tarefa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();

        return response()->json('Tarefa excluída com sucesso');
    }
}
