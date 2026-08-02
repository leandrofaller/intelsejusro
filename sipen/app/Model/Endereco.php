<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos';
    protected $fillable = ['id', 'rua_endereco', 'numero_endereco', 'complemento_endereco','bairro_endereco',
                            'uf_endereco','cidade_endereco','apenado_id', 'user_id' ];

}
