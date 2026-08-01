<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FaccaoClassificacao extends Model
{
    protected $table = 'faccao_classificacao';
    protected $fillable = ['id', 'tipo_class', 'status_class', 'possivel_id'];
}
