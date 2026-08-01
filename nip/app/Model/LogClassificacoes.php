<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class LogClassificacoes extends Model
{
    protected $table='log_classificacoes';
    protected static $INFO	= 'I';

    private function Log($alerta, $user_id, $integrante_id, $faccao_possiveis_id, $faccao_classificacao_id)
    {
        $log = new self;
        $log->user_id  = $user_id ? $user_id : Auth::user()->id;
        $log->integrante_id  = $integrante_id;
        $log->faccao_possiveis_id = $faccao_possiveis_id;
        $log->faccao_classificacao_id  = $faccao_classificacao_id;
        @$log->save();
    }

    public static function Info($user_id, $integrante_id, $faccao_possiveis_id, $faccao_classificacao_id)
    {
        $log = new self;
        $log->Log(self::$INFO, $user_id, $integrante_id, $faccao_possiveis_id, $faccao_classificacao_id);
    }

    public static function Exception($integrante_id, $ex)
    {
        $log = new self;
        $mensagem  = "Caminho: {$ex->getFile()} Linha: {$ex->getLine()}\n";
        $mensagem .= "Error Mensagem: {$ex->getMessage()}";
        $log->Log(self::$EXCEPTION, $integrante_id, $mensagem);
    }
}
