<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PadrinhosExterno extends Model
{
    protected $table = 'padrinhosexterno';
    protected $fillable = ['id', 'nome_padrinhoexterno', 'descricao_padrinhoexterno', 'integrante_id', 'apenado_id', 'user_id'];
}
