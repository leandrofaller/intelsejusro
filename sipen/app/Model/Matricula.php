<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matricula';
    protected $fillable = ['id', 'nome_matricula', 'atual_matricula', 'integrante_id', 'apenado_id', 'user_id'];
}
