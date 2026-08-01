<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApenadosRequest;
use App\Model\Advogado;
use App\Model\AdvogadosApenados;
use App\Model\Alcunha;
use App\Model\Anexo;
use App\Model\Carceragem;
use App\Model\CargosFaccao;
use App\Model\Cela;
use App\Model\Classificacao;
use App\Model\Endereco;
use App\Model\Estado;
use App\Model\Faccao;
use App\Model\Fotos;
use App\Model\Fuga;
use App\Model\Informacao;
use App\Model\Integrantes;
use App\Model\LogCelas;
use App\Model\Logger;
use App\Model\MedidaDisciplinar;
use App\Model\Movimentacao;
use App\Model\Pad;
use App\Model\Processo;
use App\Model\VisitasApenados;
use Illuminate\Http\Request;
use DB;
use App\Model\Apenado;
use App\Model\Unidade;
use Illuminate\Support\Facades\Auth;
use File, Flash, Redirect;

class ApenadosController extends Controller
{
    protected $apenModel;
    protected $unidadeModel;
    protected $carceragemModel;
    protected $processoModel;
    protected $movimentacaoModel;
    protected $celaModel;
    protected $integranteModel;
    protected $faccaoModel;
    protected $cargofaccaoModel;
    protected $informacoesModel;
    protected $fugaModel;

