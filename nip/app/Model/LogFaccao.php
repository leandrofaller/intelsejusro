<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class LogFaccao extends Model
{
    protected $table='log_faccoes';
    protected static $INFO	= 'I';

    private function Log($alerta, $apenado_id, $integrante_id, $tipoalteracao, $faccaoDE, $faccaoPARA, $cargoDE, $cargoPARA)
    {
        $log = new self;
        $log->user_id  = Auth::user() ? Auth::user()->id : null;
        $log->dataalteracao  = date("Y-m-d");
        $log->apenado_id  = $apenado_id;
        $log->integrante_id  = $integrante_id;
        $log->tipoalteracao = $tipoalteracao;
        $log->faccaoDE  = $faccaoDE;
        $log->faccaoPARA  = $faccaoPARA;
        $log->cargoDE  = $cargoDE;
        $log->cargoPARA  = $cargoPARA;

        @$log->save();
    }

    public static function Info($apenado_id, $integrante_id, $tipoalteracao, $faccaoDE, $faccaoPARA, $cargoDE, $cargoPARA)
    {
        $log = new self;
        $log->Log(self::$INFO, $apenado_id, $integrante_id, $tipoalteracao, $faccaoDE, $faccaoPARA, $cargoDE, $cargoPARA);
    }

    public static function Exception($apenado_id, $ex)
    {
        $log = new self;
        $mensagem  = "Caminho: {$ex->getFile()} Linha: {$ex->getLine()}\n";
        $mensagem .= "Error Mensagem: {$ex->getMessage()}";
        $log->Log(self::$EXCEPTION, $apenado_id, $mensagem);
    }

}
