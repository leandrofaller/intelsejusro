<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class FaccaoPossiveis extends Model
{
    protected $table = 'faccao_possiveis';
    protected $fillable = ['id', 'tipo_poss', 'status_poss'];


    //MOSTRA NOME DA CELA
    public static function nomepossivel($id)
    {
        $result = DB::table('faccao_possiveis')
            ->Where('id', $id)
            ->first();
       if (empty($result))
            return '';
        else {
            if($result->id == 1)
            return "<span class=\"label label-info arrowed\"> $result->tipo_poss </span>";
            else
            return "<span class=\"label label-warning arrowed\"> $result->tipo_poss </span>";

        }
    }
}
