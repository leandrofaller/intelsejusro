<?php

namespace App\Http\Controllers;

use App\Model\Apenado;
use App\Model\Carceragem;
use App\Model\Cela;
use App\Model\Estado;
use App\Model\MedidaDisciplinar;
use App\Model\Movimentacao;
use App\Model\Processo;
use App\Model\Temporaria;
use App\Model\Unidade;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Flash;


class ListagemController extends Controller
{

    public function __construct(Unidade $unidadesModel, Carceragem $carcModel, Cela $celaModel)
    {
        $this->unidadesModel = $unidadesModel;
        $this->carcModel = $carcModel;
        $this->celaModel = $celaModel;
    }


    public function carceragem($idCarc)
    {
        try
        {
            $v['titulo'] = " LISTAGEM";
            $v['subtitulo'] = " Relação de Apenados por Carceragem/Pavilhão/Ala";

            $v['carceragem'] = Carceragem::find($idCarc);
            $v['celas'] = $this->celaModel->Where('carceragem_id', $idCarc)->get();

            $v['presos'] = DB::table('apenados as a')
                ->join('processos as p', 'p.apenado_id', '=' , 'a.id')
                ->join('movimentacoes as m', 'm.processo_id', '=' , 'p.id')
                ->join('celas as c', 'c.id', '=' , 'm.cela_id')
                 ->join('carceragens as car', 'car.id', '=' , 'c.carceragem_id')
                ->Where('c.carceragem_id', $idCarc)
                ->Where('m.datasaida', null)
                ->Where('m.motivosaida', null)
                ->select('a.id as idApen', 'a.nomeapenado', 'm.dataentrada', 'p.artigos', 'p.numeroprocesso', 'c.nomecela', 'car.nomecarceragem')
                ->orderby('c.nomecela', 'ASC')
                ->orderby('a.nomeapenado', 'ASC')
                ->get();

                return view('listagem.carceragem', $v);

        }
        catch (\Exception $e)
        {

        }
    }

