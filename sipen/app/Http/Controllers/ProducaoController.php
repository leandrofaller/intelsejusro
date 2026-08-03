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
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
        $producao = DB::table('producao as p')
            ->join('producao_tipo as pt', 'pt.id','=','p.tipo_id')
            ->join('producao_status as ps', 'ps.id','=','p.status_id')
            ->Where('p.id', $id)
            ->select('p.id as idRel', 'p.*', 'pt.descricao', 'ps.nomestatus')
            ->first();
 
        if (!$producao) {
            Flash::error("Relatório não encontrado.");
            return redirect()->back();
        }
 
        $html_completo = $this->montarHtmlRelatorio($producao);
        $html_tratado = $this->tratarImagensHtml($html_completo);
 
        $numeroRelatorio = $producao->numero.'-'.$producao->ano ;
        
        return $this->relatorio->gerar_pdf_relatorio_stream('Relatorio_'.$numeroRelatorio, $html_tratado, 'R');
    }
 
    public function exportarZip(Request $request)
    {
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
        try {
            $regiao = Unidade::where('regiao_id', Auth::user()->regiao_id)->select('id')->get();
            
            if (Auth::user()->regiao_id == 1) {
                $producoes = DB::table('producao as p')
                    ->join('producao_tipo as pt', 'pt.id','=','p.tipo_id')
                    ->join('producao_status as ps', 'ps.id','=','p.status_id')
                    ->orderby('p.numero', 'desc')
                    ->select('p.id as idRel', 'p.*', 'pt.descricao', 'ps.nomestatus')
                    ->get();
            } else {
                $producoes = DB::table('producao as p')
                    ->join('producao_tipo as pt', 'pt.id','=','p.tipo_id')
                    ->join('producao_status as ps', 'ps.id','=','p.status_id')
                    ->WhereIn('p.unidade_id', $regiao)
                    ->orderby('p.numero', 'desc')
                    ->select('p.id as idRel', 'p.*', 'pt.descricao', 'ps.nomestatus')
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
                    
                    $html_completo = $this->montarHtmlRelatorio($producao);
                    $html_tratado = $this->tratarImagensHtml($html_completo);
                    
                    $nomePdf = 'Relatorio_' . str_replace('/', '_', $numeroRelatorio) . '.pdf';
                    $pdfString = $this->relatorio->gerar_pdf_relatorio_string('Relatorio_'.$numeroRelatorio, $html_tratado, 'R');
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

    /**
     * Monta o HTML do relatório no padrão visual oficial (RELINT) para o TCPDF.
     */
    private function montarHtmlRelatorio($producao)
    {
        $numeroRelatorio = $producao->numero.'-'.$producao->ano;
        $chavecode = base64_encode($producao->chave);
        $dataFormatted = $producao->datarelatorio ? dataFormat($producao->datarelatorio) : '**********';
        $seguranca = $producao->seguranca ? $producao->seguranca : 'RESERVADO';

        $html = '
        <div style="background-color: #000000; color: #ffffff; text-align: center; font-weight: bold; font-size: 10px; line-height: 16px;">
            ' . e($seguranca) . '
        </div>
        <br><br>
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="20%" align="left" valign="middle">
                    <img src="public/logo_estado.png" width="55" height="35">
                </td>
                <td width="60%" align="center" valign="middle" style="font-size: 9px; line-height: 12px;">
                    <strong>GOVERNO DO ESTADO DE RONDÔNIA</strong><br>
                    <strong>SECRETARIA DE ESTADO DA JUSTIÇA</strong><br>
                    <strong>GERÊNCIA DE INTELIGÊNCIA PENITENCIÁRIA</strong><br>
                    <span style="font-size: 8px;">"CHAVE DE AUTENTICAÇÃO: ' . e($producao->chave) . ' "</span>
                </td>
                <td width="20%" align="right" valign="middle">
                    <img src="public/sejus-ro.png" width="30" height="35">
                </td>
            </tr>
        </table>
        <br>
        <hr style="color: #000000; height: 1px;">
        <br>

        <table width="100%" cellpadding="5" cellspacing="0" style="border: 1px solid #000000;">
            <tr style="background-color: #1c6ca2; color: #ffffff; font-weight: bold; font-size: 10px;">
                <td width="40%" style="border-right: 1px solid #000000;">' . e($producao->descricao) . '</td>
                <td width="30%" align="center" style="border-right: 1px solid #000000;">' . e($producao->numero) . '</td>
                <td width="30%" align="center">' . e($producao->origem ? $producao->origem : '**********') . '</td>
            </tr>
        </table>
        
        <table width="100%" cellpadding="4" cellspacing="0" style="border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000;">
            <tr style="background-color: #1a1a1a; color: #ffffff; font-size: 9px;">
                <td width="30%" style="border-bottom: 1px solid #333333; border-right: 1px solid #333333;"><strong>DATA:</strong></td>
                <td width="70%" style="border-bottom: 1px solid #333333;">' . e($dataFormatted) . '</td>
            </tr>
            <tr style="background-color: #1a1a1a; color: #ffffff; font-size: 9px;">
                <td style="border-bottom: 1px solid #333333; border-right: 1px solid #333333;"><strong>ASSUNTO:</strong></td>
                <td style="border-bottom: 1px solid #333333;">' . e($producao->assunto ? $producao->assunto : '**********') . '</td>
            </tr>
            <tr style="background-color: #1a1a1a; color: #ffffff; font-size: 9px;">
                <td style="border-bottom: 1px solid #333333; border-right: 1px solid #333333;"><strong>ORIGEM:</strong></td>
                <td style="border-bottom: 1px solid #333333;">' . e($producao->origem ? $producao->origem : '**********') . '</td>
            </tr>
            <tr style="background-color: #1a1a1a; color: #ffffff; font-size: 9px;">
                <td style="border-bottom: 1px solid #333333; border-right: 1px solid #333333;"><strong>DIFUSÃO:</strong></td>
                <td style="border-bottom: 1px solid #333333;">' . e($producao->difusao ? $producao->difusao : '**********') . '</td>
            </tr>
            <tr style="background-color: #1a1a1a; color: #ffffff; font-size: 9px;">
                <td style="border-bottom: 1px solid #333333; border-right: 1px solid #333333;"><strong>DIFUSÃO ANTERIOR:</strong></td>
                <td style="border-bottom: 1px solid #333333;">' . e($producao->difusaoanterior ? $producao->difusaoanterior : '**********') . '</td>
            </tr>
            <tr style="background-color: #1a1a1a; color: #ffffff; font-size: 9px;">
                <td style="border-bottom: 1px solid #333333; border-right: 1px solid #333333;"><strong>REFERÊNCIA:</strong></td>
                <td style="border-bottom: 1px solid #333333;">' . e($producao->referencia ? $producao->referencia : '**********') . '</td>
            </tr>
            <tr style="background-color: #1a1a1a; color: #ffffff; font-size: 9px;">
                <td style="border-right: 1px solid #333333;"><strong>ANEXO:</strong></td>
                <td>' . e($producao->anexo ? $producao->anexo : '**********') . '</td>
            </tr>
        </table>

        <br><br>
        <div style="text-align: center; font-weight: bold; font-size: 11px;">
            RESPOSTA AO PEDIDO DE INTELIGÊNCIA Nº ' . e($producao->numero) . '
        </div>
        <br>

        <div style="font-size: 10px; text-align: justify; line-height: 14px;">
            ' . $producao->conteudo . '
        </div>
        <br><br>

        <table width="100%" cellpadding="6" cellspacing="0" style="border: 1px solid #000000;">
            <tr>
                <td width="15%" align="center" valign="middle" style="border-right: 1px solid #000000;">
                    <img src="public/logogeii.jpeg" width="45">
                </td>
                <td width="70%" align="center" valign="middle" style="border-right: 1px solid #000000;">
                    <span style="font-weight: bold; font-size: 10px;">CHAVE DE AUTENTICAÇÃO</span><br>
                    <span style="font-weight: bold; font-size: 11px;">' . e($producao->chave) . '</span><br><br>
                    <div style="background-color: #000000; color: #ffffff; font-weight: bold; font-size: 10px; width: 100px; padding: 2px;">
                        ' . e($seguranca) . '
                    </div>
                </td>
                <td width="15%" align="center" valign="middle">
                    <tcpdf method="write2DBarcode" params="\'http://intelsejusro.com/sipen/code/' . $chavecode . '\', \'QRCODE,H\', \'\', \'\', 25, 25, \'\', \'N\', true" />
                </td>
            </tr>
        </table>

        <br>
        <table width="100%" cellpadding="4" cellspacing="0" style="border: 1px solid #000000; background-color: #ffffff;">
            <tr>
                <td style="font-size: 7px; color: #777777; text-align: justify; line-height: 10px;">
                    "O sigilo deste documento é protegido, nos termos da Lei Nº 12.527/2011. A difusão não autorizada deste documento caracteriza crime de violação de sigilo funcional, capitulado no art. 325 do Código Penal Brasileiro. Pena: Reclusão de 2 (dois) a 6 (seis) anos e multa."
                </td>
            </tr>
        </table>';

        return $html;
    }

    /**
     * Pré-processa o HTML do relatório resolvendo caminhos de imagens.
     * Converte as imagens encontradas localmente para Base64 (Data URI).
     * Isso evita problemas com parse_url e caminhos de arquivos acentuados no TCPDF.
     * Imagens não encontradas são substituídas por spans inline de aviso.
     */
    private function tratarImagensHtml($html)
    {
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Remove tags <a> mantendo o texto interno para evitar o bug de offset de URL do TCPDF no PHP 7.4/8.x
        $html = preg_replace('/<a[^>]*>(.*?)<\/a>/is', '$1', $html);

        $html = preg_replace_callback('/<img\s+[^>]*src=["\']([^"\']+)["\'][^>]*>/i', function($matches) {
            $imgTag = $matches[0];
            $src = $matches[1];
            $srcClean = trim($src);

            // Determina a parte relativa do caminho (sem barra inicial e sem o prefixo /sipen/public/)
            $relativePath = null;
            if (preg_match('/^\/?sipen\/public\/(.+)$/i', $srcClean, $pathMatches)) {
                $relativePath = $pathMatches[1];
            } elseif (preg_match('/^\/?public\/(.+)$/i', $srcClean, $pathMatches)) {
                $relativePath = $pathMatches[1];
            } else {
                $relativePath = ltrim($srcClean, '/');
            }

            if ($relativePath) {
                // O caminho físico absoluto local
                $localPath = public_path($relativePath);
                $localPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $localPath);
                
                // Se o arquivo físico existe no servidor, vamos convertê-lo para Base64
                if (file_exists($localPath)) {
                    try {
                        $imgData = file_get_contents($localPath);
                        if ($imgData !== false) {
                            $extension = strtolower(pathinfo($localPath, PATHINFO_EXTENSION));
                            $mime = 'image/' . ($extension === 'jpg' ? 'jpeg' : $extension);
                            $base64 = 'data:' . $mime . ';base64,' . base64_encode($imgData);
                            
                            // Substitui o atributo src pelo Data URI em Base64
                            return preg_replace('/src=["\']([^"\']+)["\']/i', 'src="' . $base64 . '"', $imgTag);
                        }
                    } catch (\Exception $e) {
                        // Caso ocorra falha na leitura, cai no fallback abaixo
                    }
                }
                
                // Se o arquivo físico não existe no servidor ou falhou a leitura
                return '<span style="color: red; font-style: italic; font-size: 9px;">[Imagem não encontrada: ' . basename($srcClean) . ']</span>';
            }

            return $imgTag;
        }, $html);

        return $html;
    }
}
