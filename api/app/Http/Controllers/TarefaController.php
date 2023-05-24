<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TarefaController extends Controller
{

    public function __construct(protected Tarefa $tarefa, protected Request $request)
    {
    }

    public function index()
    {
        $tarefas = $this->tarefa::orderByDesc('updated_at')->get();
        return response()->json($tarefas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->tarefa->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $dataForm = $request->all();
        $data = $this->tarefa->create($dataForm);

        return response()->json($data, 201);
    }

    public function show(string $id)
    {
        $tarefa = $this->tarefa->findOrFail($id);
        return response()->json($tarefa);
    }

    public function update(Request $request, string $id)
    {
        $tarefa = $this->tarefa->findOrFail($id);

        $validator = Validator::make($request->all(), $this->tarefa->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $dataForm = $request->all();
        $tarefa->update($dataForm);

        return response()->json($tarefa, 200);
    }

    public function destroy(string $id)
    {
        $tarefa = $this->tarefa->findOrFail($id);
        $tarefa->delete();

        return response()->json('Tarefa excluída com sucesso');
    }
}
