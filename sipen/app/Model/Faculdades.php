<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Faculdades extends Model
{
    protected $table = 'faculdades';
    protected $fillable = ['id', 'nome_faculdade', 'atual_faculdade', 'integrante_id', 'apenado_id', 'user_id'];
}
