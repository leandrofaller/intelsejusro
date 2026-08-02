<?php

namespace App\Model;

use App\Model\Processo;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Model\Unidade;
use Illuminate\Support\Facades\Auth;

class Apenado extends Model
{

    protected $table = 'apenados';
    protected $fillable = [
        'id',
        'nomeapenado',
        'rg',
        'cpf',
        'datanascimento',
        'nomepai',
        'nomemae',
        'sexo',
        'etnia',
        'escolaridade',
        'datacadastro',
        'naturalidade'

    ];

    public function processo(){
        return $this->hasOne('App\Model\Processo');
    }

    public function visitas()
    {
        return $this->belongsToMany('App\Model\Visita');
    }
    public function fotos()
    {
        return $this->belongsToMany('App\Model\Fotos');
    }

    //MUTATOR - TRANSFORMA TUDO EM MAIUSCULO
    public function setNomeapenadoAttribute($value){
        $this->attributes['nomeapenado'] = strtoupper($value);
    }

    //AUXILIARES
    public static $etnia = [
        '' => '',
        'Branca' => 'Branca',
        'Negra' => 'Negra',
        'Parda' => 'Parda',
        'Amarela' => 'Amarela',
        'Índigena' => 'Índigena',
        'Outras' => 'Outras',
    ];

      //AUXILIARES
    public static $escolaridade = [
        '' => '',
        'Analfabeto' => 'Analfabeto',
        'Alfabetizado' => 'Alfabetizado',
        'Fundamental Completo' => 'Fundamental Completo',
        'Fundamental Incompleto' => 'Fundamental Incompleto',
        'Médio Completo' => 'Médio Completo',
        'Médio Incompleto' => 'Médio Incompleto',
        'Superior Completo' => 'Superior Completo',
        'Superior Incompleto' => 'Superior Incompleto',
        'Pós Graduado' => 'Pós Graduado',
        'Não Informado' => 'Não Informado',

    ];

    public static $regimepena = [
        '' => '',
        'Fechado' => 'Fechado',
        'Aberto' => 'Aberto',
        'SemiAberto' => 'SemiAberto',
        'Medida de Segurança - Internação (Deficiente Físico)' => 'Medida de Segurança - Internação (Deficiente Físico)',
        'Medida de Segurança - Internação (Deficiente Mental)' => 'Medida de Segurança - Internação (Deficiente Mental)',
        'Medida de Segurança - Internação (Risco de Morte)' => 'Medida de Segurança - Internação (Risco de Morte)',
        'Medida de Segurança - Tratamento Ambulatorial' => 'Medida de Segurança - Tratamento Ambulatorial',
        'Medida de Segurança - Hospitalar' => 'Medida de Segurança - Hospitalar',
        'Não Identificado' => 'Não Identificado',
    ];

    //AUXILIARES SAÍDA DE UNIDADE
    public static $motivosaida = [
        ''   => '',
        '1'  => 'Transferência',
        '10' => 'Evasão / Abandono',
        '11' => 'Fuga',
        '4'  => 'Soltura',
        '7'  => 'Óbito',
        '14' => 'Prisão Domiciliar',
        '15' => 'Trânsito',
        '16' => 'Recambiamento - Outros Estados',

//        '13' => 'Saída Temporária',

//        '1' => 'Transferência de Unidade *',
//        '2' => 'Progressão de Regime *',
//        '3' => 'Clínica de Recuperação *',
//        '4' => 'Alvará de Soltura / Hábeas Corpus',
//        '5' => 'Indulto',
//        '6' => 'Livramento Condicional',
//        '7' => 'Óbito Criminais',
//        '8' => 'Óbito Sucídio',
//        '9' => 'Óbito Acidental',
//        '10' => 'Abandono / Evasão',
//        '11' => 'Fuga',
//        '12' => 'Quebra de Regime / Tornozeleira',


    ];

