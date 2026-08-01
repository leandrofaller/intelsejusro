<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Nomebatismo extends Model
{
    protected $table = 'nomebatismo';
    protected $fillable = ['id', 'nome_batismo', 'atual_batismo', 'integrante_id', 'apenado_id', 'user_id'];


    public static function nomeBatismo($id)
    {
        $result = DB::table('nomebatismo')
            ->Where('integrante_id', $id)
            ->where('atual_batismo', 'S')
            ->select('nome_batismo')
            ->first();
        if (empty($result))
            return '-';
        else {
            return $result->nome_batismo;
        }
    }

}
