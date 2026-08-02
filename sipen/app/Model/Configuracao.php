<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Configuracao extends Model
{
    protected $table = 'configuracoes';
    protected $fillable = ['id', 'acao', 'email_admin'];


    //BUSCA UNIDADE PRISIONAL
    public static function config()
    {
        $result = DB::table('configuracoes')
            ->Where('id', 1)
            ->first();
            return $result;
    }

}


