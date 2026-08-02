<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Integrantes extends Model
{
    protected $table = 'integrantes';
    protected $fillable = ['id', 'databatismo', 'apenado_id', 'faccao_id', 'datasaida', 'motivosaidafaccao', 'faccao_possiveis_id', 'faccao_classificacao_id'];

    //BUSCA UNIDADE PRISIONAL

    public static function mostraFaccao($idApen)
    {
        $result = DB::table('integrantes as i')
            ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
            //->join('unidades as u', 'm.unidade_id','=','u.id')
            ->Where('i.apenado_id', $idApen)
             ->where('i.datasaida', null)
            ->first();
        if (empty($result))
            return '';
        else {
            return $result->sigla;
        }
    }

    //BUSCA UNIDADE PRISIONAL

    public static function mostraCargoAtual($idIntegrante)
    {
        $result = DB::table('cargos as c')
            ->join('cargos_faccoes as cf', 'cf.id', '=', 'c.cargo_faccao_id')
            ->Where('c.integrante_id', $idIntegrante)
            ->where('c.atual_cargo', 'S')
            ->select('cf.nomecargo')
            ->first();
        if (empty($result))
            return '';
        else {
            return $result->nomecargo;
        }
    }

    public static function mostraAlcunhas($idApenado)
    {
        return $alcunhas = DB::table('alcunhas')
            ->Where('apenado_id', $idApenado)
            ->get();

    }





    public static function contaIntegrantes($idFaccao)
    {
        return $conta = DB::table('integrantes as i')
            ->join('apenados as a', 'a.id','=','i.apenado_id')
            ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
            ->join('processos as p', 'a.id','=','p.apenado_id')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->Where('i.faccao_id', $idFaccao)
            ->Where('i.datasaida', NULL )
            ->Where('i.faccao_possiveis_id', 1) //1=comprovado
            ->Where('m.datasaida', NULL )
            ->select(DB::raw("COUNT(i.faccao_id) as total"))
            ->pluck('total');
    }

    public static function contaIntegrantesGeral($idFaccao)
    {
        //CONTA TODOS OS PRESOS LANÇADOS COMO FACCIONADOS NA RESPECTIVA FACÇÃO
        return $conta = DB::table('integrantes as i')
            ->join('apenados as a', 'a.id','=','i.apenado_id')
            ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
            ->join('processos as p', 'a.id','=','p.apenado_id')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->Where('i.faccao_id', $idFaccao)
            ->Where('i.datasaida', NULL )
            ->WhereIn('i.faccao_possiveis_id', [1,2]) //1=comprovado
            ->Where('m.datasaida', NULL )
            ->select(DB::raw("COUNT(i.faccao_id) as total"))
            ->pluck('total');

    }

    public static function contaIntegrantesInvestigacao($idFaccao)
    {
        return $conta = DB::table('integrantes as i')
            ->join('apenados as a', 'a.id','=','i.apenado_id')
            ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
            ->join('processos as p', 'a.id','=','p.apenado_id')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->Where('i.faccao_id', $idFaccao)
            ->Where('i.datasaida', NULL )
            ->Where('i.faccao_possiveis_id', 2) // suspeitos
            ->Where('m.datasaida', NULL )
//            ->groupby('a.id')
            ->select(DB::raw("COUNT(i.faccao_id) as total"))
            ->pluck('total');
    }

    public static function contaIntegrantesComprovado($idFaccao)
    {
        return $conta = DB::table('integrantes as i')
            ->join('apenados as a', 'a.id','=','i.apenado_id')
            ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
            ->join('processos as p', 'a.id','=','p.apenado_id')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->Where('i.faccao_id', $idFaccao)
            ->Where('i.datasaida', NULL )
            ->Where('i.faccao_possiveis_id', 1) // mostra comprovados
            ->Where('m.datasaida', NULL )
            ->select(DB::raw("COUNT(i.faccao_id) as total"))
            ->pluck('total');

    }


    public static function contaIntegrantesUnidadePorFaccao($idUnidade, $idFaccao)
    {
        try {
        $conta = DB::table('integrantes as i')
            ->join('apenados as a', 'a.id','=','i.apenado_id')
            ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
            ->join('processos as p', 'a.id','=','p.apenado_id')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->Where('i.faccao_id', $idFaccao)
            ->Where('i.datasaida', NULL )
            ->Where('m.unidade_id', $idUnidade)
            ->Where('i.faccao_possiveis_id', 1) //1=comprovado
            ->Where('m.datasaida', NULL )
            ->select(DB::raw("COUNT(i.faccao_id) as total"))
            ->pluck('total');

         if($conta[0] == 0)
         {
            return "-";
         }else{
             return $conta;
         }

        } catch (\Exception $e) {
            return 'M';
        }
    }

    public static function mostraClassificacao($id)
    {
        $classificacao = DB::table('faccao_classificacao')
                ->Where('id',$id)
                ->select('tipo_class')
                ->first();
         if($classificacao)
         {
              return $classificacao->tipo_class;
         }else{
              return "-";
         }


    }

}
