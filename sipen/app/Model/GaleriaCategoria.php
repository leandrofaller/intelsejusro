<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GaleriaCategoria extends Model
{
    protected $table = 'galeriacategoria';
    protected $fillable = ['id', 'nome','descricao'];
}
