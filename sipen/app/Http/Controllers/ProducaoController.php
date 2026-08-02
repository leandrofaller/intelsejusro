<?php

namespace App\Http\Controllers;

use App\Model\Producao;
use App\Model\ProducaoStatus;
use App\Model\ProducaoTipo;
use App\Model\Regioes;
use App\Model\Unidade;
use App\Model\User;
use Illuminate\Http\Request;
use App\Classes\Relatorio;
use DB, Auth, Logger, Date, Flash;


class ProducaoController extends Controller
{

    public function __construct(Unidade $unidade, Producao $producao, Relatorio $relatorio)
    {
        $this->unidade = $unidade;
        $this->producao = $producao;
        $this->relatorio = $relatorio;
    }

    public function index(Request $request){
        try {
            $v['titulo'] = "PRODUÇÃO DE RELATÓRIOS";
            $v['subtitulo'] = "Relatórios";

           $regiao = Unidade::where('regiao_id', Auth::user()->regiao_id)->select('id')->get();


            $perfil = Auth::user()->perfil;
           // if ($perfil == 'Admin') {
            if (Auth::user()->regiao_id == 1) {
                    if ($request->has('parametro')) {
                           $v['producoes'] = DB::table('producao as p')
                            ->join('producao_tipo as pt', 'pt.id','=','p.tipo_id')
                            ->join('producao_status as ps', 'ps.id','=','p.status_id')
                            ->Where('p.assunto', 'LIKE', '%' . $request->input('parametro') . '%')
                            ->orWhere('p.conteudo', 'LIKE', '%' . $request->input('parametro') . '%')
                            ->orderby('p.numero', 'desc')
                            ->select('p.*', 'pt.descricao', 'ps.nomestatus')
                            ->get();
                    } else {
                      $v['producoes'] = DB::table('producao as p')
                            ->join('producao_tipo as pt', 'pt.id','=','p.tipo_id')
                            ->join('producao_status as ps', 'ps.id','=','p.status_id')
                            ->orderby('p.id', 'desc')
                            ->select('p.*', 'pt.descricao', 'ps.nomestatus')
                            ->get();
                    }
                }else{

                if ($request->has('parametro')) {
                    $v['producoes'] = DB::table('producao as p')
                        ->join('producao_tipo as pt', 'pt.id','=','p.tipo_id')
                        ->join('producao_status as ps', 'ps.id','=','p.status_id')
                        ->WhereIn('p.unidade_id', $regiao)
                        ->Where('p.assunto', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('p.conteudo', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orderby('p.numero', 'desc')
                        ->select('p.*', 'pt.descricao', 'ps.nomestatus')
                        ->get();
                } else {
                    $v['producoes'] = DB::table('producao as p')
                        ->join('producao_tipo as pt', 'pt.id','=','p.tipo_id')
                        ->join('producao_status as ps', 'ps.id','=','p.status_id')
                        ->WhereIn('p.unidade_id', $regiao)
                        ->orderby('p.numero', 'desc')
                        ->select('p.*', 'pt.descricao', 'ps.nomestatus')
                        ->get();
                }


            }


            $v['parametro'] = $request->input('parametro');
            return view('producao.index', $v);

        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }


    public function resumo(Request $request){
        try {
            $v['titulo'] = "RESUMO ESTATÍSTICO - PRODUÇÃO DE RELATÓRIOS";
            $v['subtitulo'] = "Relatórios";

                $v['tipos'] = DB::table('producao_tipo as p')
                    ->get();

            return view('producao.resumo', $v);

        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }

    public function resumolista(Request $request, $id){
        try {
            $v['titulo'] = "PRODUÇÃO DE RELATÓRIOS - RESUMO";
            $v['subtitulo'] = "Relatórios";

            $regiao = Unidade::where('regiao_id', Auth::user()->regiao_id)->select('id')->get();
            $perfil = Auth::user()->perfil;
            if (Auth::user()->regiao_id == 1) {

                    if ($request->has('parametro')) {
                       $v['producoes'] = DB::table('producao as p')
                            ->join('producao_tipo as pt', 'pt.id','=','p.tipo_id')
                            ->join('producao_status as ps', 'ps.id','=','p.status_id')
                            ->Where('p.tipo_id', $id)
                           ->Where('p.assunto', 'LIKE', '%' . $request->input('parametro') . '%')
                            ->orWhere('p.conteudo', 'LIKE', '%' . $request->input('parametro') . '%')
                            ->orderby('p.numero', 'desc')
                            ->select('p.*', 'pt.descricao', 'ps.nomestatus')
                            ->get();
                    } else {
                        $v['producoes'] = DB::table('producao as p')
                            ->join('producao_tipo as pt', 'pt.id','=','p.tipo_id')
                            ->join('producao_status as ps', 'ps.id','=','p.status_id')
                            ->Where('p.tipo_id', $id)
                            ->orderby('p.numero', 'desc')
                            ->select('p.*', 'pt.descricao', 'ps.nomestatus')
                            ->get();
                    }
            }else {

                if ($request->has('parametro')) {
                    $v['producoes'] = DB::table('producao as p')
                        ->join('producao_tipo as pt', 'pt.id', '=', 'p.tipo_id')
                        ->join('producao_status as ps', 'ps.id', '=', 'p.status_id')
                        ->Where('p.tipo_id', $id)
                        ->Where('p.assunto', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->WhereIn('p.unidade_id', $regiao)
                        ->orWhere('p.conteudo', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orderby('p.numero', 'desc')
                        ->select('p.*', 'pt.descricao', 'ps.nomestatus')
                        ->get();
                } else {
                    $v['producoes'] = DB::table('producao as p')
                        ->join('producao_tipo as pt', 'pt.id', '=', 'p.tipo_id')
                        ->join('producao_status as ps', 'ps.id', '=', 'p.status_id')
                        ->Where('p.tipo_id', $id)
                        ->WhereIn('p.unidade_id', $regiao)
                        ->orderby('p.numero', 'desc')
                        ->select('p.*', 'pt.descricao', 'ps.nomestatus')
                        ->get();
                }

            }
            $v['parametro'] = $request->input('parametro');
            return view('producao.resumolista', $v);

        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }

    public function novo()
    {
        try {
            $v['titulo'] = "NOVO - PRODUÇÃO DE RELATÓRIOS";
            $v['subtitulo'] = "Relatórios";

            $perfil = Auth::user()->perfil;
            $idUnid = Auth::user()->unidade_id;
            $regiao = Auth::user()->regiao_id;

            if ($perfil == 'Admin') {
                $v['unidades'] = $this->unidade->where('recebeapenados', 'Sim')->orderBy('nomeunidade')->get();
            } else {
                $v['unidades'] = $this->unidade->where('recebeapenados', 'Sim')->where('regiao_id', $regiao)->orderBy('nomeunidade')->get();
            }

            $v['tipo'] = ProducaoTipo::pluck('descricao', 'id');

            return view('producao.novo', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }


    public function salvar(Request $request)
    {
        try {
            $v['titulo'] = "SALVAR - PRODUÇÃO DE RELATÓRIOS";
            $v['subtitulo'] = "Relatórios";

            $gera =  DB::table('producao')->where('ano', date('Y'))->orderby('id', 'desc')->limit(1)->first();

            if(count($gera) > 0) {
                $codigo = $gera->codigo + 1;
                $numero = zeroAsquerda($codigo).'-'.date('Y');
            }else{
                $codigo = 1;
                $numero = zeroAsquerda(1).'-'.date('Y');
            }

            if($request->input('datarelatorio'))
            {
               $data = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datarelatorio'))));
            }else{
                $data = date('Y-m-d');
            }

            \DB::beginTransaction();

            $input = $request->all();
                $prod = $this->producao->fill($input);
                $prod->datarelatorio = $data;
                $prod->codigo = $codigo;
                $prod->numero = $numero;
                $prod->ano = date('Y');
                $prod->user_id = Auth::user()->id;
                $prod->status_id = 1; // rascunho

                $prod->push();

            \DB::commit();

            Flash::success(" Cadastro realizado com sucesso!");
            Logger::Success('Novo Relatório INTELIGENCIA (PRODUCAO)', 'Inserido Novo Relatório - ' . $request->input('numero') . ' ');
            return redirect()->route('producao.index');
            return redirect()->back();

        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
            Logger::error('Erro Apenado', 'Erro no faccaocadastro Apenado - ' . $e . ' ');
            return redirect()->back();
        }
    }


    public function editar($id)
    {
        $v['titulo'] = "EDITAR - PRODUÇÃO DE RELATÓRIOS";
        $v['subtitulo'] = "Relatórios";

        $perfil = Auth::user()->perfil;
        $idUnid = Auth::user()->unidade_id;

        $v['producao'] = Producao::find($id);

        if ($perfil == 'Admin') {
            $v['unidades'] = Unidade::pluck('nomeunidade', 'id');
            $v['status'] = ProducaoStatus::pluck('nomestatus', 'id');
        } else {
            $v['unidades'] = Unidade::where('id', $idUnid)->pluck('nomeunidade', 'id');
            $v['status'] = ProducaoStatus::where('id', 1)->pluck('nomestatus', 'id');
        }

        $v['tipo'] = ProducaoTipo::pluck('descricao', 'id');

        return view('producao.editar', $v);
    }

    public function update(Request $request, $id)
    {
        try {
            $v['titulo'] = "EDITAR SALVAR - PRODUÇÃO DE RELATÓRIOS";
            $v['subtitulo'] = "Relatórios";

            $prod = $this->producao->find($id);

            $tipoAtual = $prod->tipo_id;
            $tipoNovo = $request->input('tipo_id');

            \DB::beginTransaction();
            $prod->fill($request->all());

             //Se o status for igual a 2 grava hash
            $prod->datarelatorio = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datarelatorio'))));

            if ($request->input('status_id') == 2)
                {
                    $prod->chave = geraChave($id);
                }

            $prod->push();

            \DB::commit();
            $relatorio  = $prod->numero.'-'.$prod->ano ;

            Flash::success("Relatório {$relatorio}  Alterado com sucesso.");
            Logger::Success('Alteração de Relatório', 'Numero  - ' . $this->producao->numero . ' ');
            return redirect()->route('producao.index');
            return redirect()->back();

        } catch (\Exception $e) {
            \DB::rollBack();
            return $e->getMessage();
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        try
        {
            $this->producao->where('id',$id)->delete();
            Flash::success("Relatório Excluido com Sucesso.");
            Flash::success('Exclusão de Relatório!!');
            return redirect()->route('producao.index');
        }
        catch (\Exception $e) {
            $e->getMessage();
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }








public function visualizar($id, Request $request)
{

    $v['title'] = 'IMPRIMIR';


    $v['producao'] = DB::table('producao as p')
        ->join('producao_tipo as pt', 'pt.id','=','p.tipo_id')
        ->join('producao_status as ps', 'ps.id','=','p.status_id')
        ->Where('p.id', $id)
        ->orderby('p.numero', 'desc')
        ->select('p.id as idRel', 'p.*', 'pt.descricao', 'ps.nomestatus')
        ->first();

    return view('producao.visualizar', $v);

}



    public function imprimir($id, Request $request)
    {
        $producao = DB::table('producao as p')
            ->Where('p.id', $id)
            ->first();

//        $conteudo_html =
//            '<table width="100%" border="0" cellspacing="0" cellpadding="3">' .
//            '<tr>' .
//            '<td style="text-align:center; width:15%;">' .
//            '<img src="../public/logo_estado.png" width="70px" height="45px"></td>' .
//            '<td colspan="10" style="text-align:center; font-size:12px; padding: 0px, 0px,0px,0px; width:70%;">' .
//            '<strong> GOVERNO DO ESTADO DE RONDÔNIA </strong> <br>' .
//            '<strong> SECRETARIA DE ESTADO DE JUSTIÇA </strong> <br>' .
//            '<strong> <span style="font-size:10px"> ' . $producao->unidade_id . ' </strong> </span> <br> ' .
//            '<strong> <span style="font-size:10px"> DIREÇÃO ADMINISTRATIVA </strong> </span> ' .
//            '</td>' .
//            '<td style="text-align:center; width:15%;">' .
//            '<img src="../public/sejus-ro.png" width="40px" height="60px"> </td>' .
//            '</tr>' .
//            '</table>';

        $conteudo_html =
            '<br>' .
            '<br>' .
            '<br>' .
            '<br>' .
            '<br>' .
            '<h1 style="text-align: center;"> NUCLEO DE ANÁLISE </h1>'.
            '<br>'.
            '<br>'.
            '<br>'.
            '<br>'.
            '<br>' ;

        $numeroRelatorio = $producao->numero.'-'.$producao->ano ;
        $conteudo_html .=
            '<br><br><br><p align="left">Número: <strong>'.$numeroRelatorio.'</strong> </p>'
        ;


        $conteudo_html .=
            $producao->conteudo        ;


        $conteudo_html .=
            '<br>'.
            '<b style="text-align: left;"> Chave: </b>'.
            '<b style="text-align: left;"> '.$producao->chave.' </b>'
        ;


        $conteudo_html .=
            '<br><br><p align="right" > Porto Velho '. \Jenssegers\Date\Date::now()->format('j F Y') .'</p>'
        ;



     //   Logger::Success('Certidão  Carcerária ','Preso : '.$apenado->nomeapenado.'  Data Emissão: ' .date('d-m-y'). ' Servidor: ' .Auth::user()->nome);
        return $this->relatorio-> gerar_pdf_retrato('Relatorio_'.$numeroRelatorio.'', $conteudo_html, '' );
    }

    public function exportarZip(Request $request)
    {
        try {
            $regiao = Unidade::where('regiao_id', Auth::user()->regiao_id)->select('id')->get();
            
            if (Auth::user()->regiao_id == 1) {
                $producoes = DB::table('producao as p')
                    ->orderby('p.numero', 'desc')
                    ->get();
            } else {
                $producoes = DB::table('producao as p')
                    ->WhereIn('p.unidade_id', $regiao)
                    ->orderby('p.numero', 'desc')
                    ->get();
            }

            if ($producoes->isEmpty()) {
                Flash::error("Nenhum relatório encontrado para exportar.");
                return redirect()->back();
            }

            $zip = new \ZipArchive();
            $zipName = 'Relatorios_Producao_' . date('d-m-Y_His') . '.zip';
            $tempZipPath = tempnam(sys_get_temp_dir(), 'zip');

            if ($zip->open($tempZipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                foreach ($producoes as $producao) {
                    $numeroRelatorio = $producao->numero.'-'.$producao->ano;
                    
                    $conteudo_html =
                        '<br><br><br><br><br>' .
                        '<h1 style="text-align: center;"> NUCLEO DE ANÁLISE </h1>'.
                        '<br><br><br><br><br>' .
                        '<br><br><br><p align="left">Número: <strong>'.$numeroRelatorio.'</strong> </p>' .
                        $producao->conteudo .
                        '<br><b style="text-align: left;"> Chave: </b><b style="text-align: left;"> '.$producao->chave.' </b>' .
                        '<br><br><p align="right" > Porto Velho '. \Jenssegers\Date\Date::now()->format('j F Y') .'</p>';

                    if (!defined('K_PATH_IMAGES')) {
                        define('K_PATH_IMAGES', public_path() . '/');
                    }

                    $pdf = new \TCPDF();
                    $pdf->SetAuthor('sejus');
                    $pdf->SetTitle('Relatorio ' . $numeroRelatorio);
                    $pdf->SetSubject('Relatorio ' . $numeroRelatorio);
                    
                    $pdf->SetHeaderData('sejus-ro.jpg', 10, 'GOVERNO DO ESTADO DE RONDÔNIA', 'SECRETARIA DE ESTADO DE JUSTIÇA');
                    $pdf->SetMargins(5, 25, 5);
                    $pdf->SetHeaderMargin(5);
                    $pdf->SetRightMargin(5);
                    $pdf->SetFooterMargin(10);
                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->setHeaderFont(Array('helvetica', '', 14));
                    
                    $pdf->AddPage('P', 'A4');
                    $pdf->writeHTML($conteudo_html);
                    $pdf->lastPage();
                    
                    $pdfString = $pdf->output('', 'S');
                    $nomePdf = 'Relatorio_' . str_replace('/', '_', $numeroRelatorio) . '.pdf';
                    $zip->addFromString($nomePdf, $pdfString);
                }
                $zip->close();
            } else {
                throw new \Exception("Não foi possível criar o arquivo ZIP temporário.");
            }

            Logger::Success('Exportar ZIP de Relatórios', 'Realizado o download de todos os relatórios em formato ZIP (' . count($producoes) . ' arquivos)');

            return response()->download($tempZipPath, $zipName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Flash::error('Erro ao exportar relatórios para ZIP: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
