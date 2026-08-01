<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Certidao extends Model
{
    protected $table = 'certidoes';
    protected $fillable = ['id', 'codigoapenado', 'nome', 'foto', 'execucao', 'pai',
                            'mae', 'nascimento', 'endereco', 'naturalidade', 'cpf', 'rg', 'regime', 'dataentrada',
                            'datasaida', 'comportamento', 'pads', 'relatoriosseguranca', 'solicitante',
                            'chavevalidacao', 'unidade_id', 'user_id'
    ];



}
