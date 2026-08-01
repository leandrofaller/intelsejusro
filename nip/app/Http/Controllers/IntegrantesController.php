<?php

namespace App\Http\Controllers;

use App\Model\Alcunha;
use App\Model\Anexo;
use App\Model\Apenado;
use App\Model\Cargos;
use App\Model\CargosFaccao;
use App\Model\Cela;
use App\Model\Endereco;
use App\Model\Faccao;
use App\Model\FaccaoClassificacao;
use App\Model\FaccaoPossiveis;
use App\Model\Fotos;
use App\Model\Informacao;
use App\Model\Integrantes;
use App\Model\Localbatismo;
use App\Model\LogAuditoria;
use App\Model\LogFaccao;
use App\Model\Matricula;
use App\Model\Movimentacao;
use App\Model\Nomebatismo;
use App\Model\PadrinhosExterno;
use App\Model\PadrinhosInterno;
use App\Model\Processo;
use App\Model\QuebradaAtual;
use App\Model\QuebradaOrigem;
use App\Model\Referencia;
use App\Model\Telefone;
use App\Model\Temporaria;
use App\Model\Unidade;
use Illuminate\Http\Request;
use DB, Flash, Redirect;
use App\Model\LogClassificacoes;
use Illuminate\Support\Facades\Auth;
use App\Model\Logger;
use File;
use League\Flysystem\Adapter\Local;


class IntegrantesController extends Controller
{


    public function __construct(FaccaoPossiveis $faccaoPossiveis, FaccaoClassificacao $faccaoClassificacao,  Cela $celaModel,
                                Unidade $unidadeModel, Informacao $informacoesModel, Anexo $anexoModel,
                                Integrantes $integranteModel, Processo $processoModel, Movimentacao $movimentacaoModel,
                                Apenado $apenModel, Faccao $faccaoModel, CargosFaccao $cargosFaccaoModel,
                                Matricula $matricula)
    {
        $this->anexoModel = $anexoModel;
        $this->integranteModel = $integranteModel;
        $this->apenModel = $apenModel;
        $this->processoModel = $processoModel;
        $this->movimentacaoModel = $movimentacaoModel;
        $this->faccaoModel = $faccaoModel;
        $this->cargoFaccaoModel = $cargosFaccaoModel;
        $this->informacoesModel = $informacoesModel;
        $this->unidadeModel = $unidadeModel;
        $this->celaModel = $celaModel;
        $this->matricula = $matricula;

        $this->faccaoPossivelModel = $faccaoPossiveis;
        $this->faccaoClassificacaoModel = $faccaoClassificacao;
    }

    public function index(Request $request)
    {
        try {

            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INTEGRANTES";
            $v['subtitulo'] = " Relação de Apenados";

            $perfil = Auth::user()->perfil;
            if($perfil == 'Admin')
            {
                //PERFIL = 'ADMIN' = MOSTRAR TODOS APENADOS DA UNIDADE DO USUÁRIO
                if ($request->has('parametro')) {
                    $v['apenados'] = DB::table('apenados as a')
                        ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.cpf', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.nomepai', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.nomemae', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orderby('a.nomeapenado', 'asc')
                        ->get();
                }
                else {
                    $v['apenados'] = [];
//                    $v['apenados'] = DB::table('apenados as a')
//                        ->orderby('a.nomeapenado', 'asc')
//                        ->get();
                }
            }
            else
            {
                //BLOCO DE VALIDAÇÃO PARA MOSTRAR SOMENTE OS APENADOS DA UNIDADE DO USUÁRIO
                $idUnidadeUser = Auth::user()->unidade_id;
                if ($request->has('parametro')) {
                    $v['apenados'] = DB::table('apenados as a')
                        ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.cpf', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.nomepai', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.nomemae', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orderby('a.nomeapenado', 'asc')
                        ->get();

                }
                else {
                    $v['apenados'] = '';
                }
            }

            $v['parametro'] = $request->input('parametro');
            return view('faccaointegrantes.index', $v);

        } catch (\Exception $e) {
            return $e;
            //$this->auxiliar->GetExeption($e);
            return redirect()->back();
        }
    }


    public function fichaPrisional(Request $request){

        try{
            $id = $request->input('apenado_id');

            $v['title'] = 'Ficha - Resumo do Apenado Faccionado';
            $v['apenado'] = $this->apenModel->find($id);


            $listar = $request->input('listar');
                if(empty($listar))
                {
                    Flash::warning("Oops!! Selecione Alguma das Opções.!");
                    return redirect()->back();
                }
                $v['check']  = $listar;

                $v['processos'] = $this->processoModel->where('apenado_id', $id)
                    ->orderby('principal', 'desc')
                    ->get();

                $processoPrincipal = $this->processoModel->where('apenado_id', $id)->where('principal', 'S')
                    ->select('id')
                    ->first();

                $v['movimentacoes'] = $this->movimentacaoModel->where('processo_id', $processoPrincipal->id)
                    ->orderby('id', 'desc')
                    ->limit(1)
                    ->first();

                $v['unidade'] = $this->unidadeModel->find($v['movimentacoes']->unidade_id);
                $v['cela'] = $this->celaModel->find($v['movimentacoes']->cela_id);

                $v['prisoes'] = DB::table('apenados as a')
                    ->join('processos as p', 'a.id','=','p.apenado_id')
                    ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                    ->where('a.id', $id)
                    ->select('a.id as idApen', 'a.*', 'p.id as idProcesso', 'p.*'  ,'m.id as idMovimentacao', 'm.*')
                    ->orderby('m.id', 'DESC' )
                    ->get();

                $v['informacoes'] = Informacao::where('apenado_id', $id)->orderby('created_at', 'DESC')->get();

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

            $v['fotoprincipal'] = Fotos::where('apenado_id', $id)->where('atual_foto', 'S')->limit(1)->get();
            $v['fotos'] = Fotos::where('apenado_id', $id)->get();

            $v['enderecos'] = Endereco::where('apenado_id', $id)->get();
            $v['alcunhas'] = Alcunha::where('apenado_id', $id)->get();

        //FACCÃO ATUAL
           // $v['faccaoatual'] = Integrantes::where('apenado_id', $id)->where('datasaida', NULL)->first();
            $v['faccaoatual'] = DB::table('integrantes as i')
                ->join('faccoes as f', 'f.id','=','i.faccao_id')
                ->Where('i.apenado_id', $id)
                ->Where('i.datasaida',NULL)
                ->select('i.id as idIntegrante', 'i.databatismo', 'i.faccao_id', 'f.nomefaccao', 'f.sigla')
                ->first();

            $idIntegrante = $v['faccaoatual']->idIntegrante;

            $v['telefones'] = Telefone::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();
            $v['matriculas'] = Matricula::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();
            $v['nomebatismos'] = Nomebatismo::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();
            $v['localbatismos'] = Localbatismo::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();
            $v['quebradaorigens'] = QuebradaOrigem::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();
            $v['quebradaatuais'] = QuebradaAtual::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();

            $v['cargos'] = DB::table('cargos as c')
                ->join('cargos_faccoes as cf', 'cf.id','=','c.cargo_faccao_id')
                ->Where('c.integrante_id', $idIntegrante)
                ->select('c.descricao_cargo', 'c.atual_cargo', 'c.created_at', 'cf.nomecargo')
                ->get();

            $v['referencias'] = Referencia::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();

            $v['padrinhosexternos'] = PadrinhosExterno::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();

            $v['padrinhosinternos'] = DB::table('padrinhosinterno as p')
                ->join('apenados as a', 'a.id','=','p.padrinho_id')
                ->Where('p.integrante_id',$idIntegrante)
                ->select('p.id', 'p.padrinho_id', 'p.descricao_padrinhointerno', 'a.nomeapenado', 'p.created_at')
                ->get();

            $v['locClassificacoes'] = DB::table('log_classificacoes as l')
                ->join('faccao_possiveis as p', 'p.id','=','l.faccao_possiveis_id')
                ->join('faccao_classificacao as c', 'c.id','=','l.faccao_classificacao_id')
                ->Where('l.integrante_id',$idIntegrante)
                ->select('p.tipo_poss', 'c.tipo_class', 'l.created_at')
                ->orderby('l.created_at', 'DESC')
                ->get();




            $v['anexos'] = DB::table('anexos as an')
                ->join('apenados as a', 'an.apenado_id', '=', 'a.id')
                ->Where('an.apenado_id',$id )
                ->Where('an.tipodocumento','FACCAO')
                ->select('an.*')
                ->orderby('an.id', 'desc')
                ->get();

            LogAuditoria::Info(Auth::user()->id, $id, 'FACCIONADO' );
            return view('ficha.fichaPrisional', $v);

        } catch (\Exception $e) {
            return $e;
            $this->$v->GetExeption($e);
            return redirect()->back();
        }
    }


