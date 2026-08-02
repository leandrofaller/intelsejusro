<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vulgos extends Model
{
    protected $table = 'vulgos';
    protected $fillable = ['id', 'nome_vulgo', 'atual_vulgo', 'integrante_id', 'apenado_id', 'user_id'];
}
