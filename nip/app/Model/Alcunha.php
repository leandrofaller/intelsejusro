<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Alcunha extends Model
{
    protected $table = 'alcunhas';
    protected $fillable = ['id', 'nome_alcunha', 'atual_alcunha', 'apenado_id', 'user_id'];
}
