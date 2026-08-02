<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdvogadosApenados extends Model
{
    protected $table = 'advogados_apenados';
    protected $fillable = [
        'datacadastro', 'user_id','datacancelamento','motivo', 'apenado_id', 'advogado_id'
    ];
}