    //AUXILIARES
    public static $varas = [
        'Não Informado' => 'Não Informado',
        'ALTA FLORESTA DO OESTE - VARA ÚNICA' => 'ALTA FLORESTA DO OESTE - VARA ÚNICA',
        'ARIQUEMES - 1ª VARA CRIMINAL' => 'ARIQUEMES - 1ª VARA CRIMINAL',
        'ARIQUEMES - 2ª VARA CRIMINAL' => 'ARIQUEMES - 2ª VARA CRIMINAL',
        'ARIQUEMES - 3ª VARA CRIMINAL' => 'ARIQUEMES - 3ª VARA CRIMINAL',
        'ARIQUEMES - JUIZADO ESPECIAL CÍVEL E CRIMINAL' => 'ARIQUEMES - JUIZADO ESPECIAL CÍVEL E CRIMINAL',
        'BURITIS - 1ª VARA GENÉRICA' => 'BURITIS - 1ª VARA GENÉRICA',
        'BURITIS - 2ª VARA GENÉRICA' => 'BURITIS - 2ª VARA GENÉRICA',
        'CACOAL - 1ª VARA CRIMINAL' => 'CACOAL - 1ª VARA CRIMINAL',
        'CACOAL - 2ª VARA CRIMINAL' => 'CACOAL - 2ª VARA CRIMINAL',
        'CACOAL - JUIZADO ESPECIAL CÍVEL E CRIMINAL' => 'CACOAL - JUIZADO ESPECIAL CÍVEL E CRIMINAL',
        'CEREJEIRAS - 1ª VARA GENÉRICA' => 'CEREJEIRAS - 1ª VARA GENÉRICA',
        'CEREJEIRAS - 2ª VARA GENÉRICA' => 'CEREJEIRAS - 2ª VARA GENÉRICA',
        'COLORADO DO OESTE - 1ª VARA CRIMINAL' => 'COLORADO DO OESTE - 1ª VARA CRIMINAL',
        'ESPIGÃO DO OESTE - 1ª VARA GENÉRICA' => 'ESPIGÃO DO OESTE - 1ª VARA GENÉRICA',
        'ESPIGÃO DO OESTE - 2ª VARA GENÉRICA' => 'ESPIGÃO DO OESTE - 2ª VARA GENÉRICA',
        'GUAJARÁ MIRIM - 1ª VARA CRIMINAL' => 'GUAJARÁ MIRIM - 1ª VARA CRIMINAL',
        'GUAJARÁ-MIRIM - 2ª VARA CRIMINAL' => 'GUAJARÁ-MIRIM - 2ª VARA CRIMINAL',
        'JARU - 1ª VARA CRIMINAL' => 'JARU - 1ª VARA CRIMINAL',
        'JI-PARANÁ - 1ª VARA CRIMINAL' => 'JI-PARANÁ - 1ª VARA CRIMINAL',
        'JI-PARANÁ - 2ª VARA CRIMINAL' => 'JI-PARANÁ - 2ª VARA CRIMINAL',
        'JI-PARANÁ - 3ª VARA CRIMINAL' => 'JI-PARANÁ - 3ª VARA CRIMINAL',
        'JI-PARANÁ - JUIZADO ESPECIAL CÍVEL E CRIMINAL' => 'JI-PARANÁ - JUIZADO ESPECIAL CÍVEL E CRIMINAL',
        'MACHADINHO DO OESTE - VARA ÚNICA' => 'MACHADINHO DO OESTE - VARA ÚNICA',
        'NOVA BRASILÂNDIA DO OESTE - VARA ÚNICA' => 'NOVA BRASILÂNDIA DO OESTE - VARA ÚNICA',
        'OURO PRETO DOESTE - JUIZADO ESPECIAL CÍVEL E CRIMINAL' => 'OURO PRETO DOESTE - JUIZADO ESPECIAL CÍVEL E CRIMINAL',
        'PIMENTA BUENO - 1ª VARA CRIMINAL' => 'PIMENTA BUENO - 1ª VARA CRIMINAL',
        'PIMENTA BUENO - JUIZADO ESPECIAL CÍVEL E CRIMINAL' => 'PIMENTA BUENO - JUIZADO ESPECIAL CÍVEL E CRIMINAL',
        'PORTO VELHO - 1ª VCRIM' => 'PORTO VELHO - 1ª VCRIM',
        'PORTO VELHO - 1ª VECP' => 'PORTO VELHO - 1ª VECP',
        'PORTO VELHO - 1ª VT JÚRI' => 'PORTO VELHO - 1ª VT JÚRI',
        'PORTO VELHO - 1ª VTOX' => 'PORTO VELHO - 1ª VTOX',
        'PORTO VELHO - 1º JUIZADO ESPECIAL CRIMINAL' => 'PORTO VELHO - 1º JUIZADO ESPECIAL CRIMINAL',
        'PORTO VELHO - 2ª VCRIM' => 'PORTO VELHO - 2ª VCRIM',
        'PORTO VELHO - 2ª VT JÚRI' => 'PORTO VELHO - 2ª VT JÚRI',
        'PORTO VELHO - 2º JUIZADO DA INFÂNCIA E DA JUVENTUDE' => 'PORTO VELHO - 2º JUIZADO DA INFÂNCIA E DA JUVENTUDE',
        'PORTO VELHO - 2º JUIZADO DE VIOLÊNCIA DOMÉSTICA E FAMILIAR CONTRA A MULHER' => 'PORTO VELHO - 2º JUIZADO DE VIOLÊNCIA DOMÉSTICA E FAMILIAR CONTRA A MULHER',
        'PORTO VELHO - 3ª VCRIM' => 'PORTO VELHO - 3ª VCRIM',
        'PORTO VELHO - JUIZADO DE VIOLÊNCIA DOMÉSTICA E FAMILIAR CONTRA A MULHER' => 'PORTO VELHO - JUIZADO DE VIOLÊNCIA DOMÉSTICA E FAMILIAR CONTRA A MULHER',
        'PORTO VELHO - VARA DA AUDITORIA MILITAR' => 'PORTO VELHO - VARA DA AUDITORIA MILITAR',
        'PORTO VELHO - VEPEMA' => 'PORTO VELHO - VEPEMA',
        'PORTO VELHO - TJ' => 'PORTO VELHO - TJ',
        'PRESIDENTE MÉDICI - VARA ÚNICA' => 'PRESIDENTE MÉDICI - VARA ÚNICA',
        'ROLIM DE MOURA - JUIZADO ESPECIAL' => 'ROLIM DE MOURA - JUIZADO ESPECIAL',
        'ROLIM DE MOURA - VARA CRIMINAL' => 'ROLIM DE MOURA - VARA CRIMINAL',
        'SANTA LUZIA DO OESTE - VARA ÚNICA' => 'SANTA LUZIA DO OESTE - VARA ÚNICA',
        'SÃO MIGUEL DO GUAPORÉ - VARA ÚNICA' => 'SÃO MIGUEL DO GUAPORÉ - VARA ÚNICA',
        'VILHENA - 1ª VARA CRIMINAL' => 'VILHENA - 1ª VARA CRIMINAL',
        'VILHENA - 2ª VARA CRIMINAL' => 'VILHENA - 2ª VARA CRIMINAL',
        'VILHENA - JUIZADO ESPECIAL CÍVEL E CRIMINAL' => 'VILHENA - JUIZADO ESPECIAL CÍVEL E CRIMINAL'



    ];



