<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProducaoStatus extends Model
{
    protected $table = 'producao_status';
    protected $fillable = ['id', 'nomestatus'];
}