    public function __construct(Processo $processoModel, Movimentacao $movimentacaoModel, Apenado $apenModel,
                                Unidade $unidadeModel, Carceragem $carceragemModel, Cela $celaModel,
                                Integrantes $integranteModel, Faccao $faccaoModel, CargosFaccao $cargosFaccaoModel,
                                Informacao $informacoesModel, Fuga $fugaModel)
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
    }

    public function index(Request $request)
    {
        try {

            $v['titulo'] = " APENADOS";
            $v['subtitulo'] = " Relação de apenados";

            $perfil = Auth::user()->perfil;
            if ($perfil == 'Admin') {
                //PERFIL = 'ADMIN' = MOSTRAR TODOS APENADOS DA UNIDADE DO USUÁRIO
                if ($request->has('parametro')) {
                    $v['apenados'] = DB::table('apenados as a')
                        ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.cpf', $request->input('parametro'))
                        ->orWhere('a.id', $request->input('parametro'))
                        ->orderby('a.nomeapenado', 'asc')
                        ->paginate(10);
                } else {

                    $v['apenados'] = DB::table('apenados as a')
                        ->orderby('a.nomeapenado', 'asc')
                        ->paginate(10);
                }
            } else {
                //BLOCO DE VALIDAÇÃO PARA MOSTRAR SOMENTE OS APENADOS DA UNIDADE DO USUÁRIO
                $idUnidadeUser = Auth::user()->unidade_id;
                if ($request->has('parametro')) {
                    $v['apenados'] = DB::table('apenados as a')
                        ->join('fotos as f', 'f.apenado_id', '=', 'a.id')
                        ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                        ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                        ->Where('m.unidade_id', '=', '' . $idUnidadeUser . '')
                        ->Where('m.datasaida', '=', NULL)
                        ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.cpf', $request->input('parametro'))
                        ->orWhere('a.id', $request->input('parametro'))
                        ->select('a.*')
                        ->orderby('a.nomeapenado', 'asc')
                        ->paginate(10);
                } else {
                    $v['apenados'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                        ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                        ->Where('m.unidade_id', '=', '' . $idUnidadeUser . '')
                        ->Where('m.datasaida', '=', NULL)
                        ->select('a.*')
                        ->orderby('a.nomeapenado', 'asc')
                        ->paginate(10);
                }
            }

            $v['parametro'] = $request->input('parametro');
            return view('apenados.index', $v);

        } catch (\Exception $e) {
            return $e;
            //$this->auxiliar->GetExeption($e);
            return redirect()->back();
        }
    }

    public function autocomplete(Request $request)
    {

        $query = $request->get('term', '');
        // $products= Apenado::where('nomeapenado','LIKE','%'.$query.'%')->get();

        $buscas = DB::table('apenados as a')
            ->join('processos as p', 'a.id', '=', 'p.apenado_id')
            ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
            ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
            // ->Where('m.datasaida','=', NULL )
            ->Where('a.nomeapenado', 'LIKE', '%' . $query . '%')
            ->orWhere('a.cpf', 'LIKE', '%' . $query . '%')
            ->orWhere('a.nomepai', 'LIKE', '%' . $query . '%')
            ->orWhere('a.nomemae', 'LIKE', '%' . $query . '%')
//            ->orWhere('a.alcunha', 'LIKE', '%' . $query . '%')
            ->select('a.*')
            ->orderby('a.nomeapenado', 'asc')
            ->groupby('a.id')
            ->get();

        $data = array();
        foreach ($buscas as $busca) {
            $data[] = array('value' => $busca->nomeapenado, 'id' => $busca->id);
        }
        if (count($data))
            return $data;
        else
            return ['value' => 'Nada Encontrado', 'id' => ''];

    }

    public function novo()
    {
        try {
            $v['titulo'] = " APENADOS";
            $v['subtitulo'] = " Novo Cadastro";

            $perfil = Auth::user()->perfil;
            $idUnid = Auth::user()->unidade_id;


            if ($perfil == 'Admin') {
                //$v['unidades'] = $this->unidadeModel->all();
                $v['unidades'] = $this->unidadeModel->where('recebeapenados', 'Sim')->orderBy('nomeunidade')->get();

            } else {
                //$v['unidades'] = $this->unidadeModel->where('id', $idUnid)->get();
              //  $v['unidades'] = $this->unidadeModel->where('recebeapenados', 'Sim')->where('id', $idUnid)->orderBy('nomeunidade')->get();
                $v['unidades'] = $this->unidadeModel->where('recebeapenados', 'Sim')->where('regiao_id', Auth::user()->regiao_id)->orderBy('nomeunidade')->get();

            }

            $v['classificacao'] = Classificacao::pluck('sigla', 'id');
            $v['estados'] = Estado::pluck('nome', 'sigla');
            $v['estados'][0] = '';
            return view('apenados.novo', $v);
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }


    public function salvar(ApenadosRequest $request)
    {
        try {
            $v['titulo'] = " APENADOS";
            $v['subtitulo'] = " Novo Cadastro";

            $input = $request->all();
            //VERIFICA SE O APENADO JÁ ESTÁ CADASTRADO NO BD
            // $pesquisa = DB::table('apenados')->where('cpf', $request->input('cpf'))
            //     ->select('id')
            //     ->first();

            //    if(count($pesquisa) <= 0) {


            \DB::beginTransaction();

            $apen = $this->apenModel->fill($input);
            $apen->datacadastro = date("Y-m-d");
            $apen->datanascimento = $request->input('datanascimento') ? date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datanascimento')))) : null ;
            $apen->push();



            //INÍCIO - INSERE A FOTO
            // return $request->file('foto');
            $foto = new Fotos();
            $foto->atual_foto = 'S';
            $foto->descricao_foto = '';
            $foto->apenado_id = $apen->id;
            $foto->user_id = Auth::user()->id;

            if ($request->file('foto')) {
                $foto1 = $request->file('foto');
                 $extensao = $foto1->getClientOriginalExtension();
                if ($extensao != 'jpg' && $extensao != 'JPG' && $extensao != 'jpeg' && $extensao != 'JPEG' && $extensao != 'png' && $extensao != 'PNG') {
                    Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Este arquivo não é uma foto.");
                    return redirect()->route('apenados.novo');
                    return redirect()->back();
                }

                $nomefoto = sha1(microtime()) . '.' . $extensao;
                File::copy($foto1, public_path() . '/fotosPresos/' . $nomefoto);
                $foto->arquivo_foto = 'fotosPresos/' . $nomefoto;
            } else {
                $foto->arquivo_foto = 'fotosPresos/semfoto.png';
            }
             $foto->push();
            //FIM - INSERE A FOTO


                $idApen = $apen->id;

            //INICIA O PROCESSO DE INSERÇÃO DA ALCUNHA
            if ($request->input('alcunha')) {
                $alcunha = new Alcunha();
                $alcunha->nome_alcunha = $request->input('alcunha');
                $alcunha->atual_alcunha = 'S';
                $alcunha->apenado_id = $apen->id;
                $alcunha->user_id = Auth::user()->id;
                //FIM O PROCESSO DE INSERÇÃO DA ALCUNHA
                $alcunha->push();
            }

            //INICIA O CADASTRO DE ENDEREÇO

            if ($request->input('rua')) {
                $endereco = new Endereco();
                $endereco->rua_endereco = $request->input('rua');
                $endereco->numero_endereco = $request->input('numero');
                $endereco->bairro_endereco = $request->input('bairro');
                $endereco->uf_endereco = $request->input('estado');
                $endereco->cidade_endereco = $request->input('cidade');
                $endereco->apenado_id = $apen->id;
                $endereco->user_id = Auth::user()->id;
                //FIM O CADASTRO DE ENDEREÇO
                $endereco->push();
            }



            //INICIA A INSERÇÃO DA PRISAO
            $processo = new Processo();
            if ($request->input('numeroprocesso')) {
                $processo->numeroprocesso = $request->input('numeroprocesso');
            }else{
                $processo->numeroprocesso = 'Não Informado';
            }
            $processo->vara = $request->input('vara');
            $processo->tipificacao = '';
            $processo->principal = 'S';
            $processo->artigos = $request->input('artigos');
            $processo->datacondenacao = $request->input('datacondenacao') == '' ? null : date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datacondenacao'))));
            $processo->tempodepena = $request->input('tempodepena');
            $processo->dataprisao = $request->input('dataprisao') == '' ? null : date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataprisao'))));
            $processo->databeneficio = $request->input('databeneficio') == '' ? null : date("Y-m-d", strtotime(str_replace('/', '-', $request->input('databeneficio'))));
            $processo->apenado_id = $idApen;
            $processo->push();

            $idProces = $processo->id;
            //INICIA A INSERÇÃO DO MOVIMENTAÇÃO
            $movimentacao = new Movimentacao();
            if ($request->input('regime')) {
                $movimentacao->regime = $request->input('regime');
            }else{
                $movimentacao->regime = 'Não Identificado';
                }
            $movimentacao->dataentrada = $request->input('dataentrada') ? date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataentrada')))) : null;
            $movimentacao->oficioentrada = $request->input('oficioentrada');
            $movimentacao->presooriundo = $request->input('presooriundo');
            $movimentacao->situacao = $request->input('situacao');
            $movimentacao->monitorado = $request->input('monitorado');
            $movimentacao->unidadeorigem = $request->input('unidade_id');
            $movimentacao->processo_id = $idProces;
            $movimentacao->classificacao_id = $request->input('classificacao_id');
            $movimentacao->unidade_id = $request->input('unidade_id');
            $movimentacao->cela_id = $request->input('cela_id');
            $movimentacao->push();


            \DB::commit();

            Flash::success(" Cadastro realizado com sucesso!");
            Logger::Success('Novo Apenado', 'Inserido Novo Apenado - ' . $request->input('nomeapenado') . ' ');
            return redirect()->route('apenados.index');
            return redirect()->back();

        } catch (\Exception $e) {
            \DB::rollBack();
            return $e;
            Logger::error('Erro Apenado', 'Erro no faccaocadastro Apenado - ' . $e . ' ');
            return redirect()->back();
        }
    }

    public function selecionarOpcao($idApen)
    {
        $v['titulo'] = " APENADOS";
        $v['subtitulo'] = " Selecione a Opção";

        $v['apenado'] = DB::table('apenados as a')
            ->join('processos as p', 'a.id', '=', 'p.apenado_id')
            ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
            ->Where('m.datasaida', '=', NULL)
            ->Where('a.id', '=', '' . $idApen . '')
            ->select('a.id as idApen', 'a.*', 'p.id as idProcesso', 'p.*', 'm.id as idMovimentacao', 'm.*')
            ->first();
        return view('apenados.selecionarOpcao', $v);
    }

    public function editar($idApen)
    {
        $v['titulo'] = " APENADOS";
        $v['subtitulo'] = " Editar Cadastro";

        $v['apenado'] = DB::table('apenados as a')
            ->join('processos as p', 'a.id', '=', 'p.apenado_id')
            ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
            ->Where('m.datasaida', '=', NULL)
            ->Where('a.id', '=', '' . $idApen . '')
            ->select('a.id as idApen', 'a.*', 'p.id as idProcesso', 'p.*', 'm.id as idMovimentacao', 'm.*')
            ->first();

        $v['classificacao'] = Classificacao::pluck('sigla', 'id');

        $v['estados'] = Estado::pluck('nome', 'sigla');
        $v['estados'][0] = '';

        return view('apenados.editar', $v);
    }

    public function update(ApenadosRequest $request, $id)
    {
        try {
            $v['titulo'] = " APENADOS";
            $v['subtitulo'] = " Editar Cadastro";

            $apen = $this->apenModel->find($request->input('idApen'));

            \DB::beginTransaction();
            $apen->nomeapenado = $request->input('nomeapenado');
//            $apen->alcunha = $request->input('alcunha');
            $apen->rg = $request->input('rg');
            $apen->cpf = $request->input('cpf');
            $apen->datanascimento = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datanascimento'))));
            $apen->nomepai = $request->input('nomepai');
            $apen->nomemae = $request->input('nomemae');
            $apen->sexo = $request->input('sexo');
            $apen->etnia = $request->input('etnia');
            $apen->escolaridade = $request->input('escolaridade');
            $apen->naturalidade = $request->input('naturalidade');
//            $apen->rua = $request->input('rua');
//            $apen->numero = $request->input('numero');
//            $apen->bairro = $request->input('bairro');
//            $apen->estado = $request->input('estado');
//            $apen->cidade = $request->input('cidade');

            //INSERE A FOTO
//            if ($request->file('foto')) {
//                $foto = $request->file('foto');
//                $extensao = $foto->getClientOriginalExtension();
//                if ($extensao != 'jpg' && $extensao != 'JPG' && $extensao != 'jpeg' && $extensao != 'JPEG' && $extensao != 'png' && $extensao != 'PNG') {
//                    Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Este arquivo não é uma foto.");
//                    return redirect()->route('apenados.editar', $id);
//                    return redirect()->back();
//                }
//            }

//            if ($request->file('foto')) {
//                $nomefoto = sha1(microtime()) . '.' . $extensao;
//                File::copy($foto, public_path() . '/fotosPresos/' . $nomefoto);
//                //File::move($foto, public_path().'/fotosPresos/foto-id_'.$apen->id.'.'.$extensao);
//                $apen->foto = 'fotosPresos/' . $nomefoto;
//
//            } else {
                //   $apen->foto = 'fotosPresos/semfoto.png';
//            }

            $apen->push();

            //INICIA A ATUALIZAÇÃO DO PROCESSOS
            $processo = $this->processoModel->find($request->input('idProcesso'));
            $processo->numeroprocesso = $request->input('numeroprocesso');
            $processo->vara = $request->input('vara');
            $processo->tipificacao = '';
            $processo->principal = 'S';
            $processo->artigos = $request->input('artigos');
            $processo->datacondenacao = $request->input('datacondenacao') == '' ? null : date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datacondenacao'))));
            $processo->tempodepena = $request->input('tempodepena');
            $processo->dataprisao = $request->input('dataprisao') == '' ? null : date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataprisao'))));
            $processo->databeneficio = $request->input('databeneficio') == '' ? null : date("Y-m-d", strtotime(str_replace('/', '-', $request->input('databeneficio'))));

            $processo->push();

            //INICIA A INSERÇÃO DO MOVIMENTAÇÃO
            $movimentacao = $this->movimentacaoModel->find($request->input('idMovimentacao'));
            $movimentacao->regime = $request->input('regime');
            $movimentacao->dataentrada = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataentrada'))));
            $movimentacao->oficioentrada = $request->input('oficioentrada');
            $movimentacao->presooriundo = $request->input('presooriundo');
            $movimentacao->situacao = $request->input('situacao');
            $movimentacao->classificacao_id = $request->input('classificacao_id');
            $movimentacao->monitorado = $request->input('monitorado');

            $movimentacao->push();

            \DB::commit();

            Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Alteração realizada com sucesso!");
            Logger::Success('Novo Apenado', 'Inserido Novo Apenado - ' . $request->input('nomeapenado') . ' ');
            return redirect()->route('apenados.index');
            return redirect()->back();

        } catch (\Exception $e) {
            \DB::rollBack();
            return $e->getMessage();
            $this->$apen->GetExeption($e);
            return redirect()->back();
        }
    }


    public function novaentrada($idApen)
    {
        $v['titulo'] = " APENADOS";
        $v['subtitulo'] = " Nova Entrada ";

        $v['apenado'] = DB::table('apenados as a')
            ->Where('a.id', '=', '' . $idApen . '')
            ->select('a.*')
            ->first();

        $v['unidades'] = $this->unidadeModel->where('recebeapenados', 'Sim')->orderBy('nomeunidade')->get();
        $v['classificacao'] = Classificacao::pluck('sigla', 'id');

        return view('apenados.novaentrada', $v);
    }

    public function novaentradaSalvar(Request $request, $id)
    {
        try {
            $v['titulo'] = " APENADOS";
            $v['subtitulo'] = " Nova entrada";

            $apen = $this->apenModel->find($id);
            \DB::beginTransaction();
            $apen->nomeapenado = $request->input('nomeapenado');
            $apen->alcunha = $request->input('alcunha');
            $apen->rg = $request->input('rg');
            $apen->cpf = $request->input('cpf');
            $apen->datanascimento = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datanascimento'))));
            $apen->nomepai = $request->input('nomepai');
            $apen->nomemae = $request->input('nomemae');
            $apen->sexo = $request->input('sexo');
            $apen->etnia = $request->input('etnia');
            $apen->escolaridade = $request->input('escolaridade');
            $apen->naturalidade = $request->input('naturalidade');
            $apen->rua = $request->input('rua');
            $apen->numero = $request->input('numero');
            $apen->bairro = $request->input('bairro');
            $apen->estado = $request->input('estado');
            $apen->cidade = $request->input('cidade');

            //INSERE A FOTO
            if ($request->file('foto')) {
                $foto = $request->file('foto');
                $extensao = $foto->getClientOriginalExtension();
                if ($extensao != 'jpg' && $extensao != 'JPG' && $extensao != 'jpeg' && $extensao != 'JPEG' && $extensao != 'png' && $extensao != 'PNG') {
                    Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Este arquivo não é uma foto.");
                    return redirect()->route('apenados.novaentrada', $id);
                    return redirect()->back();
                }
            }

            if ($request->file('foto')) {
                $nomefoto = sha1(microtime()) . '.' . $extensao;
                File::copy($foto, public_path() . '/fotosPresos/' . $nomefoto);
                //File::move($foto, public_path().'/fotosPresos/foto-id_'.$apen->id.'.'.$extensao);
                $apen->foto = 'fotosPresos/' . $nomefoto;

            } else {
                //   $apen->foto = 'fotosPresos/semfoto.png';
            }


            $apen->push();

            //INICIA A INSERÇÃO DA PRISAO
            $processo = new Processo();
            $processo->apenado_id = $id;
            $processo->numeroprocesso = $request->input('numeroprocesso');
            $processo->vara = $request->input('vara');
            $processo->tipificacao = '';
            $processo->principal = 'S';
            $processo->artigos = $request->input('artigos');
            $processo->datacondenacao = $request->input('datacondenacao') == '' ? null : date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datacondenacao'))));
            $processo->tempodepena = $request->input('tempodepena');
            $processo->dataprisao = $request->input('dataprisao') == '' ? null : date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataprisao'))));
            $processo->databeneficio = $request->input('databeneficio') == '' ? null : date("Y-m-d", strtotime(str_replace('/', '-', $request->input('databeneficio'))));
            $processo->push();

            //INICIA A INSERÇÃO DO MOVIMENTAÇÃO
            $movimentacao = new Movimentacao();
            $movimentacao->processo_id = $processo->id;
            $movimentacao->unidade_id = $request->input('unidade_id');
            $movimentacao->cela_id = $request->input('cela_id');
            $movimentacao->regime = $request->input('regime');
            $movimentacao->dataentrada = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataentrada'))));
            $movimentacao->oficioentrada = $request->input('oficioentrada');
            $movimentacao->presooriundo = $request->input('presooriundo');
            $movimentacao->situacao = $request->input('situacao');
            $movimentacao->monitorado = $request->input('monitorado');
            $movimentacao->classificacao_id = $request->input('classificacao_id');

            $movimentacao->push();

            \DB::commit();

            Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Alteração realizada com sucesso!");
            Logger::Success('Novo Apenado', 'Inserido Novo Apenado - ' . $request->input('nomeapenado') . ' ');
            return redirect()->route('apenados.index');
            return redirect()->back();


        } catch (\Exception $e) {
            \DB::rollBack();
            return $e->getMessage();
            $this->$apen->GetExeption($e);
            return redirect()->back();
        }

    }


    public function mudarcela($id)
    {
        try {
            $v['titulo'] = " APENADOS";
            $v['subtitulo'] = " Mudança de Cela";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id', '=', '' . $id . '')
                ->Where('m.datasaida', '=', NULL)
                ->select('a.*', 'p.numeroprocesso', 'm.id as idMovimentacao', 'm.unidade_id', 'm.cela_id', 'c.nomecela', 'u.nomeunidade')
                ->first();
            //return $v['apenado']->id;
            $v['carceragens'] = $this->carceragemModel->where('unidade_id', $v['apenado']->unidade_id)->orderBy('nomecarceragem', 'asc')->get();

            $v['log'] = DB::table('log_mudancadecelas as l')
                ->join('apenados as a', 'a.id', '=', 'l.apenado_id')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('m.datasaida', '=', NULL)
                ->Where('l.apenado_id', '=', '' . $id . '')
                ->Where('l.unidade_id', '=', $v['apenado']->unidade_id)
                ->select('l.*', 'c.nomecela')
                ->orderby('datamudanca', 'desc')
                ->get();

            return view('apenados.mudarcela', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }

    public function mudarcelaSalvar(Request $request, $id)
    {
        try {
            $validator = validator($request->all(),
                ['cela_id' => 'required', 'motivomudanca' => 'required']);
            if ($validator->fails()) {
                return redirect()->route('apenados.mudarcela', $id)->withInput()->withErrors($validator);
            }

            $movimentacao = $this->movimentacaoModel->find($request->input('idMovimentacao'));
            $celaDE = $movimentacao->cela_id;
            $movimentacao->cela_id = $request->input('cela_id');
            $movimentacao->save();

            if ($movimentacao) {
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Cela Alterada com sucesso!");
                LogCelas::Success($id, $request->input('datamudanca'), $movimentacao->unidade_id, $movimentacao->processo_id, $request->input('idMovimentacao'), $request->input('motivomudanca'), $celaDE, $request->input('cela_id'), $request->input('autorizadopor'), $request->input('transferidopor'), $request->input('descricao'));
                return redirect()->route('apenados.mudarcela', $id);
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$apen->GetExeption($e);
            return redirect()->back();
        }

    }


    public function alcunhas($id)
    {
        try {
            $v['titulo'] = " APENADOS - ALCUNHAS";
            $v['subtitulo'] = " Mudança de Alcunha";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id', '=', '' . $id . '')
                ->Where('m.datasaida', '=', NULL)
                ->select('a.*', 'p.numeroprocesso', 'm.id as idMovimentacao', 'm.unidade_id', 'm.cela_id', 'c.nomecela', 'u.nomeunidade')
                ->first();

            $v['alcunhas'] = DB::table('alcunhas as a')
                ->Where('a.apenado_id', $id)
                ->orderby('nome_alcunha', 'desc')
                ->get();
            return view('apenados.alcunhas', $v);
        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }

    public function alcunhasSalvar(Request $request, $id)
    {
        try {
            $validator = validator($request->all(),
                ['nome_alcunha' => 'required' ]);
            if ($validator->fails()) {
                return redirect()->route('apenados.alcunhas', $id)->withInput()->withErrors($validator);
            }

            $alcunha = new Alcunha();
            $alcunha->nome_alcunha = $request->input('nome_alcunha');
            $alcunha->atual_alcunha = null;
            $alcunha->user_id = Auth::user()->id;
            $alcunha->apenado_id = $request->input('idApenado');

            $alcunha->save();

            if ($alcunha) {
                Flash::success("Alcunha Alterada com sucesso!");
                //LogCelas::Success($id, $request->input('datamudanca'), $movimentacao->unidade_id, $movimentacao->processo_id, $request->input('idMovimentacao'), $request->input('motivomudanca'), $celaDE, $request->input('cela_id'), $request->input('autorizadopor'), $request->input('transferidopor'), $request->input('descricao'));
                return redirect()->route('apenados.alcunhas', $id);
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$apen->GetExeption($e);
            return redirect()->back();
        }

    }

    public function alcunhaPrincipal($id, $idApen)
    {
        try {

            //FAZ O UPDATE PARA O ATUAL
            Alcunha::where('apenado_id', $idApen)->update(array('atual_alcunha' => NULL));
            //FAZ O UPDATE PARA O ATUAL
            Alcunha::where('id', $id)->update(array('atual_alcunha' => 'S'));
            Flash::success("Alterado Com Sucesso!");
            return redirect()->back();

        } catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Alcunha Principal historicos', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }




    public function enderecos($id)
    {
        try {
            $v['titulo'] = " APENADOS - ENDEREÇOS";
            $v['subtitulo'] = " Cadastro de Endereço";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id', '=', '' . $id . '')
                ->Where('m.datasaida', '=', NULL)
                ->select('a.*', 'p.numeroprocesso', 'm.id as idMovimentacao', 'm.unidade_id', 'm.cela_id', 'c.nomecela', 'u.nomeunidade')
                ->first();

            $v['enderecos'] = DB::table('enderecos as e')
                ->Where('e.apenado_id', $id)
                ->orderby('created_at', 'desc')
                ->get();

            $v['estados'] = Estado::pluck('nome', 'sigla');
            $v['estados'][0] = '';

            return view('apenados.enderecos', $v);
        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }




    public function enderecosSalvar(Request $request, $id)
    {
        try {
            $validator = validator($request->all(),
                ['rua_endereco' => 'required', 'numero_endereco' => 'required', 'complemento_endereco' => 'required',
                 'bairro_endereco' => 'required', 'uf_endereco' => 'required', 'cidade_endereco' => 'required',
                ]);
            if ($validator->fails()) {
                return redirect()->route('apenados.enderecos', $id)->withInput()->withErrors($validator);
            }

            $salvar = new Endereco();
            $salvar->rua_endereco = $request->input('rua_endereco');
            $salvar->numero_endereco = $request->input('numero_endereco');
            $salvar->complemento_endereco = $request->input('complemento_endereco');
            $salvar->bairro_endereco = $request->input('bairro_endereco');
            $salvar->uf_endereco = $request->input('uf_endereco');
            $salvar->cidade_endereco = $request->input('cidade_endereco');

            $salvar->user_id = Auth::user()->id;
            $salvar->apenado_id = $request->input('idApenado');

            $salvar->save();

            if ($salvar) {
                Flash::success("Endereço Salvo com sucesso!");
                //LogCelas::Success($id, $request->input('datamudanca'), $movimentacao->unidade_id, $movimentacao->processo_id, $request->input('idMovimentacao'), $request->input('motivomudanca'), $celaDE, $request->input('cela_id'), $request->input('autorizadopor'), $request->input('transferidopor'), $request->input('descricao'));
                return redirect()->route('apenados.enderecos', $id);
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$apen->GetExeption($e);
            return redirect()->back();
        }

    }


    public function fotos($id)
    {
        try {
            $v['titulo'] = " APENADOS - FOTOS";
            $v['subtitulo'] = "Cadastro de Fotos";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id', '=', '' . $id . '')
                ->Where('m.datasaida', '=', NULL)
                ->select('a.*', 'p.numeroprocesso', 'm.id as idMovimentacao', 'm.unidade_id', 'm.cela_id', 'c.nomecela', 'u.nomeunidade')
                ->first();

            $v['fotos'] = DB::table('fotos as f')
                ->Where('f.apenado_id', $id)
                ->orderby('id', 'desc')
                ->get();
            return view('apenados.fotos', $v);
        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }


    public function fotosSalvar(Request $request, $id)
    {
        try {
            $validator = validator($request->all(),
                ['arquivo_foto' => 'required']);
            if ($validator->fails()) {
                return redirect()->route('apenados.fotos', $id)->withInput()->withErrors($validator);
            }
            \DB::beginTransaction();


            // return $request->file('foto');
            $foto = new Fotos();
            $foto->atual_foto = NULL;
            $foto->descricao_foto = $request->input('descricao_foto');
            $foto->apenado_id = $id;
            $foto->user_id = Auth::user()->id;

            if ($request->file('arquivo_foto')) {
                $foto1 = $request->file('arquivo_foto');
                $extensao = $foto1->getClientOriginalExtension();
                if ($extensao != 'jpg' && $extensao != 'JPG' && $extensao != 'jpeg' && $extensao != 'JPEG' && $extensao != 'png' && $extensao != 'PNG') {
                    Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Este arquivo não é uma foto.");
                    return redirect()->route('apenados.fotos', $id);
                    return redirect()->back();
                }

                $nomefoto = sha1(microtime()) . '.' . $extensao;
                File::copy($foto1, public_path() . '/fotosPresos/' . $nomefoto);
                $foto->arquivo_foto = 'fotosPresos/' . $nomefoto;
            } else {
                $foto->arquivo_foto = 'fotosPresos/semfoto.png';
            }
            $foto->push();
            //FIM - INSERE A FOTO

            \DB::commit();
            Flash::success("Foto Salva com sucesso!");
            return redirect()->route('apenados.fotos', $id);
            return redirect()->back();
//
        } catch (\Exception $e) {
            \DB::rollBack();
            return $e->getMessage();
            return redirect()->back();
        }

    }



    public function fotoPrincipal($id, $idApen)
    {
        try {

            //define null para todos os itens
            Fotos::where('apenado_id', $idApen)->update(array('atual_foto' => NULL));
            //FAZ O UPDATE PARA O ATUAL
            Fotos::where('id', $id)->update(array('atual_foto' => 'S'));

            Flash::success("Alterado Com Sucesso!");
            return redirect()->back();

        } catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Foto Principal', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }



    public function fotoExcluir($id)
    {
        try {
            Fotos::destroy($id);
            Flash::success("Foto Excluida com Sucesso.");
            return redirect()->back();
        } catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Foto excluida com Sucessso', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }





    public function mudarCeladestroy($id, $idApen)
    {
        try {
            //DB::delete('delete from log_mudancadecelas where id = ' . $id . '');
            LogCelas::destroy($id);
            Flash::success("Histórico de Cela Excluida com Sucesso.");
            return redirect()->route('apenados.mudarcela', $idApen);
        } catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Celas historicos', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }





    public function alcunhaDestroy($id, $idApen)
    {
        try {
            Alcunha::destroy($id);
            Flash::success("Alcunha excluida com Sucesso.");
            return redirect()->route('apenados.alcunhas', $idApen);
        } catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Alcunhas destroy', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }



    public function incluirProcessos($id)
    {
        try {
            $v['titulo'] = " APENADOS";
            $v['subtitulo'] = " Processos / Execuções";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id', '=', '' . $id . '')
                ->Where('m.datasaida', '=', NULL)
                ->select('a.*', 'p.numeroprocesso', 'm.id as idMovimentacao', 'm.unidade_id', 'm.cela_id', 'c.nomecela', 'u.nomeunidade')
                ->first();

            $v['processos'] = DB::table('processos as p')
                ->Where('p.apenado_id', '=', '' . $id . '')
                ->get();

            return view('apenados.incluirProcessos', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }

    public function incluirProcessosSalvar(Request $request, $id)
    {
        try {
            $validator = validator($request->all(),
                ['numeroprocesso' => 'required']);
            if ($validator->fails()) {
                return redirect()->route('apenados.incluirProcessos', $id)->withInput()->withErrors($validator);
            }


            $validapossui = $this->processoModel->where('apenado_id', $id)->where('numeroprocesso', trim($request->input('numeroprocesso')))->first();
            if ($validapossui) {
                Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Este Processo já está cadastrado!");
                return redirect()->route('apenados.incluirProcessos', $id);
                return redirect()->back();

            } else {

                $input = $request->all();
                $salvar = $this->processoModel->fill($input);
                $salvar->save();
                if ($salvar) {
                    Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Processo cadastrado com sucesso!");
                    return redirect()->route('apenados.incluirProcessos', $id);
                    return redirect()->back();
                }

            }

        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }

    }

    public function informacoes($id)
    {

        try {
            $v['titulo'] = " APENADOS";
            $v['subtitulo'] = " Informações Adicionais";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id', '=', '' . $id . '')
                ->Where('m.datasaida', '=', NULL)
                ->select('a.*', 'p.numeroprocesso', 'm.id as idMovimentacao', 'm.unidade_id', 'm.cela_id', 'c.nomecela', 'u.nomeunidade')
                ->first();

            $v['informacoes'] = DB::table('informacoes as i')
                ->join('apenados as a', 'a.id', '=', 'i.apenado_id')
                ->join('users as u', 'u.id', '=', 'i.user_id')
                ->Where('i.apenado_id', '=', '' . $id . '')
                ->Where('i.tipo', '=', 'CADASTRO')
                ->select('i.id as idInf', 'i.descricaoinfo', 'i.datacadastro', 'u.nome', 'i.unidade_id')
                ->orderby('i.id', 'desc')
                ->get();

            return view('apenados.informacoes', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }


    public function informacoes_inserir(Request $request)
    {

        try {
            $idA = $request->input('idapenid');
            $validator = validator($request->all(),
                [
                    'descricaoinfo' => 'required', 'idapenid' => 'required'
                ]);
            if ($validator->fails()) {
                Flash::warning("Ops!! É Informe algo para salvar");
                return redirect()->route('apenados.informacoes', $idA);
            }

            $input = $request->all();
            $infor = $this->informacoesModel->fill($input);
            $infor->tipo = 'CADASTRO';
            $infor->descricaoinfo = $request->input('descricaoinfo');
            $infor->datacadastro = date("Y-m-d");
            $infor->user_id = Auth::user()->id;
            $infor->apenado_id = $idA;
            $infor->unidade_id = Auth::user()->unidade_id;

            if ($infor->save()) {
                Flash::success("Informação Adicional cadastrada com sucesso!");
                Logger::Success('Informação Adicional APENADO', 'Informação Adicional APENADO- ' . $idA . ' ');
                return redirect()->route('apenados.informacoes', $idA);
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$infor->GetExeption($e);
            Logger::error('Informação Adicional APENADO', 'Erro na inclusão da Informação Adicional - ' . $e . ' ');
            return redirect()->back();
        }

    }


    public function destroyInformacaoCadastro($idApen, $idInfo)
    {
        try {
            $v['idApen'] = $idApen;
            $del = Informacao::destroy($idInfo);
            Flash::success("Informação Excluida com Sucesso.");
            Logger::success('Exclusão de Informação do CADASTRO', 'Apenado' . $idApen . ' Servidor: ' . Auth::user()->id);
            return redirect()->route('apenados.informacoes', $v);
        } catch (\Exception $e) {
            $e->getMessage();
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }


    public function recebimento($id)
    {
        try {
            $v['titulo'] = " APENADOS";
            $v['subtitulo'] = " ENTRADA / RECEBIMENTO NA UNIDADE";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->Where('a.id', '=', '' . $id . '')
                ->Where('m.datasaida', '=', NULL)
                ->select('a.id as idApen', 'a.*', 'p.id as idProcesso', 'p.*', 'm.id as idMovimentacao', 'm.*')
                ->first();

            if ($v['apenado']->unidade_id == 63) {
                $v['carceragens'] = $this->carceragemModel->where('unidade_id', Auth::user()->unidade_id)->orderBy('nomecarceragem', 'asc')->get();
            } else {
                $v['carceragens'] = $this->carceragemModel->where('unidade_id', $v['apenado']->unidade_id)->orderBy('nomecarceragem', 'asc')->get();
            }

            return view('apenados.recebimento', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }

    public function recebimentoSalvar(Request $request, $id)
    {
        try {
            $idApen = $request->input('idApen');
            $validator = validator($request->all(),
                ['regime' => 'required', 'monitorado' => 'required', 'presooriundo' => 'required',
                    'situacao' => 'required', 'dataentrada' => 'required', 'oficioentrada' => 'required', 'cela_id' => 'required'
                ]);
            if ($validator->fails()) {
                return redirect()->route('apenados.recebimento', $idApen)->withInput()->withErrors($validator);
            }

            \DB::beginTransaction();
            $movimentacao = $this->movimentacaoModel->find($id);
            $movimentacao->regime = $request->input('regime');
            $movimentacao->dataentrada = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataentrada'))));
            $movimentacao->oficioentrada = $request->input('oficioentrada');
            $movimentacao->oficioentrada = $request->input('oficioentrada');
            $movimentacao->presooriundo = $request->input('presooriundo');
         //   $movimentacao->unidade_id = Auth::user()->unidade_id;
            $movimentacao->situacao = $request->input('situacao');
            $movimentacao->monitorado = $request->input('monitorado');
            $movimentacao->cela_id = $request->input('cela_id');

            if ($request->input('transito') == 'Sim') {
                $movimentacao->transito = 'Sim';
            }

            $movimentacao->push();

            \DB::commit();

            Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Recebimento realizado com Sucesso");
            //LogCelas::Success( $id, $movimentacao->unidade_id, $movimentacao->processo_id, $request->input('idMovimentacao'), $request->input('motivomudanca'), $celaDE, $request->input('cela_id'));
            return redirect()->route('apenados.index');
            return redirect()->back();

        } catch (\Exception $e) {
            \DB::rollBack();
            return $e->getMessage();
            $this->$apen->GetExeption($e);
            return redirect()->back();
        }

    }


    public function registrarSaida($id)
    {
        try {

            $v['titulo'] = " APENADOS";
            $v['subtitulo'] = "SAÍDA / TRANSFERÊNCIA";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id', '=', '' . $id . '')
                ->Where('m.datasaida', '=', NULL)
                ->select('a.*', 'p.id as idProcesso ', 'p.numeroprocesso', 'm.id as idMovimentacao', 'm.unidade_id', 'm.cela_id', 'c.nomecela', 'u.nomeunidade')
                ->first();

            // $v['unidades'] = $this->unidadeModel->all();
            $v['unidades'] = $this->unidadeModel->where('recebeapenados', 'Sim')->orderBy('nomeunidade')->get();
            $v['unidadesRecambiamentos'] = $this->unidadeModel->where('tipoestabelecimento', 'Recambiamento')->orderBy('nomeunidade')->get();
            return view('apenados.registrarSaida', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }

    public function registrarSaidaSalvar(Request $request, $id)
    {
        try {
            $v['titulo'] = " APENADOS";
            $v['subtitulo'] = "SAÍDA / TRANSFERÊNCIA";

            /* ****************************************************************************************** */

            //INFORMAÇÕES DE SAÍDA
            $observacao = $request->input('observacao');
            $idApen = $request->input('idApen');
            $idProc = $request->input('idProc');
            $idMov = $request->input('idMov');
            $motivosaida = $request->input('motivosaida');
            $documentosaida = $request->input('documentosaida');
            $unidade_id = $request->input('unidade_id');
            $unidadeRecamb_id = $request->input('unidadeRecamb_id');
            $datasaida = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datasaida'))));

            /* ****************************************************************************************** */

            $validator = validator($request->all(),
                ['motivosaida' => 'required',
                    'documentosaida' => 'required',
                    'datasaida' => 'required'
                ]);
            if ($validator->fails()) {
                Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Opss! todos os campos são obrigatórios!");
                return redirect()->route('apenados.registrarSaida', $idApen)->withInput();
            }


            //   '1' => 'Transferência de Unidade *',
            //   '2' => 'Progressão de Regime *',
            //   '3' => 'Clínica de Recuperação *',

            if (($request->input('motivosaida') == 1)
                or ($request->input('motivosaida') == 2)
                or ($request->input('motivosaida') == 3)
            ) {
                $validator = validator($request->all(),
                    ['unidade_id' => 'required']);
                if ($validator->fails()) {
                    Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Opss! Informe a Unidade de Destino!");
                    return redirect()->route('apenados.registrarSaida', $idApen)->withInput();
                }
            }


            //ROTINA PARA TRANSFERENCIA DE UNIDADE - BLOCO 1
            if (($request->input('motivosaida') == 1)
                or ($request->input('motivosaida') == 2)
                or ($request->input('motivosaida') == 3)
            ) {
                //REGISTRAR SAÍDA UNIDADE ORIGEM
                $saida = $this->movimentacaoModel->find($id);
                $saida->datasaida = $datasaida;
                $saida->oficiosaida = $documentosaida;
                $saida->motivosaida = $motivosaida;
                $saida->observacao = $observacao;
                $saida->unidadedestino = $unidade_id;
                $saida->save();

                if ($saida) {
                    //REGISTRA A ENTRADA NA UNIDADE DE DESTINO
                    $movimentacaoEntrada = new Movimentacao();
                    $movimentacaoEntrada->dataentrada = $datasaida;
                    $movimentacaoEntrada->oficioentrada = $documentosaida;
                    $movimentacaoEntrada->processo_id = $idProc;
                    $movimentacaoEntrada->unidadeorigem = $saida->unidade_id;
                    $movimentacaoEntrada->observacao = $observacao;
                    $movimentacaoEntrada->unidade_id = $unidade_id;
                    $movimentacaoEntrada->cela_id = NULL;
                    $movimentacaoEntrada->save();

                    if ($movimentacaoEntrada) {
                        Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Saída registrada com sucesso!");
                        Logger::Success('Registrar Saída', 'Saída do Cadastro - ' . $request->input('nomeapenadoc') . ' ');
                        return redirect()->route('apenados.index');
                        return redirect()->back();
                    }
                }
            }


            //PRESO EM TRÂNSITO
            if (($request->input('motivosaida') == 15)) {
                //REGISTRAR SAÍDA UNIDADE ORIGEM

                \DB::beginTransaction();
                $saida = $this->movimentacaoModel->find($id);
                $saida->datasaida = $datasaida;
                $saida->oficiosaida = $documentosaida;
                $saida->motivosaida = $motivosaida;
                $saida->observacao = $observacao;
                $saida->unidadedestino = 63;  // CÓDIGO UNIDADE TRANSITO: 63
                $saida->push();

                //REGISTRA A ENTRADA NA UNIDADE DE DESTINO
                $movimentacaoEntrada = new Movimentacao();
                $movimentacaoEntrada->dataentrada = $datasaida;
                $movimentacaoEntrada->oficioentrada = $documentosaida;
                $movimentacaoEntrada->processo_id = $idProc;
                $movimentacaoEntrada->unidadeorigem = $saida->unidade_id;
                $movimentacaoEntrada->observacao = $observacao;
                $movimentacaoEntrada->unidade_id = 63; // UNIDADE DE TRANSITO : 63
                $movimentacaoEntrada->cela_id = NULL;
                $movimentacaoEntrada->push();

                \DB::commit();

                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Saída em Trânsito Registrada com Sucesso!");
                Logger::Success('Registrar Saída Transito', 'Saída do Cadastro - ' . $request->input('nomeapenadoc') . ' ');
                return redirect()->route('apenados.index');
                return redirect()->back();
            }


            //PRESO EM RECAMBIAMENTO - OUTROS ESTADOS
            if (($request->input('motivosaida') == 16)) {

                \DB::beginTransaction();
                $saida = $this->movimentacaoModel->find($id);
                $saida->datasaida = $datasaida;
                $saida->oficiosaida = $documentosaida;
                $saida->motivosaida = $motivosaida;
                $saida->unidadedestino = $unidadeRecamb_id;
                $saida->unidadeorigem = $saida->unidade_id;
//                $saida->unidade_id = $unidadeRecamb_id;
                $saida->push();

                \DB::commit();

                Flash::success("Recambiamento Registrado com Sucesso!");
                Logger::Success('Registrar Saída Recambiamento', 'Saída do Cadastro Recambiamento- ' . $request->input('nomeapenadoc') . ' ');
                return redirect()->route('apenados.index');
                return redirect()->back();
            }
            /* ****************************************************************************************** */

            //    '4' => 'Alvará de Soltura / Hábeas Corpus',
            //    '5' => 'Indulto',
            //    '6' => 'Libramento Condicional',
            //    '7' => 'Óbito Criminais',
            //    '8' => 'Óbito Sucídio',
            //    '9' => 'Óbito Acidental',

            //ROTINA PARA TRANSFERENCIA DE UNIDADE BLOCO 2
            if (($request->input('motivosaida') == 4)
                or ($request->input('motivosaida') == 5)
                or ($request->input('motivosaida') == 6)
                or ($request->input('motivosaida') == 7)
                or ($request->input('motivosaida') == 8)
                or ($request->input('motivosaida') == 9)
            ) {

                //REGISTRAR SAÍDA UNIDADE ORIGEM
                $saida = $this->movimentacaoModel->find($id);
                $saida->datasaida = $datasaida;
                $saida->oficiosaida = $documentosaida;
                $saida->motivosaida = $motivosaida;
                $saida->save();

                if ($saida) {
                    Flash::success("Saída Registrada com sucesso!");
                    Logger::Success('Registrar Saída', 'Saída do Cadastro - ' . $request->input('nomeapenadoc') . ' ');
                    return redirect()->route('apenados.index');
                    return redirect()->back();
                }
            }


            /* ****************************************************************************************** */


            // '10' => 'Abandono / Evasão',
            // '11' => 'Fuga',
            // '12' => 'Quebra de Regime / Tornozeleira',

            //ROTINA PARA TRANSFERENCIA DE UNIDADE - BLOCO 3

            //REGISTRAR SAÍDA Registra o Motivo em na tabela Movimentação
            $saida = $this->movimentacaoModel->find($id);
            $saida->motivosaida = 'Sinistro';
            $saida->save();

            if ($saida) {
                //REGISTRA A ENTRADA NA UNIDADE DE DESTINO
                $fuga = new Fuga();
                $fuga->tipo = $motivosaida;
                $fuga->descricaofuga = $documentosaida;
                $fuga->datafuga = $datasaida;
                $fuga->user_id = Auth::user()->id;
                $fuga->apenado_id = $idApen;
                $fuga->processo_id = $idProc;
                $fuga->movimentacao_id = $idMov;
                $fuga->save();

                if ($fuga) {
                    Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Registrado com Sucesso!");
                    Logger::Success('Registrar Saída', 'Saída do Cadastro - ' . $request->input('nomeapenadoc') . ' ');
                    return redirect()->route('apenados.index');
                    return redirect()->back();
                }
            }


            /* ****************************************************************************************** */


        } catch (\Exception $e) {
            \DB::rollBack();
            return $e->getMessage();
            $this->$saida->GetExeption($e);
            return redirect()->back();
        }

    }


    public function triagem($id)
    {
        try {

            $v['titulo'] = "APENADOS";
            $v['subtitulo'] = "Lançamento de Triagem";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id', '=', '' . $id . '')
                ->Where('m.datasaida', '=', NULL)
                ->select('a.*', 'p.id as idProcesso ', 'p.numeroprocesso',
                    'm.id as idMovimentacao', 'm.unidade_id', 'm.cela_id', 'm.triagem_baixa', 'm.triagem_inicio',
                    'm.triagem_fim', 'm.dataentrada',
                    'c.nomecela', 'u.nomeunidade')
                ->first();

            // $v['unidades'] = $this->unidadeModel->all();

            return view('apenados.triagem', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }

    public function triagemSalvar(Request $request, $id)
    {
        try {
            $validator = validator($request->all(),
                ['triagem_inicio' => 'required', 'triagem_fim' => 'required']);
            if ($validator->fails()) {
                return redirect()->route('apenados.triagem', $id)->withInput()->withErrors($validator);
            }

            $movimentacao = $this->movimentacaoModel->find($request->input('idMov'));
            //$movimentacao->triagem_baixa = null;
            $movimentacao->triagem_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('triagem_inicio'))));
            $movimentacao->triagem_fim = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('triagem_fim'))));
            $movimentacao->save();

            if ($movimentacao) {
                Flash::success("Apenado Incluido na Triagem!");
                return redirect()->route('apenados.index');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e;
            $this->$apen->GetExeption($e);
            return redirect()->back();
        }

    }


    public function triagemBaixar(Request $request)
    {
        $idMov = $request->input('id');

        $validator = validator($request->all(),
            [
                'databaixa_triagem' => 'required'
            ]);
        if ($validator->fails()) {
            Flash::warning("Ops!! Todos os campos são obrigatórios");
            return redirect()->route('listagem.triagem');
        }

        $mov = $this->movimentacaoModel->find($idMov);
        $mov->triagem_baixa = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('databaixa_triagem'))));

        if ($mov->save()) {
            Flash::success("Operação Realizada com Sucesso.");
            return redirect()->back();
        } else {
            Flash::error("Erro ao tentar atualizar conteudo..");
            return redirect()->route('listagem.triagem');
        }


    }


    public function localizacao(Request $request)
    {
        try {

            $v['titulo'] = " LOCALIZAÇÃO DE APENADOS ";
            $v['subtitulo'] = " Informe o nome";

            if ($request->has('parametro')) {
                $v['apenados'] = DB::table('apenados as a')
                    ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                    ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                    ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                    // ->Where('m.datasaida','=', NULL )
                    ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
                    ->orWhere('a.cpf', 'LIKE', '%' . $request->input('parametro') . '%')
                    ->orWhere('a.nomepai', 'LIKE', '%' . $request->input('parametro') . '%')
                    ->orWhere('a.nomemae', 'LIKE', '%' . $request->input('parametro') . '%')
//                        ->orWhere('a.alcunha', 'LIKE', '%' . $request->input('parametro') . '%')
                    ->select('a.*')
                    ->orderby('a.nomeapenado', 'asc')
                    ->groupby('a.id')
                    ->get();
            } else {
                $v['apenados'] = '';
            }

            $v['parametro'] = $request->input('parametro');
            return view('apenados.localizacao', $v);

        } catch (\Exception $e) {
            return $e;
            //$this->auxiliar->GetExeption($e);
            return redirect()->back();
        }
    }


    public function destroyApenado($id)
    {
        try {
            $v['titulo'] = "EXCLUSÃO DE APENADO";
            $v['subtitulo'] = "Visualização geral de cadastros";

            $v['apenado'] = $this->apenModel->find($id);
            $v['processos'] = $this->processoModel->where('apenado_id', $id)->get();
            $v['movimentacoes'] = DB::table('processos as p')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->Where('p.apenado_id', $id)
                ->get();

            $v['informacoes'] = $this->informacoesModel->where('apenado_id', $id)->get();
            $v['anexos'] = Anexo::where('apenado_id', $id)->get();

            $v['visitas'] = VisitasApenados::where('apenado_id', $id)->get();
            $v['advogados'] = AdvogadosApenados::where('apenado_id', $id)->get();
            $v['fugas'] = $this->fugaModel->where('apenado_id', $id)->get();
            $v['pads'] = Pad::where('apenado_id', $id)->get();
            $v['integrantes'] = Integrantes::where('apenado_id', $id)->get();
            $v['medidadisciplinar'] = MedidaDisciplinar::where('apenado_id', $id)->get();


            return view('apenados.destroyApenado', $v);
        } catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Visualiza Módulos que o apenado possui', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }


    public function destroy($id, $idAcao)
    {
        try {
            if ($idAcao == 'Todos') {

                Integrantes::where('apenado_id', $id)->delete();
                Pad::where('apenado_id', $id)->delete();
                Fuga::where('apenado_id', $id)->delete();
                Informacao::where('apenado_id', $id)->delete();
                AdvogadosApenados::where('apenado_id', $id)->delete();
                VisitasApenados::where('apenado_id', $id)->delete();
                MedidaDisciplinar::where('apenado_id', $id)->delete();

                // mOVIMENTAÇÕES
                // PROCESSOS
                // APENADOS

                $processos = Processo::where('apenado_id', $id)->get();

                if (!empty($processos)) {
                    foreach ($processos as $processo) {
                        Movimentacao::where('processo_id', $processo->id)->delete();
                    }
                }

                Processo::where('apenado_id', $id)->delete();
                Apenado::find($id)->delete();

                Flash::success("Apenado Excluido com Sucesso.");
                Logger::success('Exclusão de Apenado', 'Apenado : ' . $id . '');
                return redirect()->route('apenados.index');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            Logger::exception('Exclusão de Apenado', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }


}

