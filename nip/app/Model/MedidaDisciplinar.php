<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use DB;
class MedidaDisciplinar extends Model
{

    protected $table = 'medidadisciplinar';
    protected $fillable = [
        'id',
        'tipomedida_md',
        'unidades_md',
        'datainicio_md',
        'datafim_md',
        'descricao_md',
        'ocorrencia_md',
        'plantao_md',
        'databaixa_md',
        'tempo_md',
        'descricaobaixa_md',
        'apenado_id',
        'processo_id',
        'movimentacao_id',
        'user_id',
        'unidade_id',

    ];


    //AUXILIARES
    public static $tipo = [
        '' => '',
        'Outras Unidades' => 'Outras Unidades',
        'Desobediência' => 'Desobediência',
        'Desacato' => 'Desacato',
        'Tentativa de Fuga' => 'Tentativa de Fuga',
        'Outros' => 'Outros'
    ];

    //AUXILIARES
    public static $tempo = [
        '' => '',
        '05' => '05',
        '10' => '10',
        '15' => '15',
        '20' => '20',
        '25' => '25',
        '30' => '30',
        '60' => '60',
        '90' => '90',
        '120' => '120'
    ];


    //MEDIDA DISCIPLINAR DA UNIDADE
    public static function contaMDUnidVenceHoje($date)
    {
        return $conta = DB::table('medidadisciplinar as m')
            ->Where('m.unidade_id', Auth::user()->unidade_id)
            ->Where('m.tipomedida_md', '!=', 'Outras Unidades')
            ->Where('m.databaixa_md', NULL)
            ->Where('m.datafim_md', $date)
            ->select(DB::raw("COUNT(m.id) as total"))
            ->pluck('total')[0];
    }
    public static function contaMDUnidVencido($date)
    {
        return $conta = DB::table('medidadisciplinar as m')
            ->Where('m.unidade_id', Auth::user()->unidade_id)
            ->Where('m.tipomedida_md', '!=', 'Outras Unidades')
            ->Where('m.databaixa_md', NULL)
            ->Where('m.datafim_md', '<', $date)
            ->select(DB::raw("COUNT(m.id) as total"))
            ->pluck('total')[0];
    }



    //MEDIDA DISCIPLINAR OUTRAS UNIDADES / CASTIGO
    public static function contaMDUnidVenceHojeOutras($date)
    {
        return $conta = DB::table('medidadisciplinar as m')
            ->Where('m.unidade_id', Auth::user()->unidade_id)
            ->Where('m.databaixa_md', NULL)
            ->Where('m.tipomedida_md', '=', 'Outras Unidades')
            ->Where('m.datafim_md', $date)
            ->select(DB::raw("COUNT(m.id) as total"))
            ->pluck('total')[0];
    }
    public static function contaMDUnidVencidoOutras($date)
    {
        return $conta = DB::table('medidadisciplinar as m')
            ->Where('m.unidade_id', Auth::user()->unidade_id)
            ->Where('m.tipomedida_md', '=', 'Outras Unidades')
            ->Where('m.databaixa_md', NULL)
            ->Where('m.datafim_md', '<', $date)
            ->select(DB::raw("COUNT(m.id) as total"))
            ->pluck('total')[0];
    }



    //VERIFICA SE O APENADO POSSUI ALGUMA MEDIDA DISCIPLINAR ATIVA
    public static function verificaMedidaDisciplinar($idApen)
    {
        $result = DB::table('medidadisciplinar as m')
           // ->Where('m.unidade_id', $idUnidade)
            ->Where('m.databaixa_md', NULL)
            ->Where('m.apenado_id', $idApen)
            ->get();
        if (count($result) > 0){
            return 'md';
         }else{
            return '';
        }
    }

    //LISTA TODAS AS MEDIDAS DISCIPLINAR ATIVAS
    public static function listaMedidaDisciplinarAtiva($idApen)
    {
       return $result = DB::table('medidadisciplinar as m')
            // ->Where('m.unidade_id', $idUnidade)
            ->Where('m.databaixa_md', NULL)
            ->Where('m.apenado_id', $idApen)
            ->get();
    }


}
