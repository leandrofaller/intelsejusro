<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QuebradaOrigem extends Model
{
    protected $table = 'quebradaorigem';
    protected $fillable = ['id', 'nome_origem', 'atual_origem', 'integrante_id', 'apenado_id', 'user_id'];
}
