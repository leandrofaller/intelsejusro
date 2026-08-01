<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TokenAcesso extends Model
{
    protected $table = 'tokenacesso';
    protected $fillable = ['id', 'token', 'fk_user', 'situacao', 'created_at', 'updated_at'];
}
