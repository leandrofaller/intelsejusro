<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VisitasApenados extends Model
{
    protected $table = 'visitas_apenados';
    protected $fillable = [
        'datacadastro', 'user_id','datacancelamento','motivo', 'parentescovisita', 'apenado_id', 'visita_id'
    ];


}
