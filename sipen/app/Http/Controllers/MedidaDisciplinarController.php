<?php

namespace App\Http\Controllers;

use App\Model\MedidaDisciplinar;
use Illuminate\Http\Request;
use DB, Logger;
use Illuminate\Support\Facades\Auth;
use Flash;

class MedidaDisciplinarController extends Controller
{
    public function __construct(MedidaDisciplinar $medidaModel)
    {
        $this->medidaModel = $medidaModel;
    }


    public function index(Request $request)
    {
        try {

            $v['titulo'] = " MEDIDA DISCIPLINAR ";
            $v['subtitulo'] = " Controle de Medida Disciplinar";

            $perfil = Auth::user()->perfil;
            if($perfil == 'Admin')
            {
                //PERFIL = 'ADMIN' = MOSTRAR TODOS APENADOS DA UNIDADE DO USUÁRIO
                if ($request->has('parametro')) {
                    $v['apenados'] = DB::table('apenados as a')
                        ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.cpf', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orderby('a.nomeapenado', 'asc')
                        ->get();
                } else {
                    $v['apenados'] = '';
                }
            }
            else
            {
                //BLOCO DE VALIDAÇÃO PARA MOSTRAR SOMENTE OS APENADOS DA UNIDADE DO USUÁRIO
                $idUnidadeUser = Auth::user()->unidade_id;
                if ($request->has('parametro')) {
                    $v['apenados'] = DB::table('apenados as a')
                        ->join('processos as p', 'a.id','=','p.apenado_id')
                        ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                        ->join('unidades as u', 'm.unidade_id','=','u.id')
                        ->Where('m.unidade_id','=', '' . $idUnidadeUser . '' )
                        ->Where('m.datasaida','=', NULL )
                        ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.cpf', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->select('a.*')
                        ->orderby('a.nomeapenado', 'asc')
                        ->get();
                } else {
                    $v['apenados'] = '';
                }
            }

            $v['parametro'] = $request->input('parametro');
            return view('medidadisciplinar.index', $v);

        } catch (\Exception $e) {
            return $e;
            //$this->auxiliar->GetExeption($e);
            return redirect()->back();
        }
    }



    public function mostradados($id)
    {
        try {
            $v['titulo'] = " MEDIDA DISCIPLINAR ";
            $v['subtitulo'] = " Controle de Medida Disciplinar";


            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id','=', '' . $id . '')
                ->Where('m.datasaida','=', NULL)
                ->select('a.*', 'm.id as idMovimentacao', 'm.unidade_id','m.cela_id', 'c.nomecela', 'u.nomeunidade', 'p.id as idProcesso')
                ->first();

            $v['disciplinas'] = DB::table('medidadisciplinar as m')
                //->join('advogados as ad', 'ad.id','=','aa.advogado_id')
                //->join('apenados as a', 'a.id','=','aa.apenado_id')
                ->Where('m.apenado_id', $id )
                // ->select('ad.id as idAdv', 'aa.id as idAdvApen', 'ad.*', 'aa.*')
                ->orderby('id', 'desc')
                ->get();

            return view('medidadisciplinar.mostradados', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }


    public function salvar(Request $request)
    {
        try {
            $v['titulo'] = " MEDIDA DISCIPLINAR ";
            $v['subtitulo'] = " Controle de Medida Disciplinar";

            $validator = validator($request->all(),
                [
                    'tipomedida_md'=>'required', 'datainicio_md1'=>'required', 'tempo_md1'=>'required',
                    'datafim_md1'=>'required', 'ocorrencia_md'=>'required', 'descricao_md'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! Todos os campos são obrigatórios");
                return redirect()->route('medidadisciplinar.mostradados', $request->input('apenado_id') );
            }

            ///PAREI AQUI
            $input = $request->all();
            $md = $this->medidaModel->fill($input);

            $md->datainicio_md = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datainicio_md1'))));
            $md->tempo_md = $request->input('tempo_md1');
            $md->datafim_md = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datafim_md1'))));

            $md->user_id = Auth::user()->id;

            if ($md->save()) {
                Flash::success("Cadastrado realizado com sucesso!");
                Logger::Success('Cadastro de Medida Disciplinar', 'Inserido Novo ' . $request->input('ocorrencia_md') . ' ');
                return redirect()->route('medidadisciplinar.mostradados', $request->input('apenado_id'));
                return redirect()->back();

            } else {
                Flash::warning("Oops! Houve um Erro na VIsita.");
                Logger::error('Medida Discipliar - Error', 'Erro na Disciplinar -> Novo');
                return redirect()->route('medidadisciplinar.mostradados', $request->input('apenado_id'));
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return  $e->getMessage();
            $this->$pad->GetExeption($e);
            Logger::error('Erro MD ','Erro na inclusão do MD - '.$e.' ');
            return redirect()->back();
        }
    }



    public function update(Request $request)
    {
        $idMd = $request->input('id');

        $guia = $request->input('guiaList');
        if($guia == 'listagem01')
        {
            $rotaretorno = redirect()->route('listagem.medidadisciplinar', 01);
        }elseif($guia == 'listagem02')
        {
            $rotaretorno = redirect()->route('listagem.medidadisciplinar', 02);
        }elseif($guia == 'listagem')
        {
            $rotaretorno = redirect()->route('listagem.medidadisciplinar');

        }else{
            $rotaretorno = redirect()->route('medidadisciplinar.mostradados', $request->input('apenado_id') );
        }


        $validator = validator($request->all(),
            [
                'databaixa_md'=>'required'
            ]);
        if($validator->fails()){
            Flash::warning("Ops!! Todos os campos são obrigatórios");
            return $rotaretorno;
        }

        $md = new MedidaDisciplinar();
        $mdd = $md->find($idMd);
        $mdd->descricaobaixa_md = $request->input('descricaobaixa_md');
        $mdd->databaixa_md = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('databaixa_md'))));

        if($mdd->save()) {
            Flash::success("Operação Realizada com Sucesso.");
            return $rotaretorno;
            return redirect()->back();
        }
        else {
            Flash::error("Erro ao tentar atualizar conteudo..");
            return $rotaretorno;
        }


    }


}
