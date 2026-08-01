<?php

namespace App\Http\Controllers;


use App\Classes\Relatorio;
use App\Model\Apenado;
use App\Model\Carceragem;
use App\Model\CargosFaccao;
use App\Model\Cela;
use App\Model\Certidao;
use App\Model\Faccao;
use App\Model\Fuga;
use App\Model\Informacao;
use App\Model\Integrantes;
use App\Model\Movimentacao;
use App\Model\Processo;
use App\Model\Unidade;
use Illuminate\Http\Request;
use DB, Auth, Logger, Date, Flash;

class CertidoesController extends Controller
{
    public function __construct(Processo $processoModel, Movimentacao $movimentacaoModel, Apenado $apenModel,
                                Unidade $unidadeModel, Carceragem $carceragemModel, Cela $celaModel,
                                Integrantes $integranteModel, Faccao $faccaoModel, CargosFaccao $cargosFaccaoModel,
                                Informacao $informacoesModel, Fuga $fugaModel, Relatorio $relatorio)
    {
        $this->apenModel = $apenModel;
        $this->unidadeModel = $unidadeModel;
        $this->carceragemModel = $carceragemModel;
        $this->processoModel = $processoModel;
        $this->movimentacaoModel = $movimentacaoModel;
        $this->celaModel = $celaModel;
        $this->integranteModel = $integranteModel;
        $this->faccaoModel = $faccaoModel;
        $this->cargofaccaoModel = $cargosFaccaoModel;
        $this->informacoesModel = $informacoesModel;
        $this->fugaModel = $fugaModel;
        $this->relatorio = $relatorio;
    }