    public function celas(Request $request)
    {
        try
        {
            $v['titulo'] = " LISTAGEM";
            $v['subtitulo'] = " Apenados por Cela";
            $idUnid = Auth::user()->unidade_id;

            $v['exibe'] = false;
       //     $v['celas'] = $this->celaModel->where('status', 'Ativo')->orderBy('nomecela')->get();
                $v['celas'] = DB::table('celas as c')
                ->join('carceragens as ca', 'ca.id', '=', 'c.carceragem_id')
                ->Where('ca.unidade_id', $idUnid)
                ->Where('c.status', 'Ativo')
                ->orderby('ca.id', 'c.nomecela', 'ASC')
                ->get();
            if ( $request->has('cela_id') ) {
                $cela_id = $request->input('cela_id');
                $v['exibe'] = true;

                $v['presos'] = DB::table('apenados as a')
                    ->join('processos as p', 'p.apenado_id', '=', 'a.id')
                    ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                    ->join('celas as c', 'c.id', '=', 'm.cela_id')
                    ->Where('c.id', $cela_id)
                    ->Where('m.datasaida', null)
                    ->Where('m.motivosaida', null)
                    ->select('a.id as idApen', 'a.nomeapenado', 'a.foto', 'c.nomecela')
                    ->orderby('a.nomeapenado', 'ASC')
                    ->get();


            }

            return view('listagem.celas', $v);

        }
        catch (\Exception $e)
        {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }


    public function fichaCela($id){

        try{
            $v['title'] = '';
            $v['presos'] = DB::table('apenados as a')
                ->join('processos as p', 'p.apenado_id', '=', 'a.id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('c.id', $id)
                ->Where('m.datasaida', null)
                ->Where('m.motivosaida', null)
                ->select('a.id as idApen', 'a.nomeapenado', 'a.foto', 'c.nomecela')
                ->orderby('a.nomeapenado', 'ASC')
                ->get();
            return view('listagem.fichaCela', $v);
        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }





    public function geral(){
        try
        {
        $idUnid = Auth::user()->unidade_id;

            $v['titulo'] = " LISTAGEM ";
            $v['subtitulo'] = " Relação de Geral";

           $v['presos'] = DB::table('apenados as a')
                ->join('processos as p', 'p.apenado_id', '=' , 'a.id')
                ->join('movimentacoes as m', 'm.processo_id', '=' , 'p.id')
                ->join('unidades as u', 'm.unidade_id', '=' , 'u.id')
                ->join('celas as c', 'c.id', '=' , 'm.cela_id')
                ->Where('m.unidade_id', $idUnid)
                ->Where('m.datasaida', null)
                ->Where('m.motivosaida', null)
                ->select('a.id as idApen', 'a.nomeapenado', 'm.dataentrada', 'p.artigos', 'p.numeroprocesso', 'c.nomecela')
                ->orderby('c.nomecela', 'ASC')
                ->orderby('a.nomeapenado', 'ASC')
                ->get();

            return view('listagem.geral', $v);

        }
        catch (\Exception $e)
        {

        }
    }

    public function exportarBaseTodos($guia)
    {
        //EXPORTAR BASE GERAL DE APENADOS PARA EXPORTAÇÃO PARA O INFOPEN



        $dados = Apenado::
        join('processos', function($query){
            $query->on('processos.apenado_id','=','apenados.id');
        })
            ->join('movimentacoes',function($query){
                $query->on('movimentacoes.processo_id','=','processos.id');
            })
            ->join('celas',function($query){
                $query->on('movimentacoes.cela_id','=','celas.id');
            })
            ->join('unidades',function($query){
                $query->on('movimentacoes.unidade_id','=','unidades.id');
            })

            ->select('apenados.id', 'apenados.nomeapenado' ,'apenados.alcunha', 'apenados.rg', 'apenados.cpf'
                ,'apenados.datanascimento', 'apenados.nomepai' ,'apenados.nomemae', 'apenados.etnia'
                ,'apenados.naturalidade', 'apenados.escolaridade', 'apenados.sexo', 'apenados.rua'
                ,'apenados.numero', 'apenados.bairro', 'apenados.estado', 'apenados.cidade'

                ,'processos.numeroprocesso', 'processos.artigos', 'processos.vara', 'processos.dataprisao'

                ,'movimentacoes.regime', 'movimentacoes.unidade_id', 'unidades.nomeunidade', 'movimentacoes.dataentrada', 'movimentacoes.oficioentrada', 'movimentacoes.unidade_id'

                ,'movimentacoes.cela_id', 'celas.nomecela'
            )

            ->where('movimentacoes.datasaida','=', NULL)
            ->where('movimentacoes.motivosaida', '=', NULL)
            ->get();

        $nomearquivo = 'Base-'.$guia.'-'.date('d-m-Y');
        Excel::create($nomearquivo, function($excel) use ($dados) {
            $excel->sheet('Plan1', function($sheet) use ($dados) {
                $sheet->fromArray($dados);
            });
        })->export('xls');

    }

    public function exportarBaseGeralExcel($guia)
    {
        $idUnid = Auth::user()->unidade_id;

    if($guia == 'resumido') {

        $cabecalho = array('ORDEM', 'CÓDIGO', 'NOME', 'ALCUNHA', 'PROCESSO', 'CELA', 'MEDIDA DISCIPLINAR', 'MEDIDA DISCIPLINAR OUTRAS UNIDADES');
        $movimentacoes = Movimentacao::where('datasaida', null)
            ->Where('unidade_id', $idUnid)
            ->Where('datasaida', null)
            ->Where('motivosaida', null)
            ->get();

        $cont = 0;
        $i = 0;
        $dados = array();
        foreach ($movimentacoes as $mov) {
            $processo = Processo::find($mov->processo_id);
            $apenado = Apenado::find($processo->apenado_id);
            $cela = Apenado::nomecela($mov->cela_id);

            //*********************************** VERIFICA MEDIDA DISCIPLINAR DA UNIDADES
            $medidas = MedidaDisciplinar::where('apenado_id', $apenado->id)->where('movimentacao_id', $mov->id)->limit(1)->get();
            $md = array();
            if ($medidas != '') {
                foreach ($medidas as $medida) {
                    $md[] = $medida->tipomedida_md . ' ' . $medida->unidades_md . ' ' . $medida->datafim_md;
                }

            } else {
                $md = '';
            }

            //*********************************** VERIFICA MEDIDA DISCIPLINAR DE OUTRAS UNIDADES
            $medidasoutras = MedidaDisciplinar::where('apenado_id', $apenado->id)->where('tipomedida_md', 'Outras Unidades')->where('movimentacao_id', $mov->id)->limit(2)->get();
            $mdo = array();
            if ($medidasoutras != '') {
                foreach ($medidasoutras as $medidaoutra) {
                    $mdo[] = $medidaoutra->tipomedida_md . ' ( ' . $medidaoutra->unidades_md . ' ) ' . $medidaoutra->datafim_md;
                }
            } else {
                $mdo = '';
            }
            $cont++;
            $linha = array(
                $cont,
                $apenado->id,
                $apenado->nomeapenado,
                $apenado->alcunha,
                $processo->numeroprocesso,
                $cela,
            );
            $dados[$i] = array_merge($linha, $md, $mdo);
            $i++;
        }
        array_unshift($dados, $cabecalho);

    }elseif($guia == 'geral'){

               $dados = Apenado::
            join('processos', function($query){
                $query->on('processos.apenado_id','=','apenados.id');
                })
                    ->join('movimentacoes',function($query){
                        $query->on('movimentacoes.processo_id','=','processos.id');
                    })
                        ->join('celas',function($query){
                            $query->on('movimentacoes.cela_id','=','celas.id');
                        })
//                            ->leftjoin('medidadisciplinar',function($query){
//                                   $query->on('medidadisciplinar.movimentacao_id','=','movimentacoes.id')
//                                         ->where('medidadisciplinar.databaixa_md', '=', NULL)
//                                        ->groupby('medidadisciplinar.apenado_id', 'desc')->limit(1)
//                                ;
//                            })

               ->select('apenados.id', 'apenados.nomeapenado'
                   , 'apenados.alcunha', 'apenados.datanascimento', 'apenados.nomepai'
                        ,'apenados.nomemae', 'apenados.etnia', 'apenados.naturalidade', 'apenados.escolaridade'
                        ,'apenados.naturalidade', 'apenados.escolaridade'
                        ,'processos.numeroprocesso', 'processos.artigos', 'processos.vara'
                        ,'movimentacoes.regime', 'movimentacoes.dataentrada', 'movimentacoes.oficioentrada'
                        ,'celas.nomecela'

                    //    ,'medidadisciplinar.tipomedida_md', 'medidadisciplinar.datainicio_md'
                   //     ,'medidadisciplinar.datafim_md', 'medidadisciplinar.ocorrencia_md'
                )
                ->where('movimentacoes.unidade_id', $idUnid)
                ->where('movimentacoes.datasaida','=', NULL)
                ->where('movimentacoes.motivosaida', '=', NULL)

           ->get();


    }

        $nomearquivo = 'Base-'.$guia.'-'.date('d-m-Y');
        Excel::create($nomearquivo, function($excel) use ($dados) {
            $excel->sheet('Plan1', function($sheet) use ($dados) {
                $sheet->fromArray($dados);
            });
        })->export('xls');



    }

    public function recebimento()
    {
            try
            {
                $idUnid = Auth::user()->unidade_id;

                $v['titulo'] = " LISTAGEM ";
                $v['subtitulo'] = " Relação de Apenados Aguardando Recebimento na Unidade";

                //MOSTRA APENADOS QUE ESTÃO AGUARDANDO RECEBIMENTO NA UNIDADE
                $v['presos'] = DB::table('processos as p')
                    ->join('apenados as a', 'a.id', '=', 'p.apenado_id')
                    ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                    ->Where('m.unidade_id', $idUnid)
                    ->Where('m.cela_id', NULL)
                    ->where('m.regime', '')
                    ->select('a.id as idApen', 'a.nomeapenado', 'm.dataentrada', 'p.id as idProc', 'p.artigos', 'p.numeroprocesso', 'm.oficioentrada')
                    ->orderby('a.nomeapenado', 'desc')
                    ->get();

                return view('listagem.recebimento', $v);
            }
            catch (\Exception $e)
            {

            }
    }

    public function fugitivos(){

        try
        {

            $v['titulo'] = " LISTAGEM ";
            $v['subtitulo'] = " Fugitivos da Unidade";

            $idUnid = Auth::user()->unidade_id;
            $v['presos'] = DB::table('processos as p')
                    ->join('apenados as a', 'a.id', '=', 'p.apenado_id')
                    ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                    ->join('fugas as f', 'f.movimentacao_id', '=', 'm.id')
                    ->Where('m.unidade_id', $idUnid)
                   // ->Where('f.movimentacao_id', '')
                    ->orderby('f.datarecaptura', 'asc')
                    ->groupby('f.apenado_id')
                    ->get();
            return view('listagem.fugitivos', $v);
        }
        catch (\Exception $e)
        {

        }
    }

    public function triagem(){

        try
        {
            $v['titulo'] = "LISTAGEM ";
            $v['subtitulo'] = " Apenados em Triagem";

            $idUnid = Auth::user()->unidade_id;
            $v['presos'] = DB::table('processos as p')
                ->join('apenados as a', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->Where('m.unidade_id', $idUnid)
                ->Where('m.triagem_baixa', null)
                ->Where('m.triagem_inicio', '<>', null)
                ->select('m.id as idMov', 'm.triagem_baixa', 'm.triagem_inicio', 'm.triagem_fim', 'm.dataentrada',
                         'm.cela_id', 'a.nomeapenado', 'a.id as idApen')
                ->get();
            return view('listagem.triagem', $v);
        }
        catch (\Exception $e)
        {

        }
    }

    public function transito(){

        try
        {
            $v['titulo'] = "TRÂNSITO";
            $v['subtitulo'] = " Apenados em Trânsito";

            $idUnid = Auth::user()->unidade_id;
            $v['presos'] = DB::table('processos as p')
                ->join('apenados as a', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->Where('m.unidade_id', $idUnid)
                ->Where('m.datasaida', null)
                ->Where('m.transito', 'Sim')
                ->select('m.id as idMov', 'm.dataentrada', 'm.unidadeorigem',
                    'm.cela_id', 'a.nomeapenado', 'a.id as idApen')
                ->get();
            return view('listagem.transito', $v);
        }
        catch (\Exception $e)
        {

        }
    }


    public function medidadisciplinar($tipo = '')
    {
        try
        {
           // 01 = Na Unidade
           // 02 = Outras Unidades

            $v['tipo'] = $tipo;
            $v['titulo'] = " LISTAGEM ";
            $v['subtitulo'] = " Medida Disciplinar";

            $idUnid = Auth::user()->unidade_id;

        if($tipo == 01){

            $v['presos'] = DB::table('medidadisciplinar as md')
                ->join('apenados as a', 'a.id', '=', 'md.apenado_id')
                ->join('processos as p', 'p.apenado_id', '=', 'a.id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->Where('m.datasaida', null)
                ->Where('md.unidade_id', $idUnid)
                ->Where('md.databaixa_md', null)
                ->Where('md.tipomedida_md', '!=', 'Outras Unidades')
                ->select('md.*', 'a.nomeapenado', 'p.apenado_id', 'm.cela_id')
                ->orderby('md.datainicio_md', 'asc')
                ->get();


        }elseif($tipo == 02){

            $v['presos'] = DB::table('medidadisciplinar as md')
                ->join('apenados as a', 'a.id', '=', 'md.apenado_id')
                ->join('processos as p', 'p.apenado_id', '=', 'a.id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->Where('m.datasaida', null)
                ->Where('md.unidade_id', $idUnid)
                ->Where('md.databaixa_md', null)
                ->Where('md.tipomedida_md', '=', 'Outras Unidades')
                ->select('md.*', 'a.nomeapenado', 'p.apenado_id', 'm.cela_id')
                ->orderby('md.datainicio_md', 'asc')
                ->get();

        }else {

            $v['presos'] = DB::table('medidadisciplinar as md')
                ->join('apenados as a', 'a.id', '=', 'md.apenado_id')
                ->join('processos as p', 'p.apenado_id', '=', 'a.id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->Where('m.datasaida', null)
                ->Where('md.unidade_id', $idUnid)
                // ->Where('md.databaixa_md', null)
                // ->Where('md.tipomedida_md', '=', 'Outras Unidades')
                ->select('md.*', 'a.nomeapenado', 'p.apenado_id', 'm.cela_id')
                ->orderby('md.databaixa_md', 'asc')
                ->get();

        }
            return view('listagem.medidadisciplinar', $v);
        }
        catch (\Exception $e)
        {

        }

    }


    public function temporarias($tipo)
    {
        try
        {
            $v['titulo'] = " LISTAGEM ";
            $v['subtitulo'] = " Permissão de Saída ";

            $idUnid = Auth::user()->unidade_id;
            $v['presos'] = Temporaria::where('unidade_id', $idUnid)
                                    ->where('tipo', $tipo)
                                    ->where('dataretorno', NULL)
                                    ->get();
            return view('listagem.temporarias', $v);
        }
        catch (\Exception $e)
        {
            return $e;
        }

    }




    public function mapa()
    {
        $v['titulo'] = " MAPA ";
        $v['subtitulo'] = " Quantitativo de Apenados por Cela/Ala";

        $idUnid = Auth::user()->unidade_id;
        $v['carceragens'] = Carceragem::where('unidade_id', $idUnid)->get();
        $v['celas'] = Cela::all();

        return view('listagem.mapa', $v);

    }


}
