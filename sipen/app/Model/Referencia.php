<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    protected $table = 'referencias';
    protected $fillable = ['id', 'nome_referencia', 'descricao_referencia', 'atual_referencia', 'integrante_id', 'apenado_id', 'user_id'];

}
