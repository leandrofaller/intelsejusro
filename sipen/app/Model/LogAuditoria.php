<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class LogAuditoria extends Model
{
    protected $table='auditoriapesquisa';
    protected static $INFO	= 'I';

    private function Log($alerta, $user_id, $apenado_id, $tipo)
    {
        $log = new self;
        $log->fk_user  = $user_id ? $user_id : Auth::user()->id;
        $log->fk_apenado  = $apenado_id;
        $log->tipo  = $tipo;
        @$log->save();
    }

    public static function Info($user_id, $apenado_id, $tipo)
    {
        $log = new self;
        $log->Log(self::$INFO, $user_id, $apenado_id, $tipo);
    }

    public static function Exception($apenado_id, $ex)
    {
        $log = new self;
        $mensagem  = "Caminho: {$ex->getFile()} Linha: {$ex->getLine()}\n";
        $mensagem .= "Error Mensagem: {$ex->getMessage()}";
        $log->Log(self::$EXCEPTION, $apenado_id, $mensagem);
    }
}
