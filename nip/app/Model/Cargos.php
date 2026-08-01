<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Cargos extends Model
{
    protected $table = 'cargos';
    protected $fillable = ['id', 'cargo_faccao_id', 'atual_cargo', 'descricao_cargo', 'integrante_id', 'apenado_id', 'user_id'];

    public static function nomeCargo($id)
    {

        $result = DB::table('cargos as c')
            ->join('cargos_faccoes as cf', 'cf.id','=','c.cargo_faccao_id')
            ->Where('c.integrante_id', $id)
            ->Where('c.atual_cargo', 'S')
            ->first();


        if (empty($result))
            return '-';
        else {
            return $result->nomecargo;
        }
    }

}
