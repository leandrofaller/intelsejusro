<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class Producao extends Model
{
    protected $table = 'producao';
    protected $fillable = ['id', 'seguranca', 'codigo', 'numero', 'datarelatorio', 'assunto', 'origem', 'difusao', 'difusaoanterior', 'referencia',
        'anexo', 'conteudo', 'fechamento', 'tipo_id', 'user_id', 'unidade_id', 'status_id' ];

    //AUXILIARES
    public static $seguranca = [
        'RESERVADO' => 'RESERVADO',
        'SIGILOSO' => 'SIGILOSO',
    ];




    //CONTA TIPOS
    public static function contaTipos($id)
    {

        $regiao = Unidade::where('regiao_id', Auth::user()->regiao_id)->select('id')->get();
        $perfil = Auth::user()->perfil;
        if ($perfil == 'Admin') {
            return $conta = DB::table('producao as p')
                ->Where('tipo_id', $id)
                ->select(DB::raw("COUNT(tipo_id) as total"))
                ->pluck('total')[0];
        }else{
            return $conta = DB::table('producao as p')
                ->Where('tipo_id', $id)
             //   ->WhereIn('unidade_id', $regiao)
                ->select(DB::raw("COUNT(tipo_id) as total"))
                ->pluck('total')[0];
        }
    }

    //CONTA TIPOS E STATUS
    public static function contaTipoStatus($tipo, $status)
    {
        $regiao = Unidade::where('regiao_id', Auth::user()->regiao_id)->select('id')->get();
        $perfil = Auth::user()->perfil;
        if ($perfil == 'Admin') {
            return $conta = DB::table('producao as p')
                ->Where('tipo_id', $tipo)
                ->Where('status_id', $status)
                ->select(DB::raw("COUNT(tipo_id) as total"))
                ->pluck('total')[0];
        }else{
            return $conta = DB::table('producao as p')
                ->Where('tipo_id', $tipo)
                ->Where('status_id', $status)
              //  ->WhereIn('unidade_id', $regiao)
                ->select(DB::raw("COUNT(tipo_id) as total"))
                ->pluck('total')[0];

        }

    }


}
