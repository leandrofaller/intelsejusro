<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
class LogCelas extends Model
{
    protected $table='log_mudancadecelas';
    protected static $SUCCESS   = 'S';
    protected static $INFO	= 'I';
    protected static $WARNING   = 'W';
    protected static $EXCEPTION = 'E';

    private function Log($alerta,  $apenado_id, $datamudanca, $unidade_id, $processo_id, $movimentacao_id, $motivomudanca, $celaDE, $celaPARA, $autorizadopor, $transferidopor, $descricao)
    {
        $log = new self;
        $log->user_id  = Auth::user() ? Auth::user()->id : null;
        $log->datamudanca  = date("Y-m-d", strtotime(str_replace('/', '-', $datamudanca)));
        $log->apenado_id  = $apenado_id;
        $log->unidade_id = $unidade_id;
        $log->processo_id  = $processo_id;
        $log->movimentacao_id  = $movimentacao_id;

           if($motivomudanca == 'Outros')
           {
               $log->motivomudanca  = $motivomudanca .' - '. $descricao;
           }else{
               $log->motivomudanca  = $motivomudanca;
           }

        $log->celaDE  = $celaDE;
        $log->celaPARA  = $celaPARA;
        $log->autorizadopor  = $autorizadopor;
        $log->transferidopor  = $transferidopor;
        $log->descricao  = $descricao;

        @$log->save();
    }

    public static function Success($apenado_id, $datamudanca, $unidade_id, $processo_id, $movimentacao_id, $motivomudanca, $celaDE, $celaPARA, $autorizadopor, $transferidopor, $descricao)
    {
        $log = new self;
        $log->Log(self::$SUCCESS, $apenado_id, $datamudanca, $unidade_id, $processo_id, $movimentacao_id, $motivomudanca, $celaDE, $celaPARA, $autorizadopor, $transferidopor, $descricao);
    }

    public static function Info($apenado_id, $datamudanca, $unidade_id, $processo_id, $movimentacao_id, $motivomudanca, $celaDE, $celaPARA, $autorizadopor, $transferidopor, $descricao)
    {
        $log = new self;
        $log->Log(self::$INFO, $apenado_id, $datamudanca, $unidade_id, $processo_id, $movimentacao_id, $motivomudanca, $celaDE, $celaPARA, $autorizadopor, $transferidopor, $descricao);
    }

    public static function Warning($apenado_id, $datamudanca, $unidade_id, $processo_id, $movimentacao_id, $motivomudanca, $celaDE, $celaPARA, $autorizadopor, $transferidopor, $descricao)
    {
        $log = new self;
        $log->Log(self::$WARNING, $apenado_id, $datamudanca, $unidade_id, $processo_id, $movimentacao_id, $motivomudanca, $celaDE, $celaPARA, $autorizadopor, $transferidopor, $descricao);
    }

    public static function Exception($apenado_id, $ex)
    {
        $log = new self;
        $mensagem  = "Caminho: {$ex->getFile()} Linha: {$ex->getLine()}\n";
        $mensagem .= "Error Mensagem: {$ex->getMessage()}";
        $log->Log(self::$EXCEPTION, $apenado_id, $mensagem);
    }

}
