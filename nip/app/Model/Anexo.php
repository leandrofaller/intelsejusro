<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    protected $table = 'anexos';
    protected $fillable = [
        'id',
        'titulo',
        'tipodocumento',
        'nomearquivo',
        'datalancamento',
        'user_id',
        'apenado_id',
        'apenado_id',
        'processo_id',

    ];
}
