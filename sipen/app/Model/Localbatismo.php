<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Localbatismo extends Model
{
    protected $table = 'localbatismo';
    protected $fillable = ['id', 'nome_localbatismo', 'atual_localbatismo', 'integrante_id', 'apenado_id', 'user_id'];
}