    //AUXILIARES
    public static $presooriundo = [
        'Estadual' => 'Estadual',
        'Federal' => 'Federal',
    ];

    //AUXILIARES
    public static $situacao = [
        'Condenado' => 'Condenado',
        'Provisório' => 'Provisório',
    ];

    //AUXILIARES
    public static $monitorado = [
        'Não' => 'Não',
        'Sim' => 'Sim',
    ];

    //BUSCA SITUAÇÃO DO PRESO
    public static function situacaoAtual($idApen)
    {
        $result = DB::table('processos as p')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->Where('p.apenado_id', $idApen)
           // ->where('m.datasaida', null)
            ->orderby('m.id', 'desc')
            ->limit(1)
            ->first();

        if (empty($result)) {
            return 'Erro na Consulta';

        }elseif( (($result->datasaida) == NULL) and (($result->motivosaida) == NULL) and (($result->regime) != NULL) ){
            return 'Apenado Preso';

        }elseif( (($result->cela_id) == NULL) and (($result->regime) == NULL) and (($result->unidade_id) != 63) ) {
            //pode ser: 1 2 3
            return 'Aguardando Recebimento';

        }elseif( (($result->datasaida) != NULL) and (($result->motivosaida) != NULL) ){
            //pode ser tipo: 4 5 6 7 8 9
            return $result->motivosaida;
        }elseif((($result->unidade_id) == 63 )){
            //pode ser tipo: 4 5 6 7 8 9
            return 'Apenado em Trânsito';

        }elseif( (($result->datasaida) == NULL) and (($result->motivosaida) != NULL) ){
            //pode ser: 10 11 12
            return 'Sinistro';  //PODE SER FUGA / EVASÃO / QUEBRA

        }
    }