    public function index(Request $request)
    {
        try {
            $v['titulo'] = "CERTIDÕES";
            $v['subtitulo'] = "Pesquisa para emissão de Certidões - Unidade";

            if ($request->has('parametro')) {
            $v['apenados'] = DB::table('apenados as a')
                    ->join('processos as p', 'a.id','=','p.apenado_id')
                    ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                    ->join('unidades as u', 'm.unidade_id','=','u.id')
                    ->Where('m.unidade_id', Auth::user()->unidade_id )
                    ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
                    ->select('a.*')
                    ->orderby('a.nomeapenado', 'asc')
                    ->groupby('a.id')
                    ->get();
            } else {
                $v['apenados'] = '';
            }

            $v['parametro'] = $request->input('parametro');
            return view('certidoes.index', $v);

        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }

    public function listar(Request $request)
    {
        try {
            $v['titulo'] = "CERTIDÕES";
            $v['subtitulo'] = "Certidões - Emitidas";


            if ($request->has('parametro')) {
                $v['certidoes'] = DB::table('certidoes')
                    ->Where('unidade_id', Auth::user()->unidade_id )
                    ->Where('nome', 'LIKE', '%' . $request->input('parametro') . '%')
                    ->orWhere('chavevalidacao', 'LIKE', '%' . $request->input('parametro') . '%')
                    ->paginate(10);

            } else {
                $v['certidoes'] = DB::table('certidoes')
                    ->Where('unidade_id', Auth::user()->unidade_id )
                    ->orderby('nome', 'asc')
                    ->paginate(10);
            }

            $v['parametro'] = $request->input('parametro');
            return view('certidoes.listar', $v);

        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }

    public function mostradados($id)
    {
        try {
            $v['titulo'] = "CERTIDÕES ";
            $v['subtitulo'] = "Informações do apenado";

            $v['apenado'] = DB::table('apenados as a')
                ->Where('a.id', $id)
                ->first();

            $v['historicos'] = DB::table('processos as p')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->Where('m.unidade_id', Auth::user()->unidade_id )
                ->Where('p.apenado_id', $id)
                ->orderby('m.datasaida', 'asc')
                ->select('m.id as idMov', 'm.*', 'p.*', 'u.*')
                ->get();

            $v['tipos'] = array(
                '' => '',
                'Bom' => 'Bom',
                'Ruim' => 'Ruim',
            );

            $v['pads'] = DB::table('pad as p')
                ->join('movimentacoes as m', 'm.id','=','p.movimentacao_id')
                ->join('processos as pr', 'm.processo_id','=','pr.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->Where('m.unidade_id', Auth::user()->unidade_id )
                ->Where('p.apenado_id', $id)
                ->orderby('m.id', 'desc')
                ->select('p.id as idPad',  'p.*', 'pr.numeroprocesso')
                ->get();

            return view('certidoes.mostradados', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }


    public function mostrar($id)
    {
        try {
            $v['titulo'] = "CERTIDÕES ";
            $v['subtitulo'] = "Detalha as informações da Certidão";

          $v['certidao'] = DB::table('certidoes')
                ->Where('id', $id)
                ->first();

            return view('certidoes.mostrar', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }

    public function emitir($idPreso, Request $request)
    {

        $tipocertidao = $request->input('radiotipo');
        $comportamento = $request->input('comportamento');
        $idPrisao = $request->input('prisao');

        $Cert_Carc_Recolhido = 'Certifico para os devidos fins, que o reeducando abaixo qualificado encontra-se recolhido 
                        nesta Unidade Prisional, conforme informações a seguir: ';
        $Cert_Carc_Nao_Recolhido = 'Certifico para os devidos fins, que o reeducando abaixo qualificado esteve 
                        recolhido nesta Unidade Prisional, conforme informações a seguir: ';
        $Cert_Carc_Recolhido_Comportamento = 'Verificando o prontuário do reeducando abaixo qualificado, e informações do seu
                        comportamento carcerário, segue abaixo as informações encontradas nesta Unidade Prisional: ';

        $apenado = DB::table('apenados as a')
            ->Where('a.id', $idPreso)
            ->first();

        $prisao = DB::table('processos as p')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->join('unidades as u', 'm.unidade_id','=','u.id')
            ->Where('m.id', $idPrisao)
            ->first();

        //******************* EMISSÃO DE CERTIDÃO DE CARCERAGEM
        if($tipocertidao == 'carceragem') {
            $validator = validator($request->all(),
                ['radiotipo' => 'required', 'prisao' => 'required']);
            if ($validator->fails()) {
                return redirect()->route('certidoes.mostradados', $idPreso)->withInput()->withErrors($validator);
            }

        //******************* EMISSÃO DE CERTIDÃO DE COMPORTAMENTO
        }elseif($tipocertidao == 'comportamento')
        {

            $validator = validator($request->all(),
                [  'radiotipo'=>'required', 'prisao'=>'required', 'class_comportamento'=>'required', ]);
            if($validator->fails()){
                return redirect()->route('certidoes.mostradados', $idPreso)->withInput()->withErrors($validator);
            }


            $opcao = $request->input('Opcao');
            if(empty($opcao))
            {
                $pads = '';
                $numeropad = '';
                $relseguranca = '';
                $resultOpcoes = [];
            }
            else{
                $resultOpcoes = DB::table('pad as p')
                    ->Wherein('p.id', $request->input('Opcao') )
                    ->select('p.numeropad', 'p.numerorelatorioseguranca', 'p.datainiciopad')
                    ->get();
            }
        }

        $conteudo_html =
            '<table width="100%" border="0" cellspacing="0" cellpadding="3">' .
            '<tr>' .
            '<td style="text-align:center; width:15%;">' .
            '<img src="../public/logo_estado.png" width="70px" height="45px"></td>' .
            '<td colspan="10" style="text-align:center; font-size:12px; padding: 0px, 0px,0px,0px; width:70%;">' .
                '<strong> GOVERNO DO ESTADO DE RONDÔNIA </strong> <br>' .
                '<strong> SECRETARIA DE ESTADO DE JUSTIÇA </strong> <br>' .
                '<strong> <span style="font-size:10px"> ' . Auth::user()->unidades->nomeunidade . ' </strong> </span> <br> ' .
                '<strong> <span style="font-size:10px"> DIREÇÃO ADMINISTRATIVA </strong> </span> ' .
            '</td>' .
            '<td style="text-align:center; width:15%;">' .
            '<img src="../public/sejus-ro.png" width="40px" height="60px"> </td>' .
            '</tr>' .
            '</table>';

        $conteudo_html .=
            '<br>' .
            '<br>' .
            '<br>' .
            '<br>' .
            '<br>' .
            '<h1 style="text-align: center;"> CERTIDÃO </h1>'.
            '<br>'.
            '<br>'.
            '<br>'.
            '<br>'.
            '<br>' ;

        $conteudo_html .=
            '<br><br><br><p align="left">Autos de Execução: <strong>' . $prisao->numeroprocesso . '</strong> </p>'
        ;

        /**/
        if($tipocertidao == 'carceragem'){
            if($prisao->datasaida == NULL){
                $conteudo_html .= '<br><br><br><p align="left" style="font-size: 12px">   '. $tit = $Cert_Carc_Recolhido.'   </p>';
            }else{
                $conteudo_html .= '<br><br><br><p align="left" style="font-size: 12px">   '. $tit = $Cert_Carc_Nao_Recolhido.'   </p>';
            }
        }else{
            if($prisao->datasaida == NULL){
                $conteudo_html .= '<br><br><br><p align="left" style="font-size: 12px">   '. $tit = $Cert_Carc_Recolhido_Comportamento.'   </p>';
            }else{
                $conteudo_html .= '<br><br><br><p align="left" style="font-size: 12px">   '. $tit = $Cert_Carc_Recolhido_Comportamento.'   </p>';
            }
        }

        $conteudo_html .=
            '<br><br><br><p align="left">Nome do Reeducando: <strong>' . $apenado->nomeapenado . '</strong> </p>';
        $conteudo_html .=
            '<table style="width:570px;" border="1" cellspacing="0" cellpadding="3">' .
            '  <tr>' .
            '    <th rowspan="2">Filiação</th>' .
            '    <th>Pai</th>' .
            '    <th colspan="3"><b>' . $apenado->nomepai . '</b></th>' .
            '    <th rowspan="9"><img src="'.asset($apenado->foto).'" width="90px" height="115px"></th>'.
            '  </tr>'.
            '  <tr>'.
            '    <td>Mãe</td>'.
            '    <td colspan="3"><b>' . $apenado->nomemae . '</b></td>' .
            '  </tr>' .
            '  <tr>' .
            '    <td>Nascimento</td>' .
            '    <td colspan="2"><b>' . dataFormat($apenado->datanascimento) . '</b></td>' .
            '    <td>Idade</td>' .
            '    <td><b>'. idade(dataFormat($apenado->datanascimento) ).'</b></td>' .
            '  </tr>' .
            '  <tr>' .
            '    <td>Endereço</td>' .
            '    <td colspan="4"> <b> '.$apenado->rua.' '.$apenado->numero.' '.$apenado->bairro.' '.$apenado->cidade.' '.$apenado->estado.'  </b></td>' .
            '  </tr>' .
            '  <tr>' .
            '    <td>Naturalidade</td>' .
            '    <td colspan="2"><b> '.$apenado->naturalidade.'</b></td>' .
            '    <td></td>'.
            '    <td><b> </b></td>' .
            '  </tr>' .
            '  <tr>' .
            '    <td>CPF</td>' .
            '    <td colspan="2"><b>' .$apenado->cpf. '</b></td>' .
            '    <td>RG</td>' .
            '    <td><b>' .$apenado->rg. '</b></td>' .
            '  </tr>' .
            '  <tr>' .
            '    <td>Regime</td>' .
            '    <td colspan="2"><b>' .$prisao->regime. '</b></td>' ;

        $conteudo_html .=
            '  </tr>' .
            '  <tr>' .
            '    <td>Data Entrada </td>' .
            '    <td colspan="2"><b>' .dataFormat($prisao->dataentrada). '</b></td>';

        if($prisao->datasaida == NULL)
        {
            $conteudo_html .=
                '<td></td>' .
                '    <td><b></b></td>' .
                '</tr>'
            ;
        }else{
            $conteudo_html .=
                '<td>Data Saída</td>' .
                '    <td><b>' . dataFormat($prisao->datasaida) . '</b></td>' .
                '</tr>';
        }

        $conteudo_html .=
            '</table>'
        ;

        $conteudo_html .=
            '<br>'.
            '<br>'
        ;
        if($tipocertidao == 'comportamento')
        {

            $pads =
               ' <table border="1"> '.
                    '<tr style="background-color: #000000; color: #ffffff;"> '.
                       '<th style="width:70px; font-size: 10px; text-align: left" >DATA</th> '.
                       '<th style="width:250px; font-size: 10px; text-align: left" >RELATÓRIO SEGURANÇA</th> '.
                       '<th style="width:247px; font-size: 10px; text-align: left">NÚMERO PAD</th> '.
                   '</tr> '
                ;

                foreach($resultOpcoes as $op){
                    $pads .=
                            '<tr style="background-color: #fff"> '.
                                '<th style="font-size: 10px; text-align: left"> '. dataFormat($op->datainiciopad) .' </th> '.
                                '<th style="font-size: 10px; text-align: left"> '.$op->numerorelatorioseguranca.'</th> '.
                                '<th style="font-size: 10px; text-align: left"> '.$op->numeropad.'</th> '.
                            '</tr> '
                        ;
                }

            $pads .=
                '</table>'
            ;

            $conteudo_html .=
                $pads
            ;

            $conteudo_html .=
                '<br>'.
                '<br>'
            ;
            $conteudo_html .=
                '<table style="width:50%;" border="1" cellspacing="0" cellpadding="2">' .
                '  <tr>' .
                '    <td rowspan="3" >Comportamento: <br> <b>' .$request->input('class_comportamento').'</b></td>' .
                '  </tr>' .
                '</table>'
            ;
        }else{
            $pads = '';

        }

        $conteudo_html .=
            '<br>'
        ;

        $hash = strtoupper(uniqid($apenado->id));
        $chave_hash = $this->formata_hash($hash);
        $conteudo_html .=
            '<br>'.
            '<b style="text-align: left;"> Chave de Controle: </b>'.
            '<b style="text-align: left;"> '.$chave_hash.' </b>'
        ;


        if($tipocertidao == 'comportamento')
        {
            $conteudo_html .=
                '<p align="left">Nada mais consta, lavo a presente CERTIDÃO para que surta o seus efeitos legais.'
            ;
        }
        $conteudo_html .=
            '<p align="left">Dado e passado nesta cidade e comarca de '.$prisao->cidadeunidade.' / RO'
        ;

        $conteudo_html .=
            '<br><br><p align="right" > '.$prisao->cidadeunidade.', '. \Jenssegers\Date\Date::now()->format('j F Y') .'</p>'
        ;



        /* ***************** - GRAVA CERTIDAO - **************************** */
        \DB::beginTransaction();
            $gravacertidao = new Certidao();
            $gravacertidao->codigoapenado = $apenado->id;
            $gravacertidao->nome = $apenado->nomeapenado;
            $gravacertidao->foto = $apenado->foto;
            $gravacertidao->execucao = $prisao->numeroprocesso;
            $gravacertidao->pai =  $apenado->nomepai;
            $gravacertidao->mae =  $apenado->nomemae;
            $gravacertidao->nascimento = $apenado->datanascimento;
            $gravacertidao->endereco = $apenado->rua.' '.$apenado->numero.' '.$apenado->bairro.' - '.$apenado->cidade.'/'.$apenado->estado ;
            $gravacertidao->naturalidade = $apenado->naturalidade;
            $gravacertidao->cpf = $apenado->cpf;
            $gravacertidao->rg = $apenado->rg;
            $gravacertidao->regime = $prisao->regime;
            $gravacertidao->dataentrada = $prisao->dataentrada;
            $gravacertidao->datasaida = $prisao->datasaida ? $prisao->datasaida : null;
            $gravacertidao->comportamento = $request->input('class_comportamento');

            $gravacertidao->relatorios = $pads != '' ? $pads : '';

            $gravacertidao->solicitante = $request->input('solicitante');
            $gravacertidao->chavevalidacao = $chave_hash;
            $gravacertidao->unidade_id = Auth::user()->unidade_id;
            $gravacertidao->user_id = Auth::user()->id;
            $gravacertidao->tipocertidao = $tipocertidao;
            $gravacertidao->texto = $tit ;
            $gravacertidao->comarca = $prisao->cidadeunidade;
        $gravacertidao->push();
        \DB::commit();


        Logger::Success('Certidão  Carcerária ','Preso : '.$apenado->nomeapenado.'  Data Emissão: ' .date('d-m-y'). ' Servidor: ' .Auth::user()->nome);
        return $this->relatorio-> gerar_pdf_retrato('Certidão_Carceraria_'.$apenado->nomeapenado.'', $conteudo_html, '' );


    }

    public function formata_hash($hash)
    {
        $parte_um = substr($hash, 0, 4);
        $parte_dois = substr($hash, 4, 4);
        $parte_tres = substr($hash, 8, 4);
        $parte_quatro = substr($hash, 12, 2);
        return "$parte_um.$parte_dois.$parte_tres-$parte_quatro";
    }

}

