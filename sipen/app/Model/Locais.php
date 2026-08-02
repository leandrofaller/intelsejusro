<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Locais extends Model
{
    protected $table = 'locais';
    protected $fillable = ['id', 'nome_local', 'atual_local', 'integrante_id', 'apenado_id', 'user_id'];
}