    public static function mostraFotoPrincipal($idApenado)
    {
        $result = DB::table('fotos')
            ->Where('apenado_id', $idApenado)
            ->Where('atual_foto', 'S')
            ->first();
        if (empty($result))
            return 'fotosPresos/semfoto.png';
        else {

            return $result->arquivo_foto;
        }
    }


    //BUSCA UNIDADE PRISIONAL
    public static function mostraSinistro($idApen)
    {
        $result = DB::table('fugas as f')
            ->join('apenados as a', 'f.apenado_id','=','a.id')
            ->Where('f.apenado_id', $idApen)
            ->where('f.datarecaptura', null)
            ->first();
        if (empty($result))
            return '';
        else {
           // 10 - 'Abandono / Evasão'  11 => 'Fuga', 12 => 'Quebra de Regime / Tornozeleira',
            if (($result->tipo == 10)){ return 'Evasão / Abandono'; }
            elseif(($result->tipo == 11)) { return 'Fuga'; }
            elseif(($result->tipo == 12)) { return 'Quebra de Regime'; }
            else{ return "Erro 11001";}
        }
    }

//MOSTRA UNIDADE DE ORIGEM DA TRANSFERENCIA através do processo
    public static function mostraUnidadeOrigem($id, $oficiosaida)
    {
         $result = DB::table('movimentacoes as m')
            ->join('unidades as u', 'm.unidade_id','=','u.id')
            ->Where('m.processo_id', $id)
            ->Where('m.oficiosaida', $oficiosaida)
            ->Where('m.datasaida', '!=', null )
            ->select('u.nomeunidade')
            ->first();
        if (empty($result))
            return '';
        else {
            return $result->nomeunidade;

        }
    }



//BUSCA UNIDADE PRISIONAL
    public static function mostraunidadeAtual($idApen)
    {
              $result = DB::table('processos as p')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->Where('p.apenado_id', $idApen)
                ->where('m.datasaida', null)
                ->first();
                if (empty($result))
                    return '';
                else {
                    return $result->nomeunidade;
                }
    }
    //BUSCA CELA DO PRESO
    public static function mostracelaAtual($idApen)
    {
        $result = DB::table('processos as p')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->join('celas as c', 'm.cela_id','=','c.id')
            ->Where('p.apenado_id', $idApen)
            ->where('m.datasaida', null)
            ->first();
        if (empty($result))
            return '';
        else {
            return $result->nomecela;
        }
    }




