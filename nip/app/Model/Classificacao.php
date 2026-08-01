<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classificacao extends Model
{
    protected $table = 'classificacao';
    protected $fillable = ['id', 'sigla', 'descricao' ];

}