    public function incluir($id)
    {

        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INTEGRANTES";
            $v['subtitulo'] = " Novo Cadastro";


           $v['faccoes'] = $this->faccaoModel->all();

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id','=', '' . $id . '')
                ->Where('m.datasaida','=', NULL )
                ->select('a.*', 'm.id as idMovimentacao', 'm.unidade_id','m.cela_id', 'c.nomecela', 'u.nomeunidade')
                ->first();

            $v['possiveis'] = $this->faccaoPossivelModel->where('status_poss', 'A')->pluck('tipo_poss', 'id');
            $v['classificacoes'] = $this->faccaoClassificacaoModel->where('status_class', 'A')->pluck('tipo_class', 'id');

            return view('faccaointegrantes.incluir', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }


    public function salvar(Request $request)
    {
        try {

            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INTEGRANTES";
            $v['subtitulo'] = " Novo Cadastro";

            $validator = validator($request->all(),
                [
                    'faccao_id'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Obrigatório a indicação de uma Facção e um Cargo.");
                return redirect()->route('faccaointegrantes.incluir', $request->input('apenado_id') );
            }


            \DB::beginTransaction();

            $input = $request->all();
            $integrante = $this->integranteModel->fill($input);
            if ($request->input('databatismo'))
                {
                    $integrante->databatismo = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('databatismo'))));
                }else{
                    $integrante->databatismo = NULL;
                }
            $integrante->faccao_possiveis_id = 2; //suspeita
            $integrante->faccao_classificacao_id = 1; //sob Analise

            $integrante->push();


            if ($request->input('matricula')) {
                $matricula = new Matricula();
                $matricula->nome_matricula = $request->input('matricula');
                $matricula->atual_matricula = 'S';
                $matricula->integrante_id = $integrante->id;
                $matricula->apenado_id = $request->input('apenado_id');
                $matricula->user_id = Auth::user()->id;
                $matricula->push();
            }

            if ($request->input('localbatismo')) {
                $localbatismo = new Localbatismo();
                $localbatismo->nome_localbatismo = $request->input('localbatismo');
                $localbatismo->atual_localbatismo = 'S';
                $localbatismo->integrante_id = $integrante->id;
                $localbatismo->apenado_id = $request->input('apenado_id');
                $localbatismo->user_id = Auth::user()->id;
                $localbatismo->push();
            }

            if ($request->input('nomedebatismo')) {
                $nomebatismo = new Nomebatismo();
                $nomebatismo->nome_batismo = $request->input('nomedebatismo');
                $nomebatismo->atual_batismo = 'S';
                $nomebatismo->integrante_id = $integrante->id;
                $nomebatismo->apenado_id = $request->input('apenado_id');
                $nomebatismo->user_id = Auth::user()->id;
                $nomebatismo->push();
            }

            if ($request->input('quebradaorigem')) {
                $quebradaorigem = new QuebradaOrigem();
                $quebradaorigem->nome_origem = $request->input('quebradaorigem');
                $quebradaorigem->atual_origem = 'S';
                $quebradaorigem->integrante_id = $integrante->id;
                $quebradaorigem->apenado_id = $request->input('apenado_id');
                $quebradaorigem->user_id = Auth::user()->id;
                $quebradaorigem->push();
            }

                \DB::commit();


            //GRAVA A CLASSIFICAÇÃO NO LOGGER
            LogClassificacoes::Info(Auth::user()->id, $integrante->id, 2, 1 );

            Flash::success("Cadastro realizado com sucesso!");
                  Logger::Success('Novo Integrante', 'Inserido Novo Integrante - ' . $request->input('nomeapenado') . ' ');
                  return redirect()->route('faccaointegrantes.incluirDados', $integrante->apenado_id);
                  return redirect()->back();

        } catch (\Exception $e) {
            \DB::rollBack();
            $e->getMessage();
            Flash::warning("Oops! Houve um Erro no faccaocadastro da Prisao.");
            Logger::error('Novo Integrante', 'Erro no Integrante -> Novo');
            return redirect()->route('faccaointegrantes.index');
            return redirect()->back();
        }
    }




    public function incluirDados($id)
    {

        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
            $v['subtitulo'] = "Continuação do Cadastro";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->join('integrantes as i', 'i.apenado_id', '=', 'a.id')
                ->Where('a.id',$id)
                ->Where('i.datasaida',NULL)
               // ->Where('m.datasaida','=', NULL )
                ->select('a.*', 'm.id as idMovimentacao', 'm.unidade_id','m.cela_id', 'c.nomecela', 'u.nomeunidade',
                    'i.id as idIntegrante', 'i.faccao_id', 'i.databatismo', 'i.faccao_possiveis_id', 'i.faccao_classificacao_id')
                ->first();

            $idIntegrante = $v['apenado']->idIntegrante;

            $v['faccoes'] = $this->faccaoModel->pluck('nomefaccao', 'id');

            $v['cargosfaccao'] = $this->cargoFaccaoModel->where('faccao_id', $v['apenado']->faccao_id)->pluck('nomecargo', 'id');


            $v['possiveis'] = $this->faccaoPossivelModel->where('status_poss', 'A')->pluck('tipo_poss', 'id');
           // $v['classificacoes'] = $this->faccaoClassificacaoModel->where('status_class', 'A')->pluck('tipo_class', 'id');

            $v['classificacoes'] = DB::table('faccao_classificacao as c')
                ->join('integrantes as i', 'i.faccao_classificacao_id','=','c.id')
                ->Where('i.id',$idIntegrante)
                ->pluck('c.tipo_class', 'c.id');

            $v['matriculas'] = Matricula::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();
            $v['nomebatismos'] = Nomebatismo::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();
            $v['localbatismos'] = Localbatismo::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();
            $v['quebradaorigens'] = QuebradaOrigem::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();
            $v['quebradaatuais'] = QuebradaAtual::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();
            $v['referencias'] = Referencia::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();
            $v['telefones'] = Telefone::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();

            $v['cargos'] = DB::table('cargos as c')
                ->join('cargos_faccoes as cf', 'cf.id','=','c.cargo_faccao_id')
                ->Where('c.integrante_id',$idIntegrante)
                ->select('c.id', 'c.cargo_faccao_id', 'c.atual_cargo', 'cf.nomecargo', 'c.descricao_cargo', 'c.integrante_id', 'c.created_at')
                ->get();


            $v['listapadrinhosinterno'] = DB::table('apenados as a')
                ->join('integrantes as i', 'a.id', '=', 'i.apenado_id')
                ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
                ->Where('i.faccao_id','=', $v['apenado']->faccao_id)
               // ->select('a.id','a.nomeapenado')
                ->pluck('a.nomeapenado', 'a.id');


            $v['padrinhosinternos'] = DB::table('padrinhosinterno as p')
                ->join('apenados as a', 'a.id','=','p.padrinho_id')
                ->Where('p.integrante_id',$idIntegrante)
                ->select('p.id', 'p.padrinho_id', 'p.descricao_padrinhointerno', 'a.nomeapenado', 'p.created_at')
                ->get();

            $v['padrinhosexternos'] = PadrinhosExterno::where('integrante_id', $idIntegrante)->orderby('id', 'DESC')->get();

            $v['locClassificacoes'] = DB::table('log_classificacoes as l')
                ->join('faccao_possiveis as p', 'p.id','=','l.faccao_possiveis_id')
                ->join('faccao_classificacao as c', 'c.id','=','l.faccao_classificacao_id')
                ->Where('l.integrante_id',$idIntegrante)
                ->select('p.tipo_poss', 'c.tipo_class', 'l.created_at')
                ->orderby('l.created_at', 'DESC')
                ->get();

            return view('faccaointegrantes.incluirDados', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }

    public function updateDadosFaccionado(Request $request)
    {
        $idIntegrante = $request->input('CodigoIntegrante');
        $idApenado = $request->input('CodigoApenado');
        try {

            $validator = validator($request->all(),
                [  'CodigoIntegrante'=>'required' ]);
            if($validator->fails()){
                Flash::warning("Ops! Todos os campos são obrigatórios!");
                return Redirect::route('faccaointegrantes.incluirDados', $idApenado );
            }

            $integrante = $this->integranteModel->find($idIntegrante);
            $integrante->faccao_id = $request->input('novafaccao');
            $integrante->databatismo = $request->input('novadatabatismo') ? date("Y-m-d", strtotime(str_replace('/', '-', $request->input('novadatabatismo')))) : NULL;

            if($integrante->save()){
                Flash::success("Dados de Faccionado Alterado com sucesso!");
                return Redirect::route('faccaointegrantes.incluirDados', $idApenado );
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }



    ////***************** MATRICULAS ********************//
    public function SalvarMatricula(Request $request)
    {
    try {
        $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
        $v['subtitulo'] = "Continuação do Cadastro";

        $validator = validator($request->all(),
            [
                'matricula'=>'required'
            ]);
        if($validator->fails()){
            Flash::warning("Ops!! É Obrigatório a indicação de alguma informação.");
            return redirect()->route('faccaointegrantes.incluirDados', $request->input('apenado_id'))->withInput()->withErrors($validator);
        }

        //NOVO CADASTRO
        if($request->input('idMatricula') == 0)
        {
            \DB::beginTransaction();
                $novo = new Matricula();
                $novo->nome_matricula = $request->input('matricula');
                $novo->descricao_matricula = $request->input('descricao_matricula');
                $novo->integrante_id = $request->input('integrante_id');
                $novo->apenado_id = $request->input('apenado_id');
                $novo->user_id = Auth::user()->id;
                $novo->push();
            \DB::commit();
            Flash::success("Cadastro realizado com sucesso.");
        }else{
            //ALTERAR DADOS
            $novo = Matricula::find($request->input('idMatricula'));
            $novo->nome_matricula = $request->input('matricula');
            $novo->descricao_matricula = $request->input('descricao_matricula');
            $novo->save();
            Flash::success("Alterado com sucesso.");
        }

        return Redirect::route('faccaointegrantes.incluirDados', $request->input('apenado_id'));
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }

    public function SituacaoMatricula($id, $idInt)
    {
        try
        {
            //define null para todos os itens
           Matricula::where('integrante_id', $idInt)->update(array('atual_matricula' => NULL));
            //FAZ O UPDATE PARA O ATUAL
           Matricula::where('id', $id)->update(array('atual_matricula' => 'S'));
           Flash::success("Matricula Alterada!");
            return redirect()->back();
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Matricula UPDATE atual', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }

    public function ExcluirMatricula($id)
    {
        try
        {
            DB::table('matricula')->where('id', $id)->delete();
            Flash::success("Matricula Excluida com Sucesso!");
            return redirect()->back();

        }
        catch (\Exception $e)
        {
            Logger::exception('Erro ao excluir ', $e);
            Flash::error('Ops, houve um erro contate o administrador.');
            return redirect()->back();
        }
    }

    ////***************** NOME BATISMO ********************//
    public function SalvarNomeBatismo(Request $request)
    {
        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
            $v['subtitulo'] = "Continuação do Cadastro";

            $validator = validator($request->all(),
                [
                    'nome_batismo'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Obrigatório a indicação de alguma informação.");
                return redirect()->route('faccaointegrantes.incluirDados', $request->input('apenado_id'))->withInput()->withErrors($validator);
            }

            //NOVO CADASTRO
            if($request->input('idNomeBatismo') == 0)
            {
                \DB::beginTransaction();
                $novo = new Nomebatismo();
                $novo->nome_batismo = $request->input('nome_batismo');
                $novo->descricao_batismo = $request->input('descricao_batismo');
                $novo->integrante_id = $request->input('integrante_id');
                $novo->apenado_id = $request->input('apenado_id');
                $novo->user_id = Auth::user()->id;
                $novo->push();
                \DB::commit();
                Flash::success("Cadastro realizado com sucesso.");
            }else{
                //ALTERAR DADOS
                $update = Nomebatismo::find($request->input('idNomeBatismo'));
                $update->nome_batismo = $request->input('nome_batismo');
                $update->descricao_batismo = $request->input('descricao_batismo');
                $update->save();
                Flash::success("Alterado com sucesso.");
            }

            return Redirect::route('faccaointegrantes.incluirDados', $request->input('apenado_id'));
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }

    public function SituacaoNomeBatismo($id, $idInt)
    {
        try
        {
            //define null para todos os itens
            Nomebatismo::where('integrante_id', $idInt)->update(array('atual_batismo' => NULL));
            //FAZ O UPDATE PARA O ATUAL
            Nomebatismo::where('id', $id)->update(array('atual_batismo' => 'S'));
            Flash::success("Alterado Com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Novo Nome Batismo UPDATE atual', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }

    public function ExcluirNomeBatismo($id)
    {
        try
        {
            DB::table('nomebatismo')->where('id', $id)->delete();
            Flash::success("Excluida com Sucesso!");
            return redirect()->back();

        }
        catch (\Exception $e)
        {
            Logger::exception('Erro ao excluir Nome Batismo ', $e);
            Flash::error('Ops, houve um erro contate o administrador.');
            return redirect()->back();
        }
    }
//***************************

////***************** LOCAL BATISMO ********************//
    public function SalvarLocalBatismo(Request $request)
    {
        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
            $v['subtitulo'] = "Continuação do Cadastro";

            $validator = validator($request->all(),
                [
                    'nome_localbatismo'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Obrigatório a indicação de alguma informação.");
                return redirect()->route('faccaointegrantes.incluirDados', $request->input('apenado_id'))->withInput()->withErrors($validator);
            }

            //NOVO CADASTRO
            if($request->input('idLocalBatismo') == 0)
            {
                \DB::beginTransaction();
                $novo = new Localbatismo();
                $novo->nome_localbatismo = $request->input('nome_localbatismo');
                $novo->descricao_localbatismo = $request->input('descricao_localbatismo');
                $novo->integrante_id = $request->input('integrante_id');
                $novo->apenado_id = $request->input('apenado_id');
                $novo->user_id = Auth::user()->id;
                $novo->push();
                \DB::commit();
                Flash::success("Cadastro realizado com sucesso.");
            }else{
                //ALTERAR DADOS
                $update = Localbatismo::find($request->input('idLocalBatismo'));
                $update->nome_localbatismo = $request->input('nome_localbatismo');
                $update->descricao_localbatismo = $request->input('descricao_localbatismo');
                $update->save();
                Flash::success("Alterado com sucesso.");
            }

            return Redirect::route('faccaointegrantes.incluirDados', $request->input('apenado_id'));
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }

    public function SituacaoLocalBatismo($id, $idInt)
    {
        try
        {
            //define null para todos os itens
            Localbatismo::where('integrante_id', $idInt)->update(array('atual_localbatismo' => NULL));
            //FAZ O UPDATE PARA O ATUAL
            Localbatismo::where('id', $id)->update(array('atual_localbatismo' => 'S'));
            Flash::success("Alterado Com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Novo Local de  Batismo UPDATE atual', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }

    public function ExcluirLocalBatismo($id)
    {
        try
        {
            DB::table('localbatismo')->where('id', $id)->delete();
            Flash::success("Excluida com Sucesso!");
            return redirect()->back();

        }
        catch (\Exception $e)
        {
            Logger::exception('Erro ao excluir Local Batismo ', $e);
            Flash::error('Ops, houve um erro contate o administrador.');
            return redirect()->back();
        }
    }
//***************************



////***************** QUEBRADA ORIGEM ********************//
    public function SalvarQuebradaOrigem(Request $request)
    {
        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
            $v['subtitulo'] = "Continuação do Cadastro";

            $validator = validator($request->all(),
                [
                    'nome_origem'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Obrigatório a indicação de alguma informação.");
                return redirect()->route('faccaointegrantes.incluirDados', $request->input('apenado_id'))->withInput()->withErrors($validator);
            }

            //NOVO CADASTRO
            if($request->input('idQuebradaOrigem') == 0)
            {
                \DB::beginTransaction();
                $novo = new QuebradaOrigem();
                $novo->nome_origem = $request->input('nome_origem');
                $novo->descricao_origem = $request->input('descricao_origem');
                $novo->integrante_id = $request->input('integrante_id');
                $novo->apenado_id = $request->input('apenado_id');
                $novo->user_id = Auth::user()->id;
                $novo->push();
                \DB::commit();
                Flash::success("Cadastro realizado com sucesso.");
            }else{
                //ALTERAR DADOS
                $update = QuebradaOrigem::find($request->input('idQuebradaOrigem'));
                $update->nome_origem = $request->input('nome_origem');
                $update->descricao_origem = $request->input('descricao_origem');
                $update->save();
                Flash::success("Alterado com sucesso.");
            }

            return Redirect::route('faccaointegrantes.incluirDados', $request->input('apenado_id'));
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }

    public function SituacaoQuebradaOrigem($id, $idInt)
    {
        try
        {
            //define null para todos os itens
            QuebradaOrigem::where('integrante_id', $idInt)->update(array('atual_origem' => NULL));
            //FAZ O UPDATE PARA O ATUAL
            QuebradaOrigem::where('id', $id)->update(array('atual_origem' => 'S'));
            Flash::success("Alterado Com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Novo Local de  Batismo UPDATE atual', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }

    public function ExcluirQuebradaOrigem($id)
    {
        try
        {
            DB::table('quebradaorigem')->where('id', $id)->delete();
            Flash::success("Excluida com Sucesso!");
            return redirect()->back();

        }
        catch (\Exception $e)
        {
            Logger::exception('Erro ao excluir Quebrada Origem', $e);
            Flash::error('Ops, houve um erro contate o administrador.');
            return redirect()->back();
        }
    }
//***************************





////***************** QUEBRADA ATUAL ********************//
    public function SalvarQuebradaAtual(Request $request)
    {
        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
            $v['subtitulo'] = "Continuação do Cadastro";

            $validator = validator($request->all(),
                [
                    'nome_atual'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Obrigatório a indicação de alguma informação.");
                return redirect()->route('faccaointegrantes.incluirDados', $request->input('apenado_id'))->withInput()->withErrors($validator);
            }

            //NOVO CADASTRO
            if($request->input('idQuebradaAtual') == 0)
            {
                \DB::beginTransaction();
                $novo = new QuebradaAtual();
                $novo->nome_atual = $request->input('nome_atual');
                $novo->descricao_atual = $request->input('descricao_atual');
                $novo->integrante_id = $request->input('integrante_id');
                $novo->apenado_id = $request->input('apenado_id');
                $novo->user_id = Auth::user()->id;
                $novo->push();
                \DB::commit();
                Flash::success("Cadastro realizado com sucesso.");
            }else{
                //ALTERAR DADOS
                $update = QuebradaAtual::find($request->input('idQuebradaAtual'));
                $update->nome_atual = $request->input('nome_atual');
                $update->descricao_atual = $request->input('descricao_atual');
                $update->save();
                Flash::success("Alterado com sucesso.");
            }

            return Redirect::route('faccaointegrantes.incluirDados', $request->input('apenado_id'));
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }

    public function SituacaoQuebradaAtual($id, $idInt)
    {
        try
        {
            //define null para todos os itens
            QuebradaAtual::where('integrante_id', $idInt)->update(array('atual_atual' => NULL));
            //FAZ O UPDATE PARA O ATUAL
            QuebradaAtual::where('id', $id)->update(array('atual_atual' => 'S'));
            Flash::success("Alterado Com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Novo Quebrada Atual UPDATE atual', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }

    public function ExcluirQuebradaAtual($id)
    {
        try
        {
            DB::table('quebradaatual')->where('id', $id)->delete();
            Flash::success("Excluida com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e)
        {
            Logger::exception('Erro ao excluir Quebrada Atual', $e);
            Flash::error('Ops, houve um erro contate o administrador.');
            return redirect()->back();
        }
    }
//***************************


////***************** QUEBRADA ATUAL ********************//
    public function SalvarReferencia(Request $request)
    {
        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
            $v['subtitulo'] = "Continuação do Cadastro";

            $validator = validator($request->all(),
                [
                    'nome_referencia'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Obrigatório a indicação de alguma informação.");
                return redirect()->route('faccaointegrantes.incluirDados', $request->input('apenado_id'))->withInput()->withErrors($validator);
            }

            //NOVO CADASTRO
            if($request->input('idReferencia') == 0)
            {
                \DB::beginTransaction();
                $novo = new Referencia();
                $novo->nome_referencia = $request->input('nome_referencia');
                $novo->descricao_referencia = $request->input('descricao_referencia');
                $novo->integrante_id = $request->input('integrante_id');
                $novo->apenado_id = $request->input('apenado_id');
                $novo->user_id = Auth::user()->id;
                $novo->push();
                \DB::commit();
                Flash::success("Cadastro realizado com sucesso.");
            }else{
                //ALTERAR DADOS
                $update = Referencia::find($request->input('idReferencia'));
                $update->nome_referencia = $request->input('nome_referencia');
                $update->descricao_referencia = $request->input('descricao_referencia');
                $update->save();
                Flash::success("Alterado com sucesso.");
            }

            return Redirect::route('faccaointegrantes.incluirDados', $request->input('apenado_id'));
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }

    public function SituacaoReferencia($id, $idInt)
    {
        try
        {

            Referencia::where('integrante_id', $idInt)->update(array('atual_referencia' => NULL));
            Referencia::where('id', $id)->update(array('atual_referencia' => 'S'));
            Flash::success("Alterado Com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Novo Quebrada Atual UPDATE atual', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }

    public function ExcluirReferencia($id)
    {
        try
        {
            DB::table('referencias')->where('id', $id)->delete();
            Flash::success("Excluida com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e)
        {
            Logger::exception('Erro ao excluir Quebrada Atual', $e);
            Flash::error('Ops, houve um erro contate o administrador.');
            return redirect()->back();
        }
    }
//***************************







////***************** TELEFONES ********************//
    public function SalvarTelefone(Request $request)
    {
        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
            $v['subtitulo'] = "Continuação do Cadastro";

            $validator = validator($request->all(),
                [
                    'numero_telefone'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Obrigatório a indicação de alguma informação.");
                return redirect()->route('faccaointegrantes.incluirDados', $request->input('apenado_id'))->withInput()->withErrors($validator);
            }

            //NOVO CADASTRO
            if($request->input('idTelefone') == 0)
            {
                \DB::beginTransaction();
                $novo = new Telefone();
                $novo->ddd = $request->input('ddd');
                $novo->numero_telefone = $request->input('numero_telefone');
                $novo->descricao_telefone = $request->input('descricao_telefone');
                $novo->integrante_id = $request->input('integrante_id');
                $novo->apenado_id = $request->input('apenado_id');
                $novo->user_id = Auth::user()->id;
                $novo->push();
                \DB::commit();
                Flash::success("Cadastro realizado com sucesso.");
            }else{
                //ALTERAR DADOS
                $update = Telefone::find($request->input('idTelefone'));
                $update->ddd = $request->input('ddd');
                $update->numero_telefone = $request->input('numero_telefone');
                $update->descricao_telefone = $request->input('descricao_telefone');
                $update->save();
                Flash::success("Alterado com sucesso.");
            }

            return Redirect::route('faccaointegrantes.incluirDados', $request->input('apenado_id'));
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }

    public function SituacaoTelefone($id, $idInt)
    {
        try
        {
            //define null para todos os itens
            Telefone::where('integrante_id', $idInt)->update(array('atual_telefone' => NULL));
            //FAZ O UPDATE PARA O ATUAL
            Telefone::where('id', $id)->update(array('atual_telefone' => 'S'));
            Flash::success("Alterado Com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Novo Quebrada Atual UPDATE atual', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }

    public function ExcluirTelefone($id)
    {
        try
        {
            DB::table('telefones')->where('id', $id)->delete();
            Flash::success("Excluida com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e)
        {
            Logger::exception('Erro ao excluir Quebrada Atual', $e);
            Flash::error('Ops, houve um erro contate o administrador.');
            return redirect()->back();
        }
    }
//***************************





////***************** TELEFONES ********************//
    public function SalvarClassificacao(Request $request)
    {
        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
            $v['subtitulo'] = "Continuação do Cadastro";

            $validator = validator($request->all(),
                [
                    'faccao_possiveis_id'=>'required',
                    'faccao_classificacao_id'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Obrigatório a indicação de alguma informação.");
                return redirect()->route('faccaointegrantes.incluirDados', $request->input('apenado_id'))->withInput()->withErrors($validator);
            }



                //ALTERAR DADOS
                $update = Integrantes::find($request->input('integrante_id'));
                $update->faccao_possiveis_id = $request->input('faccao_possiveis_id');
                $update->faccao_classificacao_id = $request->input('faccao_classificacao_id');
                $update->save();

            //GRAVA A CLASSIFICAÇÃO NO LOGGER
            LogClassificacoes::Info(Auth::user()->id, $request->input('integrante_id'), $request->input('faccao_possiveis_id'), $request->input('faccao_classificacao_id') );
            Flash::success("Alterado com sucesso.");


            return Redirect::route('faccaointegrantes.incluirDados', $request->input('apenado_id'));
        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }





////***************** CARGOS ********************//
    public function SalvarCargo(Request $request)
    {
        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
            $v['subtitulo'] = "Continuação do Cadastro";

            $validator = validator($request->all(),
                [
                    'cargo_faccao_id'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Obrigatório a indicação de alguma informação.");
                return redirect()->route('faccaointegrantes.incluirDados', $request->input('apenado_id'))->withInput()->withErrors($validator);
            }

            //NOVO CADASTRO
            if($request->input('idCargo') == 0)
            {
                \DB::beginTransaction();
                $novo = new Cargos();
                $novo->cargo_faccao_id = $request->input('cargo_faccao_id');
                $novo->descricao_cargo = $request->input('descricao_cargo');
                $novo->integrante_id = $request->input('integrante_id');
                $novo->apenado_id = $request->input('apenado_id');
                $novo->user_id = Auth::user()->id;
                $novo->push();
                \DB::commit();
                Flash::success("Cadastro realizado com sucesso.");
            }else{
                //ALTERAR DADOS
                $update = Cargos::find($request->input('idCargo'));
                $update->cargo_faccao_id = $request->input('cargo_faccao_id');
                $update->descricao_cargo = $request->input('descricao_cargo');
                $update->save();
                Flash::success("Alterado com sucesso.");
            }

            return Redirect::route('faccaointegrantes.incluirDados', $request->input('apenado_id'));
        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }

    public function SituacaoCargo($id, $idInt)
    {
        try
        {
            //define null para todos os itens
            Cargos::where('integrante_id', $idInt)->update(array('atual_cargo' => NULL));

            //FAZ O UPDATE PARA O ATUAL
            Cargos::where('id', $id)->update(array('atual_cargo' => 'S'));
            Flash::success("Alterado Com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Novo Quebrada Atual UPDATE atual', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }

    public function ExcluirCargo($id)
    {
        try
        {
            DB::table('cargos')->where('id', $id)->delete();
            Flash::success("Excluida com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e)
        {
            Logger::exception('Erro ao excluir Quebrada Atual', $e);
            Flash::error('Ops, houve um erro contate o administrador.');
            return redirect()->back();
        }
    }
//***************************



////***************** CARGOS ********************//
    public function SalvarPadrinhoInterno(Request $request)
    {
        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
            $v['subtitulo'] = "Continuação do Cadastro";

            $validator = validator($request->all(),
                [
                    'padrinho_id'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Obrigatório a indicação de alguma informação.");
                return redirect()->route('faccaointegrantes.incluirDados', $request->input('apenado_id'))->withInput()->withErrors($validator);
            }

            //NOVO CADASTRO
            if($request->input('idPadrinhoInterno') == 0)
            {
                \DB::beginTransaction();
                $novo = new PadrinhosInterno();
                $novo->padrinho_id = $request->input('padrinho_id');
                $novo->descricao_padrinhointerno = $request->input('descricao_padrinhointerno');
                $novo->integrante_id = $request->input('integrante_id');
                $novo->apenado_id = $request->input('apenado_id');
                $novo->user_id = Auth::user()->id;
                $novo->push();
                \DB::commit();
                Flash::success("Cadastro realizado com sucesso.");
            }else{
                //ALTERAR DADOS
                $update = PadrinhosInterno::find($request->input('idPadrinhoInterno'));
                $update->padrinho_id = $request->input('padrinho_id');
                $update->descricao_padrinhointerno = $request->input('descricao_padrinhointerno');
                $update->save();
                Flash::success("Alterado com sucesso.");
            }

            return Redirect::route('faccaointegrantes.incluirDados', $request->input('apenado_id'));
        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }

    public function SituacaoPadrinhoInterno($id)
    {
        try
        {
//            //define null para todos os itens
//            Cargos::where('atual_cargo', 'S')->update(array('atual_cargo' => NULL));
//            //FAZ O UPDATE PARA O ATUAL
//            Cargos::where('id', $id)->update(array('atual_cargo' => 'S'));
//            Flash::success("Alterado Com Sucesso!");
//            return redirect()->back();
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Novo Quebrada Atual UPDATE atual', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }

    public function ExcluirPadrinhoInterno($id)
    {
        try
        {
            DB::table('padrinhosinterno')->where('id', $id)->delete();
            Flash::success("Excluida com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e)
        {
            Logger::exception('Erro ao excluir Quebrada Atual', $e);
            Flash::error('Ops, houve um erro contate o administrador.');
            return redirect()->back();
        }
    }
//***************************






////***************** CARGOS ********************//
    public function SalvarPadrinhoExterno(Request $request)
    {
        try {
            $v['titulo'] = " FACÇÕES - INCLUSÃO DE INFORMAÇÕES DO FACCIONADO";
            $v['subtitulo'] = "Continuação do Cadastro";

            $validator = validator($request->all(),
                [
                    'nome_padrinhoexterno'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Obrigatório a indicação de alguma informação.");
                return redirect()->route('faccaointegrantes.incluirDados', $request->input('apenado_id'))->withInput()->withErrors($validator);
            }

            //NOVO CADASTRO
            if($request->input('idPadrinhoExterno') == 0)
            {
                \DB::beginTransaction();
                $novo = new PadrinhosExterno();
                $novo->nome_padrinhoexterno = $request->input('nome_padrinhoexterno');
                $novo->descricao_padrinhoexterno = $request->input('descricao_padrinhoexterno');
                $novo->integrante_id = $request->input('integrante_id');
                $novo->apenado_id = $request->input('apenado_id');
                $novo->user_id = Auth::user()->id;
                $novo->push();
                \DB::commit();
                Flash::success("Cadastro realizado com sucesso.");
            }else{
                //ALTERAR DADOS
                $update = PadrinhosExterno::find($request->input('idPadrinhoExterno'));
                $update->nome_padrinhoexterno = $request->input('nome_padrinhoexterno');
                $update->descricao_padrinhoexterno = $request->input('descricao_padrinhoexterno');
                $update->save();
                Flash::success("Alterado com sucesso.");
            }

            return Redirect::route('faccaointegrantes.incluirDados', $request->input('apenado_id'));
        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }

    public function SituacaoPadrinhoExterno($id)
    {
        try
        {
//            //define null para todos os itens
//            Cargos::where('atual_cargo', 'S')->update(array('atual_cargo' => NULL));
//            //FAZ O UPDATE PARA O ATUAL
//            Cargos::where('id', $id)->update(array('atual_cargo' => 'S'));
//            Flash::success("Alterado Com Sucesso!");
//            return redirect()->back();
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Novo Quebrada Atual UPDATE atual', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }

    public function ExcluirPadrinhoExterno($id)
    {
        try
        {
            DB::table('padrinhosexterno')->where('id', $id)->delete();
            Flash::success("Excluida com Sucesso!");
            return redirect()->back();
        }
        catch (\Exception $e)
        {
            Logger::exception('Erro ao excluir Quebrada Atual', $e);
            Flash::error('Ops, houve um erro contate o administrador.');
            return redirect()->back();
        }
    }
//***************************






    public function faccoes()
    {
        try {
            $v['titulo'] = " FACÇÕES - CADASTRADAS";
            $v['subtitulo'] = " Resumo das Facções";

            $v['faccoes'] = $this->faccaoModel->all();

            return view('faccaointegrantes.faccoes', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }




    public function listar(Request $request)
    {
        try {

            $v['titulo'] = " FACCIONADOS - LISTAGEM";
            $v['subtitulo'] = " EDIÇÃO E ANEXO DE DOCUMENTOS";

            $perfil = Auth::user()->perfil;
            if($perfil == 'Admin')
            {
                //PERFIL = 'ADMIN' = MOSTRAR TODOS APENADOS DA UNIDADE DO USUÁRIO
                if ($request->has('parametro')) {
                    $v['apenados'] = DB::table('apenados as a')
                        ->join('integrantes as i', 'i.apenado_id', '=', 'a.id')
                        ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
                        ->where('i.datasaida', NULL)
                        ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.cpf', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->select('a.id as idApen', 'a.*', 'i.id as idIntegrante', 'i.*', 'f.sigla', 'f.cor')
                        ->orderby('a.nomeapenado', 'asc')
                        ->paginate(50);


                } else {

                    $v['apenados'] = DB::table('apenados as a')
                        ->join('integrantes as i', 'i.apenado_id', '=', 'a.id')
                        ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
                        ->where('i.datasaida', NULL)
                        ->select('a.id as idApen', 'a.*', 'i.id as idIntegrante', 'i.*', 'f.sigla', 'f.cor')
                        ->orderby('a.nomeapenado', 'asc')
                        ->paginate(50);
                }
            }
            else
            {
                //BLOCO DE VALIDAÇÃO PARA MOSTRAR SOMENTE OS APENADOS DA UNIDADE DO USUÁRIO
                $idUnidadeUser = Auth::user()->unidade_id;
                if ($request->has('parametro')) {
                    $v['apenados'] = DB::table('apenados as a')
                        ->join('integrantes as i', 'i.apenado_id', '=', 'a.id')
                        ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        ->join('unidades as u', 'm.unidade_id','=','u.id')
                        ->WhereIn('i.faccao_possiveis_id', [1,2]) // suspeitos
                        ->where('i.datasaida', NULL)
                        ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.cpf', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->select('a.id as idApen', 'a.*', 'i.id as idIntegrante', 'i.*', 'f.sigla',  'f.cor')
                        ->orderby('a.nomeapenado', 'asc')
                        ->paginate(50);

                } else {
                    $v['apenados'] = DB::table('apenados as a')
                        ->join('integrantes as i', 'i.apenado_id', '=', 'a.id')
                        ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        ->join('unidades as u', 'm.unidade_id','=','u.id')
                        ->where('i.datasaida', NULL)
                        ->WhereIn('i.faccao_possiveis_id', [1,2]) // suspeitos
                        //    ->Where('m.unidade_id','=', '' . $idUnidadeUser . '' )
                        ->select('a.id as idApen', 'a.*', 'i.id as idIntegrante', 'i.*', 'f.sigla', 'f.cor')
                        ->orderby('a.nomeapenado', 'asc')
                        ->paginate(50);
                }
            }

            $v['parametro'] = $request->input('parametro');

            return view('faccaointegrantes.listar', $v);

        } catch (\Exception $e) {
            return $e;
            //$this->auxiliar->GetExeption($e);
            return redirect()->back();
        }
    }


    public function editar($id)
    {
        $v['titulo'] = " FACCIONADOS ";
        $v['subtitulo'] = " EDIÇÃO";

        $v['faccoes'] = $this->faccaoModel->all();

        $v['possiveis'] = $this->faccaoPossivelModel->where('status_poss', 'A')->pluck('tipo_poss', 'id');
        $v['classificacoes'] = $this->faccaoClassificacaoModel->where('status_class', 'A')->pluck('tipo_class', 'id');

        $v['integrante'] = DB::table('integrantes as i')
            ->join('apenados as a', 'i.apenado_id', '=', 'a.id')
            ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
//            ->join('cargos_faccoes as cf', 'cf.id', '=', 'i.cargo_faccao_id')
            ->select('a.id as idApen', 'a.*', 'i.id as idIntegrante', 'i.*', 'f.sigla', 'f.nomefaccao' )
            ->where('a.id', $id)
            ->first();


      //   $padrinho = $this->apenModel->where('id', '=', $v['integrante']->padrinho )->pluck('nomeapenado');

//        if(count($padrinho)<=0){
//            $v['padrinho'] = 'SEM PADRINHO';
//        }else{
//            $v['padrinho'] = $padrinho[0];
//        }
//
        return view('faccaointegrantes.editar', $v );
    }





    public function update(Request $request, $id)
    {
        $idApen = $request->input('idApen');
        try {

            if($request->input('faccao_id') != ''){
                $validator = validator($request->all(),
                    [  'cargo_faccao_id'=>'required', 'faccao_id'=>'required' ]);
                if($validator->fails()){
                    Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Ops! Para Mudança de Facção É obrigatório Indicar um Novo Cargo e um Novo padrinho");
                    return redirect()->route('faccaointegrantes.editar', $idApen)->withInput();
                }
            }

            $integrante = $this->integranteModel->find($id);
                $integrante->matricula = $request->input('matricula');
                $integrante->localbatismo = $request->input('localbatismo');
                $integrante->databatismo = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('databatismo')))) ;
                $integrante->referencia = $request->input('referencia');
                $integrante->nomedebatismo = $request->input('nomedebatismo');
                $integrante->descricaorelevante = $request->input('descricaorelevante');
                $integrante->faccao_classificacao_id = $request->input('faccao_classificacao_id');

            // INFORMAÇÕES PARA O LOG-COM MUDANÇA DE FACCÃO
            if($request->input('faccao_id') != '') {
                $faccaoDE = $integrante->faccao_id;
                $cargoDE = $integrante->cargo_faccao_id;
                $tipoalteracao = 'MUDANÇA DE FACÇÃO';
            }else{
                $tipoalteracao = 'CADASTRO';
                $faccaoDE = '';
                $cargoDE = '';
            }

                if($request->input('faccao_id') != '') {
                    $integrante->padrinho = $request->input('padrinho');
                    $integrante->faccao_id = $request->input('faccao_id');
                    $integrante->cargo_faccao_id = $request->input('cargo_faccao_id');
                }

            if($integrante->save()){
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Dados de Faccionado Alterado com sucesso!");
                LogFaccao::Info( $idApen, $id, $tipoalteracao, $faccaoDE, $request->input('faccao_id'), $cargoDE, $request->input('cargo_faccao_id'));
                return redirect()->route('faccaointegrantes.listar');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$apen->GetExeption($e);
            return redirect()->back();
        }
    }



    public function anexos($id)
    {
        $v['titulo'] = " FACCIONADOS ";
        $v['subtitulo'] = " DOCUMENTOS ANEXOS";

       $idInt = $this->integranteModel->where('apenado_id', '=', $id )->first();

        $v['anexos'] = DB::table('anexos as an')
            ->join('apenados as a', 'an.apenado_id', '=', 'a.id')
            ->Where('an.apenado_id','=', '' . $id . '' )
            ->select('a.id as idApen', 'an.id as idAnexo', 'an.*')
            ->orderby('an.id', 'desc')
            ->get();

        $v['informacoes'] = DB::table('informacoes as i')
            ->join('apenados as a', 'a.id', '=', 'i.apenado_id')
            ->join('users as u', 'u.id', '=', 'i.user_id')
            ->Where('i.apenado_id','=', '' . $id . '' )
            ->Where('i.tipo','=', 'FACCAO' )
            ->select('i.id as idInfo',  'i.descricaoinfo', 'i.datacadastro', 'u.nome')
            ->orderby('i.id', 'desc')
            ->get();

       $v['apenado'] = DB::select("SELECT i.*,a.nomeapenado, a.id as idApen, u.nomeunidade, f.nomefaccao FROM  integrantes i 
                                 JOIN apenados a ON i.apenado_id = a.id
                                 JOIN processos p ON p.apenado_id = a.id
                                 JOIN movimentacoes m ON m.processo_id = p.id
                                 JOIN unidades u ON m.unidade_id = u.id
                                 JOIN faccoes f ON i.faccao_id = f.id
                                 WHERE a.id = $id");
        return view('faccaointegrantes.anexos', $v );
    }

    public function anexos_salvar(Request $request)
    {
        try {
            $v['titulo'] = " FACCIONADOS ";
            $v['subtitulo'] = " DOCUMENTOS ANEXOS";

            $idApen = $request->input('idApen');
            $idIntegrante = $request->input('idIntegrante');
            $idProcesso = $this->processoModel->where('apenado_id', '=', $idApen )->pluck('id');
            $validator = validator($request->all(),
                [ 'titulo'=>'required', 'foto'=>'required' ]);
            if($validator->fails()){
                Flash::warning("Ops!! Todos os campos são obrigatórios");
                return redirect()->route('faccaointegrantes.anexos', $idApen);
            }

            //INSERE A FOTO
            // return $request->file('foto');
            if($request->file('foto'))
            {
                $foto = $request->file('foto');
                $extensao = $foto->getClientOriginalExtension();
                if($extensao == 'exe')
                {
                    Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Este arquivo não é uma foto.");
                    return redirect()->route('faccaointegrantes.anexos', $idApen);
                    return redirect()->back();
                }
            }

            $input = $request->all();
            $anexo = $this->anexoModel->fill($input);
            $anexo->titulo = $request->input('titulo');
            $anexo->tipodocumento = 'FACCAO'; //FACCAO OU CADASTRO
            $anexo->user_id = Auth::user()->id;
            $anexo->processo_id = $idProcesso[0];
            $anexo->apenado_id = $idApen;
            $anexo->integrante_id = $idIntegrante;
            $anexo->datalancamento = date("Y-m-d");

                $nome = sha1(microtime()).'.'.$extensao;
                File::copy($foto, public_path().'/documentos_Faccao/'.$nome);
                $anexo->nomearquivo = 'documentos_Faccao/'.$nome;

            if ($anexo->save()) {

                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Documento Enviado com Sucesso!");
                Logger::Success('Cadastro de Anexo/Documento', 'Inserido Novo - ' . $idApen . ' ');
                return redirect()->route('faccaointegrantes.anexos', $idApen);
                return redirect()->back();

            } else {
                Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Houve um Erro no anexo.");
                return redirect()->route('faccaointegrantes.anexos', $idApen);
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return  $e->getMessage();
            $this->$anexo->GetExeption($e);
            Logger::error('Anexar Documento Faccionado','Erro na inclusão da Documento Faccionado - '.$e.' ');
            return redirect()->back();
        }
    }

    public function informacoes_inserir(Request $request){

        try {
            $idA = $request->input('idapenid');
            $validator = validator($request->all(),
                [
                    'descricaoinfo'=>'required', 'idapenid'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! É Informe algo para salvar");
                return redirect()->route('faccaointegrantes.anexos',$idA );
            }

            $input = $request->all();
            $infor = $this->informacoesModel->fill($input);
            $infor->tipo = 'FACCAO';
            $infor->descricaoinfo = $request->input('descricaoinfo');
            $infor->datacadastro = date("Y-m-d");
            $infor->user_id = Auth::user()->id;
            $infor->apenado_id = $idA;

            if ($infor->save()) {
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Informação Adicional cadastrada com sucesso!");
                Logger::Success('Informação Adicional FACCIONADO', 'Informação Adicional FACCIONADO- ' . $idA . ' ');
                return redirect()->route('faccaointegrantes.anexos',$idA);
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return  $e->getMessage();
            $this->$infor->GetExeption($e);
            Logger::error('Informação Adicional FACCIONADO','Erro na inclusão da Informação Adicional FACCIONADO- '.$e.' ');
            return redirect()->back();
        }

    }



    public function listarporfaccao(Request $request, $id, $tipo)
    {
        try {

            $v['titulo'] = " FACCIONADOS - LISTAGEM";
            $v['subtitulo'] = " RELAÇÃO DE APENADOS FACCIONADOS POR FACÇÃO";

            $v['faccao'] = $this->faccaoModel->find($id);

            $v['apenados'] = DB::table('integrantes as i')
                ->join('apenados as a', 'a.id','=','i.apenado_id')
                ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->Where('i.faccao_id', $id)
                ->Where('i.datasaida', NULL )
                ->Where('i.faccao_possiveis_id', $tipo) // suspeitos
                ->Where('m.datasaida', NULL )
                ->select('a.id as idApen', 'i.id as idInteg', 'a.nomeapenado',  'u.cidadeunidade', 'u.nomeunidade', 'f.nomefaccao', 'm.cela_id')
                ->get();

            $v['parametro'] = $request->input('parametro');
            return view('faccaointegrantes.listarporfaccao', $v);

        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }




    //Cancela apenado da facção atual
    public function cancelar(Request $request)
    {
        $v['titulo'] = " FACCIONADOS - LISTAGEM";
        $v['subtitulo'] = " EDIÇÃO E ANEXO DE DOCUMENTOS";

        $idInt = $request->input('id');
        $validator = validator($request->all(),
            [
                'datasaida'=>'required'
            ]);
        if($validator->fails()){
            Flash::warning("Ops!! Todos os campos são obrigatórios");
            return redirect()->route('faccaointegrantes.listar', $v);
        }

        $cancela = Integrantes::find($idInt);

        $cancela->datasaida = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datasaida'))));
        $cancela->motivosaidafaccao = $request->input('motivosaidafaccao');

        if($cancela->update()) {
            Flash::success("Integrante Cancelado com sucesso.");
            LogFaccao::Info( $request->input('apenado_id'),$idInt, 'SAÍDA FACÇÃO', '', '', '', '');
            return redirect()->route('faccaointegrantes.listar', $v);
            return redirect()->back();
        }
        else {
            Flash::error("Erro ao tentar atualizar conteudo..");
            return Redirect::route('advogados.mostraradvogados');
        }

    }



    public function selectPadrinhos($idFac)
    {
        try
        {
              return  $padrinho = DB::table('apenados as a')
                    ->join('integrantes as i', 'a.id', '=', 'i.apenado_id')
                    ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
                    ->Where('i.faccao_id','=', '' . $idFac . '')
                    ->select('a.id','a.nomeapenado')
                    ->get();
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function selectClassificacao($id)
    {
        try
        {
            return  $result = DB::table('faccao_classificacao as c')
                ->Where('c.possivel_id',$id )
                ->select('c.id','c.tipo_class')
                ->get();
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }



    public function destroyInformacaoFaccao($idApen, $idInfo)
    {
        try
        {
            $v['idApen'] = $idApen;
            $del = Informacao::destroy($idInfo);
            Flash::success("Informação Excluida com Sucesso.");
            Logger::success('Exclusão de Informação de Faccionado', 'Apenado'.$idApen.' Servidor: ' . Auth::user()->id );
            return redirect()->route('faccaointegrantes.anexos', $v);
        }
        catch (\Exception $e) {
            $e->getMessage();
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }

    public function destroyAnexoFaccao($idApen, $idAnexo)
    {
        try
        {
            $v['idApen'] = $idApen;
            $del = Anexo::destroy($idAnexo);
            Flash::success("Anexo Excluido com Sucesso.");
            Logger::success('Exclusão de Anexo de Faccionado', 'Apenado'.$idApen.' Servidor: ' . Auth::user()->id );
            return redirect()->route('faccaointegrantes.anexos', $v);
        }
        catch (\Exception $e) {
            $e->getMessage();
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }



}
