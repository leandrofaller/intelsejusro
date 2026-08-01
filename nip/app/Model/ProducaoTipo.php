<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProducaoTipo extends Model
{
    protected $table = 'producao_tipo';
    protected $fillable = ['id', 'descricao', 'status'];
}
