<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PadrinhosInterno extends Model
{
    protected $table = 'padrinhosinterno';
    protected $fillable = ['id', 'padrinho_id', 'descricao_padrinhointerno', 'integrante_id', 'apenado_id', 'user_id'];
}
