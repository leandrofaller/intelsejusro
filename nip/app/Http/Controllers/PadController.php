<?php

namespace App\Http\Controllers;

use App\Model\Pad;
use Illuminate\Http\Request;
use Auth, DB;
use App\Model\Logger;
use Flash;


class PadController extends Controller
{

    public function __construct(Pad $padModel)
    {
        $this->padModel= $padModel;
    }


    public function index(Request $request)
    {
        try {

            $v['titulo'] = " PAD ";
            $v['subtitulo'] = " Controle de Processo Administrativo Disciplinar";

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
            return view('pad.index', $v);

        } catch (\Exception $e) {
            return $e;
            //$this->auxiliar->GetExeption($e);
            return redirect()->back();
        }
    }

    public function mostradados($id)
    {
        try {
            $v['titulo'] = " PAD ";
            $v['subtitulo'] = " Controle de Processo Administrativo Disciplinar";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id','=', '' . $id . '')
                ->Where('m.datasaida','=', NULL)
                ->select('a.*', 'm.id as idMovimentacao', 'm.unidade_id','m.cela_id', 'c.nomecela', 'u.nomeunidade', 'p.id as idProcesso')
                ->first();

            $v['pads'] = DB::table('pad as p')
                //->join('advogados as ad', 'ad.id','=','aa.advogado_id')
                //->join('apenados as a', 'a.id','=','aa.apenado_id')
                ->Where('p.apenado_id', $id )
               // ->select('ad.id as idAdv', 'aa.id as idAdvApen', 'ad.*', 'aa.*')
                ->get();

            return view('pad.mostradados', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }



    public function salvar(Request $request)
    {
        try {

            $v['titulo'] = " PAD ";
            $v['subtitulo'] = " Controle de Processo Administrativo Disciplinar";

            $validator = validator($request->all(),
                [
                    'descricaopad'=>'required', 'datainiciopad'=>'required',
                    'tipofato'=>'required', 'tipofalta'=>'required', 'numerorelatorioseguranca'=>'required'
                    // 'numeropad'=>'required',
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! Todos os campos são obrigatórios");
                return redirect()->route('pad.mostradados', $request->input('apenado_id') );
            }

            $input = $request->all();
            $pad = $this->padModel->fill($input);
            $pad->datainiciopad = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datainiciopad'))));
            $pad->user_id = Auth::user()->id;
            if ($pad->save()) {

                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> PAD cadastrado com sucesso!");
                Logger::Success('Cadastro de PAD', 'Inserido Novo PAD - ' . $request->input('numeropad') . ' ');
                return redirect()->route('pad.mostradados', $request->input('apenado_id'));
                return redirect()->back();

            } else {
                Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Houve um Erro na VIsita.");
                Logger::error('PAD - Error', 'Erro na Pad -> Novo');
                return redirect()->route('pad.mostradados', $request->input('apenado_id'));
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return  $e->getMessage();
            $this->$pad->GetExeption($e);
            Logger::error('Erro pad ','Erro na inclusão do PAD - '.$e.' ');
            return redirect()->back();
        }
    }


    public function update(Request $request)
    {
        $idPad = $request->input('idPad');

        $validator = validator($request->all(),
            [
                'descricaopad'=>'required', 'datainiciopad'=>'required',
                'tipofato'=>'required', 'tipofalta'=>'required', 'numerorelatorioseguranca'=>'required'
                // 'numeropad'=>'required',
            ]);
        if($validator->fails()){
            Flash::warning("Ops!! Todos os campos são obrigatórios");
            return redirect()->route('pad.mostradados', $request->input('apenado_id') );
        }

        $pad = new Pad();
        $concluirpad = $pad->find($idPad);

        if($request->input('dataconclusaopad') != NULL)
        {
        $concluirpad->dataconclusaopad = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataconclusaopad'))));
        $concluirpad->situacaopad = $request->input('situacaopad');
        }

        if($request->input('situacaopad') == NULL)
        {
           $concluirpad->dataconclusaopad = NULL;
        }


        $concluirpad->descricaopad = $request->input('descricaopad');
        $concluirpad->tipofato = $request->input('tipofato');
        $concluirpad->tipofalta = $request->input('tipofalta');

        if($concluirpad->save()) {
            Flash::success("Operação Realizada com Sucesso.");
            return redirect()->route('pad.mostradados', $request->input('apenado_id') );
            return redirect()->back();
        }
        else {
            Flash::error("Erro ao tentar atualizar conteudo..");
            return Redirect::route('pad.index');
        }

    }




}
