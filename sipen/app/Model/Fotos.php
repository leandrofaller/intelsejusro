<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fotos extends Model
{
    protected $table = 'fotos';
    protected $fillable = ['id', 'arquivo_foto', 'atual_foto', 'descricao_foto', 'apenado_id', 'user_id' ];
}
