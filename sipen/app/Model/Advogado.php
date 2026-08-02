<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Advogado extends Model
{
    protected $table = 'advogados';
    protected $fillable = [
        'nomeadvogado', 'rgadvogado','cpfadvogado','oab', 'enderecoadvogado',
        'seccional', 'telefoneadvogado', 'foto', 'datacadastroadvogado'
    ];


    public function apenados()
    {
        return $this->belongsToMany('App\Model\Apenado','advogados_apenados', 'advogado_id', 'apenado_id')
            ->withPivot(['datacadastro', 'user_id', 'datacancelamento', 'motivo']);
    }

}
