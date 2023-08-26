<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Console extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'marca',
        'controles',
        'armazenamento',
        'tipo_midia',
        'imagem'
    ];

    public function rules()
    {
        // regras de cada atributo
        return [
            'nome' => 'required|unique:consoles,nome,' . $this->id,
            'marca' => 'required',
            'controles' => 'required|integer',
            'armazenamento' => 'required|integer',
            'tipo_midia' => 'required',
            'imagem' => 'required|file|mimes:png'
        ];
    }

    public function feedback()
    {
        // feedback de cada regra
        return [
            'required' => 'O campo :attribute é obrigatório',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo PNG',
            'nome.unique' => 'O console já existe no banco.',
            'controles.integer' => 'A quantidade de controle precisa ser um número',
            'armazenamento.integer' => 'O valor do armazenamento precisa ser um número'
        ];
    }

    public function games()
    {
        //UM console TEM VARIOS jogos atribuidos á ele
        return $this->hasMany('App\Models\Games');
    }
}
