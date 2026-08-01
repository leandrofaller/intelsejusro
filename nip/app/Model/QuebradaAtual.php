<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QuebradaAtual extends Model
{
    protected $table = 'quebradaatual';
    protected $fillable = ['id', 'nome_atual', 'atual_atual', 'integrante_id', 'apenado_id', 'user_id'];
}
