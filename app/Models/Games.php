<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    use HasFactory;
    protected $fillable = [
        'console_id',
        'nome',
        'descricao',
        'imagem',
        'desenvolvedora',
        'data_lancamento'
    ];
    public function rules()
    {
        // regras de cada atributo
        return [
            'nome' => 'required|unique:games,nome,' . $this->id,
            'descricao' => 'required',
            'desenvolvedora' => 'required',
            'data_lancamento' => 'required',
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
        ];
    }

    public function console()
    {
        // UM jogo PERTECE A (ou não) um console
        return $this->belongsTo('App\Models\Console');
    }
}
