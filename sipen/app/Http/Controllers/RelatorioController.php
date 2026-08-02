<?php

namespace App\Http\Controllers;

use App\Classes\Relatorio;
use App\Model\Apenado;
use App\Model\Carceragem;
use App\Model\Cargos;
use App\Model\Cela;
use App\Model\Fotos;
use App\Model\Informacao;
use App\Model\LogAuditoria;
use App\Model\Movimentacao;
use App\Model\Processo;
use App\Model\Regioes;
use App\Model\Temporaria;
use App\Model\Unidade;
use Illuminate\Http\Request;
use DB, Date, Flash, Logger;
use Illuminate\Support\Facades\Auth;

class RelatorioController extends Controller
{

    public function __construct(Relatorio $relatorio, Apenado $apenado, Cela $cela, Carceragem $carceragem, Unidade $unidade, Processo $processo, Movimentacao $movimentacao)
    {
        $this->relatorio = $relatorio;
        $this->apenado = $apenado;
        $this->cela = $cela;
        $this->carceragem = $carceragem;
        $this->unidade = $unidade;
        $this->processo = $processo;
        $this->movimentacao = $movimentacao;
    }

    public function fichaGeral(Request $request){

        try{

            $id = $request->input('apenado_id');
            $v['title'] = 'Ficha - Histórico de Prisões do Apenado';
            $v['apenado'] = $this->apenado->find($id);

            $v['fotoprincipal'] = Fotos::where('apenado_id', $id)->where('atual_foto', 'S')->limit(1)->get();

            $listar = $request->input('listar');
            if(empty($listar))
            {
                Flash::warning("Oops!! Selecione Alguma das Opções.!");
                return redirect()->back();
            }
             $v['check']  = $listar;

            $v['processos'] = $this->processo->where('apenado_id', $id)
                ->orderby('principal', 'desc')
                ->get();

            $processoPrincipal = $this->processo->where('apenado_id', $id)->where('principal', 'S')
                ->select('id')
                ->first();

            $v['movimentacoes'] = $this->movimentacao->where('processo_id', $processoPrincipal->id)
                ->orderby('id', 'desc')
                ->limit(1)
                ->first();

            $v['unidade'] = $this->unidade->find($v['movimentacoes']->unidade_id);
            $v['cela'] = $this->cela->find($v['movimentacoes']->cela_id);

            $v['prisoes'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->where('a.id', $id)
                ->select('a.id as idApen', 'a.*', 'p.id as idProcesso', 'p.*'  ,'m.id as idMovimentacao', 'm.*')
                ->orderby('m.id', 'DESC' )
                ->get();

            $v['informacoes'] = Informacao::where('apenado_id', $id)->where('tipo', 'CADASTRO')->get();

            $v['logmudancacelas'] = DB::table('log_mudancadecelas as l')
                ->join('apenados as a', 'a.id','=','l.apenado_id')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('m.datasaida','=', NULL)
                ->Where('l.apenado_id','=', '' . $id . '')
               // ->Where('l.unidade_id','=',  $v['apenado']->unidade_id)
                ->select( 'l.*', 'c.nomecela')
                ->orderby('l.datamudanca', 'DESC' )
                ->get();

            $v['disciplinas'] = DB::table('medidadisciplinar as m')
                ->Where('m.apenado_id', $id )
                ->orderby('m.datainicio_md', 'DESC' )
                ->get();

            $v['pads'] = DB::table('pad as p')
                ->Where('p.apenado_id', $id )
                ->orderby('p.datainiciopad', 'DESC' )
                ->get();

            $v['visitas'] = DB::table('visitas_apenados as va')
                ->join('visitas as v', 'v.id','=','va.visita_id')
                ->Where('va.apenado_id','=', '' . $id . '')
                ->select('v.*', 'va.*')
                ->get();

            $v['advogados'] = DB::table('advogados_apenados as aa')
                ->join('advogados as ad', 'ad.id','=','aa.advogado_id')
                ->Where('aa.apenado_id','=', '' . $id . '')
                ->select('ad.id as idAdv', 'aa.id as idAdvApen', 'ad.*', 'aa.*')
                ->get();

            $v['temporarias'] = Temporaria::where('apenado_id', $id)
                ->get();

            LogAuditoria::Info(Auth::user()->id, $id, 'CADASTRO' );

            return view('ficha.geral', $v);


        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }



//    public function ficha($id){
//
//        try{
//
//            $v['title'] = 'Ficha - Resumo do Apenado';
//            $v['apenado'] = $this->apenModel->find($id);
//            //$v['processo'] = $this->processoModel->where('apenado_id', $id)->first();
//            $v['processo'] = $this->processoModel->where('apenado_id', $id)
//                ->where('principal', 'S')
//                ->orderby('id', 'desc')
//                ->limit(1)
//                ->first();
//            //$v['movimentacoes'] = $this->movimentacaoModel->where('datasaida', null)->where('processo_id', $v['processo']->id)->first();
//            $v['movimentacoes'] = $this->movimentacaoModel->where('processo_id', $v['processo']->id)
//                ->orderby('id', 'desc')
//                ->limit(1)
//                ->first();
//            $v['unidade'] = $this->unidadeModel->find($v['movimentacoes']->unidade_id);
//            $v['cela'] = $this->celaModel->find($v['movimentacoes']->cela_id);
//            $v['integrante'] = $this->integranteModel->where('apenado_id', $id)->first();
//            if(!empty($v['integrante']))
//            {
//                $v['faccao'] = $this->faccaoModel->where('id', $v['integrante']->faccao_id)->first();
//                $v['cargofaccao'] = $this->cargofaccaoModel->where('id', $v['integrante']->cargo_faccao_id)->first();
//
//            }
//            else{
//                $v['faccao'] = '';
//            }
//
//            $v['visitas'] = DB::table('visitas_apenados as va')
//                ->join('visitas as v', 'v.id','=','va.visita_id')
//                ->Where('va.apenado_id','=', '' . $id . '')
//                ->select('v.*', 'va.*')
//                ->get();
//
//            $v['advogados'] = DB::table('advogados_apenados as aa')
//                ->join('advogados as ad', 'ad.id','=','aa.advogado_id')
//                ->Where('aa.apenado_id','=', '' . $id . '')
//                ->select('ad.id as idAdv', 'aa.id as idAdvApen', 'ad.*', 'aa.*')
//                ->get();
//
//            return view('apenados.ficha', $v);
//
//        } catch (\Exception $e) {
//            return $e;
//            $this->$v->GetExeption($e);
//            return redirect()->back();
//        }
//    }



    public function recebimentoGeral()
    {
        try
        {

            $v['titulo'] = " RECEBIMENTO DE APENADOS";
            $v['subtitulo'] = " Relação de Apenados Aguardando Recebimento";

            //MOSTRA APENADOS QUE ESTÃO AGUARDANDO RECEBIMENTO NA UNIDADE
            $v['presos'] = DB::table('processos as p')
                ->join('apenados as a', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
               // ->Where('m.unidade_id', $idUnid)
                ->Where('m.cela_id', NULL)
                ->where('m.regime', '')
                ->select('a.id as idApen', 'a.nomeapenado', 'm.dataentrada', 'm.unidade_id', 'p.id as idProc', 'p.artigos', 'p.numeroprocesso', 'm.oficioentrada')
                ->orderby('a.nomeapenado', 'desc')
                ->get();

            return view('relatorios.recebimentoGeral', $v);
        }
        catch (\Exception $e)
        {

        }
    }

    public function movimentacoesAdmin(Request $request)
    {
        try{
            $v['titulo'] = " RELATÓRIOS DE MOVIMENTAÇÕES";
            $v['subtitulo'] = " Entradas e Saídas - Geral por Unidade";
            $v['exibe'] = false;
            $v['unidades'] = $this->unidade->where('recebeapenados', 'Sim')->orderBy('nomeunidade')->get();

            if ($request->has('unidade_id') && $request->has('tipo') && $request->has('datainicio') && $request->has('datafim') )
            {
                $idUnid = $request->input('unidade_id');
                $tipo = $request->input('tipo');
                $datainicio =  date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datainicio') )));
                $datafim =  date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datafim') )));
                $v['exibe'] = true;

                if($tipo == 'Entradas'){

                    $v['presos'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        ->Where('m.unidade_id','=', $idUnid )
                        ->WhereBetween('m.dataentrada', array($datainicio, $datafim))
                        ->select('a.id as idApen', 'a.*', 'p.id as idProcesso', 'p.*'  ,'m.id as idMovimentacao', 'm.*')
                        ->orderby('a.nomeapenado', 'ASC' )
                        ->get();
                }else{

                    $v['presos'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        ->Where('m.unidade_id','=', $idUnid )
                        ->WhereBetween('m.datasaida', array($datainicio, $datafim))
                        ->select('a.id as idApen', 'a.*', 'p.id as idProcesso', 'p.*'  ,'m.id as idMovimentacao', 'm.*')
                        ->orderby('a.nomeapenado', 'ASC' )
                        ->get();

                }

            }

            return view('relatorios.movimentacoesAdmin', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }




    public function buscaFaccionado(Request $request)
    {
        try{
            $v['titulo'] = "PESQUISA FACCIONADOS POR PARAMETROS";
            $v['subtitulo'] = "Listagem";
            $v['exibe'] = false;

            if ($request->has('parametro') && $request->has('tipo') ) {

                $tipo = $request->input('tipo');
                $v['exibe'] = true;
                if ($tipo == 'Nome') {

                    $v['presos'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                     //   ->join('integrantes as i', 'i.apenado_id','=','a.id')
                        ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orderby('a.nomeapenado', 'ASC' )
                        ->groupby('a.id')
                        ->select('a.id as idApen', 'a.*', 'm.*', 'p.*' )
                        ->get();

                } elseif ($tipo == 'Alcunha/Vulgo') {

                    $v['presos'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        ->join('alcunhas as al', 'al.apenado_id','=','a.id')
                        ->Where('al.nome_alcunha', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orderby('a.nomeapenado', 'ASC' )
                        ->groupby('a.id')
                        ->select('a.id as idApen', 'a.*', 'm.*', 'p.*', 'al.*' )
                        ->get();

                } elseif ($tipo == 'Batismo') {

                    $v['presos'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        ->join('nomebatismo as n', 'n.apenado_id','=','a.id')
                        ->Where('n.nome_batismo', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orderby('a.nomeapenado', 'ASC' )
                        ->groupby('a.id')
                        ->select('a.id as idApen', 'a.*', 'm.*', 'p.*', 'n.*' )
                        ->get();


                } elseif ($tipo == 'Matricula') {

                    $v['presos'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        ->join('matricula as n', 'n.apenado_id','=','a.id')
                        ->Where('n.nome_matricula', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orderby('a.nomeapenado', 'ASC' )
                        ->groupby('a.id')
                        ->select('a.id as idApen', 'a.*', 'm.*', 'p.*','n.*' )
                        ->get();

                } elseif ($tipo == 'Telefone') {

                    $v['presos'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        ->join('telefones as t', 't.apenado_id','=','a.id')
                        ->Where('t.numero_telefone', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orderby('a.nomeapenado', 'ASC' )
                        ->groupby('a.id')
                        ->select('a.id as idApen', 'a.*', 'm.*', 'p.*','t.*' )
                        ->get();

                } elseif ($tipo == 'Cpf') {

                    $v['presos'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        //   ->join('integrantes as i', 'i.apenado_id','=','a.id')
                        ->Where('a.cpf', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orderby('a.nomeapenado', 'ASC' )
                        ->groupby('a.id')
                        ->select('a.id as idApen', 'a.*', 'm.*', 'p.*' )
                        ->get();

                }
            }
            return view('relatorios.buscaFaccionado', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }




   public function faccionados(Request $request)
   {
       try{
           $v['titulo'] = " RELATÓRIOS DE FACCIONADOS";
           $v['subtitulo'] = "Relatórios";
           $v['exibe'] = false;
           $v['unidades'] = $this->unidade->where('recebeapenados', 'Sim')->orderBy('nomeunidade')->get();
           $v['cidades'] = $this->unidade->where('recebeapenados', 'Sim')->orderBy('cidadeunidade')->groupby('cidadeunidade')->get();
           $v['sinpes'] = Regioes::where('status', 'A')->orderBy('nomeregiao', 'ASC')->get();
           $v['cargos'] = DB::table('faccoes as f')
               ->join('cargos_faccoes as cf', 'f.id','=','cf.faccao_id')
              ->select(DB::raw('CONCAT(f.sigla, "=>", cf.nomecargo) AS nomecargo'), 'cf.id')
               ->orderby('f.sigla', 'cf.nomecargo', 'ASC' )
               ->get();

           $unidade = $request->input('nomeunidade');
           $cidade = $request->input('cidadeunidade');
           $cargo = $request->input('nomecargo');
           $nomeregiao = $request->input('nomeregiao');
           $visualizacao = $request->input('visualizacao');

            //TODOS
           if ((!empty($unidade)) && (!empty($cidade)) && (!empty($cargo)) && (!empty($nomeregiao)) )
           {
               $v['exibe'] = true;
           //   return "TODOS";
           }

            //UNIDADES
           if ((!empty($unidade)) && (empty($cidade)) && (empty($cargo)) && (empty($nomeregiao)) )
           {
               $v['exibe'] = true;
              // return "SÓ UNIDADE";
               $v['presos'] = DB::table('integrantes as i')
                   ->join('apenados as a', 'i.apenado_id','=','a.id')
                   ->join('processos as p', 'p.apenado_id','=','i.apenado_id')
                   ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                   ->join('unidades as u', 'm.unidade_id','=','u.id')
                 //  ->join('cargos as c', 'c.integrante_id','=','i.id')
                   ->Where('i.datasaida', NULL )
                   ->Where('m.unidade_id', $unidade)
                   ->Where('m.datasaida', null)
                   ->Where('i.faccao_possiveis_id', 1) //1=comprovado
                   ->select('a.id as idApen', 'a.*', 'i.id as idIntegrante', 'i.*', 'u.cidadeunidade' )
                   ->get();

           }
           if ((!empty($unidade)) && (!empty($cidade)) && (empty($cargo)) && (empty($nomeregiao)) )
           {
               $v['exibe'] = true;
              // return "SÓ UNIDADE / CIDADE";
               $v['presos'] = DB::table('integrantes as i')
                   ->join('apenados as a', 'i.apenado_id','=','a.id')
                   ->join('processos as p', 'p.apenado_id','=','i.apenado_id')
                   ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                   ->join('unidades as u', 'm.unidade_id','=','u.id')
               //    ->join('cargos as c', 'c.integrante_id','=','i.id')
                   ->Where('u.id', $unidade)
                   ->Where('u.cidadeunidade', $cidade)
                   ->Where('m.datasaida', null)
                   ->select('a.id as idApen', 'a.*', 'i.id as idIntegrante', 'i.*' )
                   ->get();
           }
           if ((!empty($unidade)) && (!empty($cidade)) && (!empty($cargo)) && (empty($nomeregiao)) )
           {
               $v['exibe'] = true;
            //   return "SÓ UNIDADE / CIDADE / CARGO";
           }
           if ((!empty($unidade)) && (!empty($cidade)) && (empty($cargo)) && (!empty($nomeregiao)) )
           {
               $v['exibe'] = true;
            //   return "SÓ UNIDADE / CIDADE / CARGO";
           }
           if ((!empty($unidade)) && (empty($cidade)) && (!empty($cargo)) && (empty($nomeregiao)) )
           {
               $v['exibe'] = true;
             //  return "SÓ UNIDADE / CARGO";
           }
           if ((!empty($unidade)) && (empty($cidade)) && (empty($cargo)) && (!empty($nomeregiao)) )
           {
               $v['exibe'] = true;
            //   return "SÓ UNIDADE / REGIAO";
           }

           //CIDADES
           if ((empty($unidade)) && (!empty($cidade)) && (empty($cargo)) && (empty($nomeregiao)) )
           {
               $v['exibe'] = true;
              // return "SÓ CIDADE ";
               $v['presos'] = DB::table('integrantes as i')
                   ->join('apenados as a', 'i.apenado_id','=','a.id')
                   ->join('processos as p', 'p.apenado_id','=','i.apenado_id')
                   ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                   ->join('unidades as u', 'm.unidade_id','=','u.id')
                   ->Where('u.cidadeunidade', $cidade)
                   ->Where('i.datasaida', null)
                   ->Where('m.datasaida', null)
                   ->select('a.id as idApen', 'a.*', 'i.id as idIntegrante', 'i.*', 'u.cidadeunidade' )
                   ->get();

           }
           if ((empty($unidade)) && (!empty($cidade)) && (!empty($cargo)) && (!empty($nomeregiao)) )
           {
               $v['exibe'] = true;
           //    return "SÓ CIDADE / CARGO / REGIÃO";
           }
           if ((empty($unidade)) && (!empty($cidade)) && (!empty($cargo)) && (empty($nomeregiao)) )
           {
               $v['exibe'] = true;
           //    return "SÓ CIDADE / CARGO";
           }
           if ((empty($unidade)) && (!empty($cidade)) && (empty($cargo)) && (!empty($nomeregiao)) )
           {
               $v['exibe'] = true;
            //   return "SÓ CIDADE / REGIÃO";
           }

           //CARGOS
           if ((empty($unidade)) && (empty($cidade)) && (!empty($cargo)) && (empty($nomeregiao)) )
           {
               $v['exibe'] = true;
               //return "SÓ CARGO ";
               $v['presos'] = DB::table('integrantes as i')
                   ->join('apenados as a', 'i.apenado_id','=','a.id')
                   ->join('processos as p', 'p.apenado_id','=','i.apenado_id')
                   ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                   ->join('unidades as u', 'm.unidade_id','=','u.id')
                   ->join('cargos as c', 'c.integrante_id','=','i.id')
                   ->Where('c.cargo_faccao_id', $cargo)
                   ->Where('m.datasaida', null)
                   ->select('a.id as idApen', 'a.*', 'i.id as idIntegrante', 'i.*', 'u.cidadeunidade' )
                   ->get();
           }
           if ((empty($unidade)) && (empty($cidade)) && (!empty($cargo)) && (!empty($nomeregiao)) )
           {
               $v['exibe'] = true;
            //   return "SÓ CARGO e REGIÃO";
           }

           //REGIÃO
           if ((empty($unidade)) && (empty($cidade)) && (empty($cargo)) && (!empty($nomeregiao)) )
           {
               $v['exibe'] = true;
               //return "SÓ REGIÃO";
               $v['presos'] = DB::table('integrantes as i')
                   ->join('apenados as a', 'i.apenado_id','=','a.id')
                   ->join('processos as p', 'p.apenado_id','=','i.apenado_id')
                   ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                   ->join('unidades as u', 'm.unidade_id','=','u.id')
                   ->Where('u.regiao_id', $nomeregiao)
                   ->Where('i.datasaida', null)
                   ->Where('m.datasaida', null)
                   ->select('a.id as idApen', 'a.*', 'i.id as idIntegrante', 'i.*', 'u.cidadeunidade' )
                   ->get();
           }


//
//           if ($request->has('nomeunidade') && $request->has('tipo') && $request->has('datainicio') && $request->has('datafim') )
//           {
//               $v['exibe'] = true;
//           }

           $v['visualizacao'] = $visualizacao;

           return view('relatorios.faccionados', $v);

       } catch (\Exception $e) {
           return $e;
           $this->$v->GetExeption($e);
           return redirect()->back();
       }
   }




    public function movimentacoesUnidade(Request $request)
    {
        try{
            $v['titulo'] = " RELATÓRIOS DE MOVIMENTAÇÕES";
            $v['subtitulo'] = " Entradas e Saídas";
            $v['exibe'] = false;
            $idUnid = Auth::user()->unidade_id;

            if ($request->has('tipo') && $request->has('datainicio') && $request->has('datafim') )
            {
                $tipo = $request->input('tipo');
                $datainicio =  date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datainicio') )));
                $datafim =  date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datafim') )));
                $v['exibe'] = true;

                if($tipo == 'Entradas'){

                    $v['presos'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        ->Where('m.unidade_id','=', $idUnid )
                       // ->WhereBetween('m.dataentrada', array($datainicio, $datafim))
                        ->Where('m.dataentrada', '>=', $datainicio)
                        ->Where('m.dataentrada', '<=', $datafim)
                        ->select('a.id as idApen', 'a.*', 'p.id as idProcesso', 'p.*'  ,'m.id as idMovimentacao', 'm.*')
                        ->orderby('a.nomeapenado', 'ASC' )
                        ->get();
                }else{

                    $v['presos'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        ->Where('m.unidade_id','=', $idUnid )
                        //->WhereBetween('m.datasaida', array($datainicio, $datafim))
                        ->Where('m.datasaida', '>=', $datainicio)
                        ->Where('m.datasaida', '<=', $datafim)
                        ->select('a.id as idApen', 'a.*', 'p.id as idProcesso', 'p.*'  ,'m.id as idMovimentacao', 'm.*')
                        ->orderby('a.nomeapenado', 'ASC' )
                        ->get();

                }

            }

            return view('relatorios.movimentacoesUnidade', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }


    public function temporariasUnidade(Request $request)
    {
        try{
            $v['titulo'] = " RELATÓRIOS DE MOVIMENTAÇÕES TEMPORÁRIAS";
            $v['subtitulo'] = " Permissão de Saída e Saída Temporária";
            $v['exibe'] = false;
            $idUnid = Auth::user()->unidade_id;

            if ( $request->has('datainicio') && $request->has('datafim') )
            {
                $datainicio =  date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datainicio') )));
                $datafim =  date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datafim') )));
                $v['exibe'] = true;

                $v['presos'] = DB::table('apenados as a')
                    ->join('processos as p', 'a.id','=','p.apenado_id')
                    ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                    ->join('temporarias as t', 't.movimentacao_id','=','m.id')
                    ->Where('m.unidade_id','=', $idUnid )
                    // ->WhereBetween('m.dataentrada', array($datainicio, $datafim))
                    ->Where('t.datasaida', '>=', $datainicio)
                    ->Where('t.datasaida', '<=', $datafim)
                    ->select('a.id as idApen', 'a.nomeapenado', 't.*')
                    ->orderby('a.nomeapenado', 'ASC' )
                    ->get();



            }

            return view('relatorios.temporariasUnidade', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }




    public function capacidadeCelas(Request $request)
    {
        try{
            $v['titulo'] = " RELATÓRIOS - CAPACIDADES DE CELAS";
            $v['subtitulo'] = " Capacidades de Apenados por Celas";
            $v['exibe'] = false;

            $v['unidades'] = $this->unidade->where('recebeapenados', 'Sim')->orderBy('nomeunidade')->get();

            if ( $request->has('unidade_id') )
            {
                $idUnid = $request->input('unidade_id');
                $v['exibe'] = true;
                    $v['celas'] = DB::table('celas as c')
                        ->join('carceragens as ca', 'ca.id','=','c.carceragem_id')
                        ->join('unidades as u', 'u.id','=','ca.unidade_id')
                        ->Where('u.id','=', $idUnid )
                        ->select('c.*', 'ca.nomecarceragem')
                        ->orderby('c.nomecela', 'ASC' )
                        ->get();
            }

            return view('relatorios.capacidadeCelas', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }



    public function integrantesFaccao_pdf(Request $request, $id)
    {
        //BLOCO DE VALIDAÇÃO PARA MOSTRAR SOMENTE OS APENADOS DA UNIDADE DO USUÁRIO
        $idUnidadeUser = Auth::user()->unidade_id;
        $perfil = Auth::user()->perfil;

        if($perfil == 'Admin')
        {
                $v['apenados'] = DB::table('apenados as a')
                    ->join('integrantes as i', 'i.apenado_id', '=', 'a.id')
                    ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
                    ->join('cargos_faccoes as cf', 'cf.id', '=', 'i.cargo_faccao_id')
                    ->join('processos as p', 'a.id','=','p.apenado_id')
                    ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                    ->join('unidades as u', 'm.unidade_id','=','u.id')
                    ->Where('f.id', $id )
                    ->Where('i.datasaida', NULL)
                    ->Where('i.faccao_possiveis_id', 1) //1=comprovado
                    ->Where('m.datasaida', NULL )
                    ->groupby('a.id')
                    ->select('a.id as idApen', 'a.nomeapenado', 'a.alcunha', 'u.cidadeunidade', 'u.nomeunidade', 'f.nomefaccao','cf.nomecargo')
                    ->orderby('a.nomeapenado', 'asc')
                    ->get();
        }else{
            $v['apenados'] = DB::table('apenados as a')
                ->join('integrantes as i', 'i.apenado_id', '=', 'a.id')
                ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
                ->join('cargos_faccoes as cf', 'cf.id', '=', 'i.cargo_faccao_id')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->Where('f.id', $id )
                ->Where('i.datasaida', NULL)
                ->Where('i.faccao_possiveis_id', 1) //1=comprovado
                ->Where('m.datasaida', NULL )
                ->groupby('a.id')
                ->Where('m.unidade_id','=', '' . $idUnidadeUser . '' )
                ->select('a.id as idApen', 'a.nomeapenado', 'a.alcunha', 'u.cidadeunidade', 'u.nomeunidade', 'f.nomefaccao','cf.nomecargo')
                ->orderby('a.nomeapenado', 'asc')
                ->get();
        }



        $conteudo_html =
            '<table width="100%" border="0" cellspacing="0" cellpadding="3">'.
            '<tr>' .
            '<td style="text-align:center; width:15%;">' .
            '<img src="../public/logo_estado.png" width="70px" height="45px"></td>' .
            '<td colspan="10" style="text-align:center; font-size:12px; padding: 0px, 0px,0px,0px; width:70%;">' .
            '<p> <strong> GOVERNO DO ESTADO DE RONDÔNIA </strong> </p>' .
            '<p> <strong> SECRETARIA DE ESTADO DE JUSTIÇA </strong> </p>' .
            '<p> <strong> RELAÇÃO DE FACCIONADOS </strong> </p>' .
            '</td>' .
            '<td style="text-align:center; width:15%;">' .
            '<img src="../public/sejus-ro.png" width="40px" height="60px"> </td>' .
            '</tr>' .
            '</table>'
        ;

//        $conteudo_html .=
//            '<h2 style="text-align: center;"> DECLARAÇÃO DE REMIÇÃO DE PENA - '. strtoupper($modPrincip->tipomodalidades->modalidade) .' </h2>'
//        ;



        if (count($v['apenados'])>0) {

            $conteudo_html .= $this->relatorio->table_padrao_pdf_html().
                $this->relatorio->tr_header_table_padrao_pdf().
                '<th style="width:10%;"><b>COMARCA</b></th>' .
                '<th style="width:40%;"><b>NOME</b></th>' .
                '<th style="width:10%;"><b>ALCUNHA</b></th>' .
                '<th style="width:20%;"><b>UNIDADE PRISIONAL</b></th>' .
                '<th style="width:10%;"><b>FACCAO</b></th>' .
                '<th style="width:10%;"><b>CARGO</b></th>' .
                '</tr>';

            foreach ($v['apenados'] as $apenado) {

                $conteudo_html .=
                    '<tr>' .
                    '<td align="left" style="font-size: 9px;" > ' . $apenado->cidadeunidade . ' </td>' .
                    '<td align="left" style="font-size: 9px;" >' . $apenado->nomeapenado . '</td>'.
                    '<td align="left" style="font-size: 9px;" >' . $apenado->alcunha . '</td>' .
                    '<td align="left" style="font-size: 9px;" >' . $apenado->nomeunidade . '</td>' .
                    '<td align="left" style="font-size: 9px;" >' . $apenado->nomefaccao . '</td>' .
                    '<td align="left" style="font-size: 9px;" >' . $apenado->nomecargo . '</td>' .
                    '</tr>'
                ;
            }
            ;


            $conteudo_html .= '</table>';




        }else{
            $conteudo_html .=
                '<h4 class="well well-sm text-center text-danger">'.
                'Sem Apenados Faccionados.'.
                '</h4>'
            ;

        }

        $conteudo_html .=
            '<br><br><p align="right" > Total Geral, '. count($v['apenados']) .'</p>'
        ;

        $conteudo_html .=
            '<br><br><p align="right" > Porto Velho, '. \Jenssegers\Date\Date::now()->format('j F Y') .'</p>'
        ;

        Logger::Success('Relatório de Apenados Faccionados','Faccção : '.$apenado->nomefaccao.'  Data Emissão: ' .date('d-m-y'). ' Servidor: ' .Auth::user()->nome);
        return $this->relatorio->gerar_pdf_paisagem('Relatorio_faccao', $conteudo_html, 'Relatorio_faccao_' );




    }

    public function atividade_pdf($id)
    {
        try{

            $v['apenados'] = DB::table('apenados as a')
                ->join('atividades as ati', 'ati.apenado_id','=','a.id')
                ->join('tipomodalidades as tm', 'tm.id','=','ati.tipomodalidade_id')
                ->join('celas as c', 'c.id','=','a.cela_id')
                ->Where('ati.tipomodalidade_id','=', '' . $id . '')
                ->Where('ati.datafim', null)
                ->orderby('c.nomecela', 'asc')
                ->orderby('a.nomeapenado', 'asc')
                ->select('a.*', 'ati.datainicio', 'ati.datafim', 'ati.remir', 'c.nomecela', 'tm.modalidade')
                ->get();
            $modalidade = $this->tipomodalidade->find($id);

            $conteudo_html =
                '<table width="100%" border="0" cellspacing="0" cellpadding="3">'.
                '<tr>' .
                '<td colspan="10" style="text-align:center; font-size:12px; padding: 0px, 0px,0px,0px; width:70%;">' .
                '<p style="text-align:left;" > <strong> LABORAIS -  ' . $modalidade->modalidade . '</strong> </p>' .
                '<p style="text-align:left;">  DATA: ____/____/_________  </p>' .
                '</td>' .
                '</tr>' .
                '</table>'
            ;


            if (count($v['apenados'])>0) {


                $conteudo_html .= $this->relatorio->table_padrao_pdf_html().
                    $this->relatorio->tr_header_table_padrao_pdf().
                    '<th style="width:40%;"><b>NOME APENADO</b></th>' .
                    '<th style="width:10%;"><b>CELA</b></th>' .
                    '<th style="width:50%;"><b> </b></th>' .
                    '</tr>';

                foreach ($v['apenados'] as $apenado) {

                    $conteudo_html .=
                        '<tr>' .
                        '<td align="left" style="font-size: 10px;" >'. $apenado->nomeapenado.'</td>' .
                        '<td align="center" style="font-size: 10px;" >'. $apenado->nomecela.'</td>'.
                        '<td align="center" style="font-size: 10px;" > </td>' .
                        '</tr>'
                    ;
                }
                ;

                $conteudo_html .= '</table>';

            }else{
                $conteudo_html .=
                    '<h4 class="well well-sm text-center text-danger">'.
                    'Sem Apenado para artesanato.'.
                    '</h4>'
                ;

            }


            $conteudo_html .=
                '<br><br><p align="right" > Porto Velho, '. \Jenssegers\Date\Date::now()->format('j F Y') .'</p>'
            ;


            Logger::Success('Relação Artesanato','Anotação da Produção ' .date('d-m-y'). ' Servidor: ' .Auth::user()->nome);
            return $this->relatorio->gerar_pdf_retrato('Relação de Produção Artesanato', $conteudo_html, 'Relacao_' );

        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }



    }

    public function geraRemissaoArtesanato_pdf(Request $request, $id, $ano){

        try{
            $apenado = $this->apenado->find($id);

            $v['listameses'] = DB::table("lancamentos")->where('apenado_id', $id)
                ->whereYear('datalancamento', $ano)
                ->orderBy("datalancamento")
                ->groupBy(DB::raw("month(datalancamento)"))
                ->select(DB::raw("SUM(tempo) as somatempo, lancamentos.*"))
                ->get();

            $modPrincip = $this->atividade->whereapenado_id($id)->whereremir('SIM')->wheredatafim(null)->first();


            $conteudo_html =
                '<table width="100%" border="0" cellspacing="0" cellpadding="3">'.
                '<tr>' .
                '<td style="text-align:center; width:15%;">' .
                '<img src="../public/logo_estado.png" width="70px" height="45px"></td>' .
                '<td colspan="10" style="text-align:center; font-size:12px; padding: 0px, 0px,0px,0px; width:70%;">' .
                '<p> <strong> GOVERNO DO ESTADO DE RONDÔNIA </strong> </p>' .
                '<p> <strong> SECRETARIA DE ESTADO DE JUSTIÇA </strong> </p>' .
                '<p> <strong>' . strtoupper($apenado->unidades->nomeunidade) . ' </strong> </p>' .
                '</td>' .
                '<td style="text-align:center; width:15%;">' .
                '<img src="../public/sejus-ro.png" width="40px" height="60px"> </td>' .
                '</tr>' .
                '</table>'
            ;

            $conteudo_html .=
                '<h2 style="text-align: center;"> DECLARAÇÃO DE REMIÇÃO DE PENA - '. strtoupper($modPrincip->tipomodalidades->modalidade) .' </h2>'
            ;

            if(strtoupper($modPrincip->tipomodalidades->modalidade) == 'ARTESANATO')
            {
                $conteudo_html .=
                    '<h2 style="text-align: center;"> PORTARIA N 3158/GERES/GAB/SEJUS, DE 12/09/2016 </h2>'
                ;
            }

            $conteudo_html .=
                '<p>  </p>'.
                '<p style="text-align: left;">Número do Processo: <strong> '. $apenado->processo .' </strong> </p>'
            ;

            $conteudo_html .=
                '<p> </p>'.
                '<p style="text-align: left"> O diretor da (o) <strong> '. strtoupper($apenado->unidades->nomeunidade).' </strong> '.
                'no uso das atribuições legais que lhe são conferidas em Lei, </p>' .
                '<p> DECLARA que o reeducando <strong> '.strtoupper($apenado->nomeapenado).' </strong>, enquanto recolhido nesta Unidade ' .
                'Prisional, desenvolveu atividades laborais conforme descriminado no calendário abaixo:</h4> </p>'
            ;

            $conteudo_html .=
                '<p> Ano: '. $ano .' </p>'
            ;




            if (count($v['listameses'])>0) {

                $totaltempo = 0; $totalremir = 0; $tt = 0; $tr = 0;

                $conteudo_html .= $this->relatorio->table_padrao_pdf_html().
                    $this->relatorio->tr_header_table_padrao_pdf().
                    '<th style="width:40%;"><b>MÊS</b></th>' .
                    '<th style="width:30%;"><b>DIAS TRABALHADOS</b></th>' .
                    '<th style="width:30%;"><b>CONVERSÃO (Remissão)</b></th>' .
                    '</tr>';

                foreach ($v['listameses'] as $lista) {

                    $diasmes = diasMes(date('m', strtotime($lista->datalancamento)),$ano);
                    $fator = $diasmes / 10;
                    $tt = $lista->somatempo;
                    $tr = number_format(($tt / $fator),2);

                    $conteudo_html .=
                        '<tr>' .
                        '<td align="left" style="font-size: 10px;" >'.verificaMes(date('m', strtotime($lista->datalancamento))).'</td>' .
                        '<td align="center" style="font-size: 10px;" >'.$tt.'</td>'.
                        '<td align="center" style="font-size: 10px;" >'. $tr.'</td>' .
                        '</tr>'
                    ;
                    $totaltempo = $totaltempo + $tt;
                    $totalremir = $totalremir + $tr;
                }
                ;

                $conteudo_html .=
                    '<tr style="font-weight: bold; font-size: 12px; background-color: #ddd; ">' .
                    '<td align="left" >Total Geral</td>' .
                    '<td align="center">' . $totaltempo . '</td>' .
                    '<td align="center">' . $totalremir . '</td>' .
                    '</tr>';
                ;
                $conteudo_html .= '</table>';

            }else{
                $conteudo_html .=
                    '<h4 class="well well-sm text-center text-danger">'.
                    'Sem lançamentos de Remissão para este Reeducando.'.
                    '</h4>'
                ;

            }


            $conteudo_html .=
                '<br><br><p align="right" > Porto Velho, '. \Jenssegers\Date\Date::now()->format('j F Y') .'</p>'
            ;

            $conteudo_html .=
                '<p></p>'.
                '<p></p>'.
                '<p></p>'.
                '<p></p>'.
                '<p></p>'.
                '<span style="text-align: center;"> '. strtoupper($apenado->unidades->nomeresponsavel).' </span> <br>'.
                '<span style="text-align: center;"> '. strtoupper($apenado->unidades->funcao).' </span> <br>'.
                '<span style="text-align: center;"> '. strtoupper($apenado->unidades->matricularesp).' </span> <br><br>'
            ;

            $chave = geraChave($apenado->id);
            $conteudo_html .=
                '<span style="text-align: right;"> Chave de Validação : [ ' . $chave .' ] </span> <br>'
            ;

            RegCertidao::Success($apenado->nomeapenado, $ano, $totaltempo, $totalremir, $apenado->unidades->nomeunidade, $apenado->unidade_id, $modPrincip->tipomodalidades->modalidade, $chave);
            Logger::Success('Emissão de Certidão Artesanato','Apenado: '.$apenado->nomeapenado.' Dias Remir: ' .$totalremir.' Data Emissão: ' .date('d-m-y'). ' Servidor: ' .Auth::user()->nome);
            return $this->relatorio->gerar_pdf_retrato('Declaracao de Remissao', $conteudo_html, 'Declaracao_' );

        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }

    }

    public function geraRemissao_pdf(Request $request, $id, $ano){
        try{
        $apenado = $this->apenado->find($id);
        $result = DB::table('atividades as a')
            ->join('tipomodalidades as t', 't.id','=','a.tipomodalidade_id')
            ->Where('a.apenado_id','=', '' . $id . '' )
            ->where('a.remir', 'SIM')
            ->whereYear('a.datainicio', $ano)
            ->where('a.tipomodalidade_id', '!=', 1 )
            ->orderby('a.datainicio', 'asc')
            ->select('a.*', 't.modalidade', 't.tempo')
            ->get();

            $modPrincip = $this->atividade->whereapenado_id($id)->whereremir('SIM')->wheredatafim(null)->first();
            $conteudo_html =
            '<table width="100%" border="0" cellspacing="0" cellpadding="3">'.
            '<tr>' .
            '<td style="text-align:center; width:15%;">' .
            '<img src="../public/logo_estado.png" width="70px" height="45px"></td>' .
            '<td colspan="10" style="text-align:center; font-size:12px; padding: 0px, 0px,0px,0px; width:70%;">' .
            '<p> <strong> GOVERNO DO ESTADO DE RONDÔNIA </strong> </p>' .
            '<p> <strong> SECRETARIA DE ESTADO DE JUSTIÇA </strong> </p>' .
            '<p> <strong>' . strtoupper($apenado->unidades->nomeunidade) . ' </strong> </p>' .
            '</td>' .
            '<td style="text-align:center; width:15%;">' .
            '<img src="../public/sejus-ro.png" width="40px" height="60px"> </td>' .
            '</tr>' .
            '</table>'
        ;


        //VERIFICA SE POSSUI MODALIDADE PRINCIPAL DE REMIÇÃO ATIVA, SE NÃO ATRIBUI VAZIO NA VARIAVEL
        if(empty($modPrincip))
        {
            $modPrincipal = Apenado::buscaAtividadeApenado($apenado->id);
        }
        else
            {
                $modPrincipal = $modPrincip->tipomodalidades->modalidade;
            }

        $conteudo_html .=
            '<h2 style="text-align: center;"> DECLARAÇÃO DE REMIÇÃO DE PENA - '. strtoupper($modPrincipal) .' </h2>'
        ;

            if(strtoupper($modPrincipal) == 'ARTESANATO')
            {
                $conteudo_html .=
                    '<h2 style="text-align: center;"> PORTARIA N 3158/GERES/GAB/SEJUS, DE 12/09/2016 </h2>'
                ;
            }

        $conteudo_html .=
            '<p> </p>'.
            '<p style="text-align: left;">Número do Processo: <strong> '. $apenado->processo .' </strong> </p>'
        ;

        $conteudo_html .=
            '<p> </p>'.
            '<p style="text-align: left"> O diretor da (o) <strong> '. strtoupper($apenado->unidades->nomeunidade).' </strong> '.
            'no uso das atribuições legais que lhe são conferidas em Lei, </p>' .
            '<p> DECLARA que o reeducando <strong> '.strtoupper($apenado->nomeapenado).' </strong>, enquanto recolhido nesta Unidade ' .
            'Prisional, desenvolveu atividades laborais conforme descriminado no calendário abaixo:</h4> </p>'
        ;

        $conteudo_html .=
            '<p> Ano: '. $ano .' </p>'
        ;

        if (count($result)>0) {

            $conteudo_html .= $this->relatorio->table_padrao_pdf_html().
                $this->relatorio->tr_header_table_padrao_pdf().
                        '<th style="width:40%;"><b>MÊS</b></th>' .
                        '<th style="width:30%;"><b>DIAS TRABALHADOS</b></th>' .
                        '<th style="width:30%;"><b>CONVERSÃO (Remição)</b></th>' .
                    '</tr>';
            $tdt = 0; $tdr = 0;

                foreach ($result as $lista) {
                                    $datai = $lista->datainicio;
                                    $mesi = date('m', strtotime($datai));
                                    $dataf = $lista->datafim;

                                        if($dataf == null) {
                                            $dataf = date('Y-m-d');
                                            $mesf = date('m', strtotime($dataf));
                                        }else{
                                            $mesf = date('m', strtotime($dataf));
                                        }

                                    $tempo = $lista->tempo;
                                    $tdt = $tdt; $tdr = $tdr;

                            if($dataf == null) { $dataf = date('Y-m-d'); }

                            for ($i=$mesi; $i <= $mesf; $i++)
                            {
                                $dia = calculaDiasDoMes($i, $mesi, $mesf, $ano, $datai, $dataf);
                                $qtdDia = calculaDiaRemir($dia, $tempo);
                                $fator = diasMes($i, $ano)  / 10 ;
                                $totRemir =  number_format(($qtdDia / $fator),2);

                                     $conteudo_html .=
                                        '<tr>' .
                                            '<td align="left" style="font-size: 10px;" > '.verificaMes($i).' </td>' .
                                            '<td align="center" style="font-size: 10px;" >'. $qtdDia .'</td>'.
                                            '<td align="center" style="font-size: 10px;" >'. $totRemir .'</td>' .
                                            '</tr>'
                                        ;

                                $tdt = $tdt + $qtdDia;
                                $tdr = $tdr + $totRemir;
                            }
                }

                $conteudo_html .=
                    '<tr style="font-weight: bold; font-size: 12px; background-color: #ddd; ">' .
                        '<td align="left" >Total Geral</td>' .
                        '<td align="center">' . $tdt . '</td>' .
                        '<td align="center">' . $tdr . '</td>' .
                    '</tr>';
                ;
            $conteudo_html .= '</table>';

        }else{
            $conteudo_html .=
                '<h4 class="well well-sm text-center text-danger">'.
                    'Sem lançamentos de Remissão para este Reeducando.'.
                '</h4>'
            ;

        }

        $conteudo_html .=
            '<br><br><p align="right" > Porto Velho, '. \Jenssegers\Date\Date::now()->format('j F Y') .'</p>'
        ;

        $conteudo_html .=
            '<p></p>'.
            '<p></p>'.
            '<p></p>'.
            '<p></p>'.
            '<p></p>'.
            '<span style="text-align: center;"> '. strtoupper($apenado->unidades->nomeresponsavel).' </span> <br>'.
            '<span style="text-align: center;"> '. strtoupper($apenado->unidades->funcao).' </span> <br>'.
            '<span style="text-align: center;"> '. strtoupper($apenado->unidades->matricularesp).' </span> <br><br>'
        ;


        //FAZ O REGISTRO DA REMIÇÃO NO SISTEMA
            $chave = geraChave($apenado->id);

            $conteudo_html .=
                '<span style="text-align: right;"> Chave de Validação : [ ' . $chave .' ] </span> <br>'
            ;

        //

        RegCertidao::Success($apenado->nomeapenado, $ano, $tdt, $tdr, $apenado->unidades->nomeunidade, $apenado->unidade_id, $modPrincipal, $chave);
        Logger::Success('Emissão de Certidão Laboral','Apenado: '.$apenado->nomeapenado.' Dias Remir: ' .$tdr.' Data Emissão: ' .date('d-m-y'). ' Servidor: ' .Auth::user()->nome);
        return $this->relatorio->gerar_pdf_retrato('Declaracao de Remissao', $conteudo_html, 'Declaracao_' );

        } catch (\Exception $e) {
            return  $e;
            return redirect()->back();
        }

    }



    public function fichainscricao($id){

       $apenado = $this->apenado->find($id);
       $ficha = $this->atividade->whereapenado_id($id)->whereremir('SIM')->wheredatafim(null)->first();
       //busca a carceragem
       $idCarc = $apenado->cela->carceragem_id;
       $carceragem = $this->carceragem->find($idCarc);


        $conteudo_html =
        '<table width="100%" border="1" cellspacing="0" cellpadding="3">'.
        '<tr>' .
            '<td style="text-align:center; width:15%;">' .
            '<img src="../public/logo_estado.png" width="70px" height="45px"></td>' .
                '<td colspan="10" style="text-align:center; font-size:12px; padding: 0px, 0px,0px,0px; width:70%;">' .
                '<p> <strong> GOVERNO DO ESTADO DE RONDÔNIA </strong> </p>' .
                '<p> <strong> SECRETARIA DE ESTADO DE JUSTIÇA </strong> </p>' .
                '<p> <strong>' . strtoupper($apenado->unidades->nomeunidade) . ' </strong> </p>' .
            '</td>' .
            '<td style="text-align:center; width:15%;">' .
            '<img src="../public/sejus-ro.png" width="40px" height="60px"> </td>' .
        '</tr>' .
        '</table>'

        ;

        if(strtoupper($ficha->tipomodalidades->modalidade) == 'ARTESANATO')
        {
            $conteudo_html .=
                '<h2 style="text-align: center;"> PORTARIA N 3158/GERES/GAB/SEJUS, DE 12/09/2016 </h2>'
            ;
        }
        else
            {
            $conteudo_html .=
                '<h2 style="text-align: center;"> '. $ficha->tipomodalidades->modalidade .' </h2>'
            ;
        }

        $conteudo_html .=

            '<p> </p>'.
            '<h2 style="text-align: center;">FICHA INDIVIDUAL DE INSCRIÇÃO</h2>'
        ;

        $conteudo_html .=
            '<table width="100%" border="1" cellspacing="0" cellpadding="3">'.
            '<tr>'.
                '<td>Nome</td>'.
                '<td colspan="5" style="text-align: left; font-weight: bold; font-size: 11px;">'.strtoupper($apenado->nomeapenado).'</td>'.
            '</tr>'.
            '<tr>'.
                '<td>Carceragem</td>'.
                '<td style="text-align: left; font-weight: bold; font-size: 11px;">'.$carceragem->nomecarceragem.'</td>'.
                '<td>Cela</td>'.
                '<td colspan="3" style="text-align: left; font-weight: bold; font-size: 11px;">'.$apenado->cela->nomecela.'</td>'.
            '</tr>'.
            '<tr>'.
                '<td colspan="2">Processo de Execução Penal</td>'.
                '<td colspan="4" style="text-align: left; font-weight: bold; font-size: 11px;">'.$apenado->processo.'</td>'.
            '</tr>'.
            '<tr>'.
                '<td>CPF</td>'.
                '<td style="text-align: left; font-weight: bold; font-size: 11px;">'.$apenado->cpf.'</td>'.
                '<td>RG</td>'.
                '<td style="text-align: left; font-weight: bold; font-size: 11px;">'.$apenado->rg.'</td>'.
                '<td>Nascimento</td>'.
                '<td style="text-align: left; font-weight: bold; font-size: 11px;">'.strftime('%d/%m/%Y',strtotime($apenado->datanascimento)) .'</td>'.
            '</tr>'.
            '<tr>'.
                '<td rowspan="2">Filiação</td>'.
                '<td>Nome Mãe</td>'.
                '<td colspan="4" style="text-align: left; font-weight: bold; font-size: 11px;">'.$apenado->nomemae.'</td>'.
            '</tr>'.
            '<tr>'.
                '<td>Nome Pai</td>'.
                '<td colspan="4" style="text-align: left; font-weight: bold; font-size: 11px;">'.$apenado->nomepai.'</td>'.
            '</tr>'.
            '<tr>'.
            '<td colspan="1">Atividade</td>'.
            '<td colspan="2" style="text-align: left; font-weight: bold; font-size: 11px;"> '.$ficha->tipomodalidades->modalidade.'</td>'.
            '<td colspan="1" >Data Início </td>'.
            '<td colspan="2" style="text-align: left; font-weight: bold; font-size: 11px;"> '.strftime('%d/%m/%Y',strtotime($ficha->datainicio)).'</td>'.
            '</tr>'.
        '</table>'

        ;


        $conteudo_html .=
            '<p> </p>'.
            '<h2 style="text-align: center;">CERTIDÃO DE COMPROMISSO</h2>'.
            '<p> </p>'
        ;


        $conteudo_html .=
            '<p> </p>'.
            '<h3 style="text-align: left;">Certifico que estou ciente das normas e regulamento do '.
                'Projeto Costurando a Liberdade, ' .
                'pelo qual aceito de livre e espontânea vontade e assumo abaixo assinado </h3> '.

            '<p> </p>'.

            '<p style="text-align: center;">_________________________________________________________ </p> '.
            '<p style="text-align: center;">Reeducando/Participante </p> '
        ;


        $conteudo_html .=
            '<p> </p>'.
            '<p> </p>' .
            '<p> </p>'.
            '<p> </p>'
         ;

        $conteudo_html .= 'Documento gerado em ' . date('d/m/Y H:i:s') . '.';

        Logger::Success('Ficha Inscrição','Apenado: '.$apenado->nomeapenado. ' Atividade Cadastrada: ' . $ficha->tipomodalidades->modalidade .  ' Data Impressão: ' .date('d-m-y'). ' Servidor: ' .Auth::user()->nome);
        return $this->relatorio->gerar_pdf_retrato_sem_header('Ficha de Inscrição', $conteudo_html, 'Inscricao_' );
    }




}
