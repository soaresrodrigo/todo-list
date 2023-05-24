<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'concluido'
    ];

    public function rules()
    {
        return [
            'titulo' => 'required',
            'descricao' => 'required'
        ];
    }
}
