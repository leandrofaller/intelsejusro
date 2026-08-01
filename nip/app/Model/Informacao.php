<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Informacao extends Model
{
    protected $table = 'informacoes';
    protected $fillable = ['id', 'tipo','assunto', 'descricaoinfo', 'user_id', 'apenado_id',
        'datacadastro', 'unidade_id'
    ];
}
