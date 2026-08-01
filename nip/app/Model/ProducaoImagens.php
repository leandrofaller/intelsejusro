<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProducaoImagens extends Model
{
    protected $table = 'producao_anexo';
    protected $fillable = ['id', 'nomeanexo', 'status', 'producao_id'];
}
