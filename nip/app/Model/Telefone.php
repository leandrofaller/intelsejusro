<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $table = 'telefones';
    protected $fillable = ['id', 'ddd', 'numero_telefone', 'atual_telefone', 'integrante_id', 'apenado_id', 'user_id'];
}