    //MOSTRA NOME DA CELA
    public static function nomecela($idCela)
    {
        $result = DB::table('celas as p')
            ->Where('p.id', $idCela)
            ->first();
        if (empty($result))
            return '';
        else {
            return $result->nomecela;
        }
    }


    //CONTA APENADO POR UNIDADE
    public static function contaApenadoUnidade($id)
    {
        return $conta = DB::table('movimentacoes as m')
            ->Where('m.unidade_id', $id)
            ->Where('m.datasaida', null)
            ->select(DB::raw("COUNT(m.unidade_id) as total"))
            ->pluck('total');
    }

    //CONTA FACCIONADOS POR UNIDADE
    public static function contaFaccionadosUnidade($id)
    {
        return $conta = DB::table('integrantes as i')
            ->join('processos as p', 'p.apenado_id','=','i.apenado_id')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->join('unidades as u', 'm.unidade_id','=','u.id')
            ->Where('u.id', $id)
            ->Where('i.datasaida', null)
            ->Where('i.faccao_possiveis_id', 1) //1=comprovado

            ->Where('m.datasaida', null)
            ->select(DB::raw("COUNT(i.id) as total"))
            ->pluck('total');
    }

    //CONTA FACCIONADOS POR UNIDADE
    public static function contaPossiveisFaccionadosUnidade($id)
    {
        return $conta = DB::table('integrantes as i')
            ->join('processos as p', 'p.apenado_id','=','i.apenado_id')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->join('unidades as u', 'm.unidade_id','=','u.id')
            ->Where('u.id', $id)
            ->Where('i.datasaida', null)
            ->Where('i.faccao_possiveis_id', '<>', 1) //1=comprovado

            ->Where('m.datasaida', null)
            ->select(DB::raw("COUNT(i.id) as total"))
            ->pluck('total');
    }

    //CONTA APENADO POR CELA
    public static function contaApenadoCela($id)
    {

        return $conta = DB::table('movimentacoes as m')
            ->join('celas as c', 'c.id', '=' , 'm.cela_id')
            // ->join('carceragens as car', 'car.id', '=' , 'm.cela_id')
            ->Where('c.id', $id)
            ->Where('m.datasaida', null)
            ->Where('m.motivosaida', null)
            ->select(DB::raw("COUNT(m.cela_id) as total"))
            ->pluck('total');

    }




    public static function contaFaccaoPredominante($id)
    {
        try {

        $conta =  DB::select('SELECT faccoes.sigla, count(integrantes.faccao_id) as total
                    FROM integrantes
                      inner join processos on processos.apenado_id = integrantes.apenado_id
                      inner join movimentacoes on movimentacoes.processo_id = processos.id
                      inner join faccoes on integrantes.faccao_id = faccoes.id
                    WHERE movimentacoes.unidade_id = ?
                    AND integrantes.faccao_possiveis_id = 1
                    AND integrantes.datasaida is null
                    GROUP BY integrantes.faccao_id
                    ORDER BY total DESC LIMIT 1',[$id]);

       return $result = $conta[0]->sigla;


        } catch (\Exception $e) {
            return '-';
        }
    }







    //BUSCA CARCERAGEM DO PRESO PELO ID - PARA RETORNAR QUAL A FACÇÃO DA MESMA
    public static function mostraFaccaoCarceragem($idApen)
    {
        $result = DB::table('processos as p')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->join('celas as c', 'm.cela_id','=','c.id')
            ->join('carceragens as cc', 'cc.id','=','c.carceragem_id')
            ->join('faccoes as f', 'f.id','=','cc.faccao')
            ->Where('p.apenado_id', $idApen)
            ->where('m.datasaida', null)
            ->first();
        if (empty($result))
            return '';
        else {
            return $result->faccao == 0 ? '' : $result->sigla;
        }
    }


}
