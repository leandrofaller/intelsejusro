<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracoes';
    protected $fillable = ['id', 'acao', 'email_admin', 'horainicio', 'horafim', 'titulo'];
}
