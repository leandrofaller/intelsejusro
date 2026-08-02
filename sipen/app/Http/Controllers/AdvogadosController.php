<?php

namespace App\Http\Controllers;

use App\Model\Advogado;
use App\Model\AdvogadosApenados;
use Illuminate\Http\Request;
use Auth;
use Flash;
use App\Model\Logger;
use DB;
use File;

class AdvogadosController extends Controller
{
    protected $advogadoModel;
    protected $advogadoApenadosModel;
    public function __construct(Advogado $advogadoModel, AdvogadosApenados $advogadoApenadoModel)
    {
        $this->advogadoModel= $advogadoModel;
        $this->advogadoApenadosModel = $advogadoApenadoModel;
    }

    public function mostrarapenados(Request $request)
    {
        try {

            $v['titulo'] = " ADVOGADOS ";
            $v['subtitulo'] = " Selecine o Apenado para Inclusão de Advogado";

            $perfil = Auth::user()->perfil;
            if($perfil == 'Admin')
            {
                //PERFIL = 'ADMIN' = MOSTRAR TODOS APENADOS DA UNIDADE DO USUÁRIO
                if ($request->has('parametro')) {
                    $v['apenados'] = DB::table('apenados as a')
                        ->Where('a.nomeapenado', 'LIKE', '%' . $request->input('parametro') . '%')
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
                        ->select('a.*')
                        ->orderby('a.nomeapenado', 'asc')
                        ->get();
                } else {
                    $v['apenados'] = '';
                }
            }

            $v['parametro'] = $request->input('parametro');
            return view('advogados.mostrarapenados', $v);

        } catch (\Exception $e) {
            return $e;
            //$this->auxiliar->GetExeption($e);
            return redirect()->back();
        }
    }


    public function mostraradvogados($id)
    {
        try {
            $v['titulo'] = " ADVOGADOS ";
            $v['subtitulo'] = " Mostrar Advogados do Apenado";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id','=', '' . $id . '')
                ->Where('m.datasaida','=', NULL)
                ->select('a.*', 'm.id as idMovimentacao', 'm.unidade_id','m.cela_id', 'c.nomecela', 'u.nomeunidade')
                ->first();

            $v['advogados'] = DB::table('advogados_apenados as aa')
                ->join('advogados as ad', 'ad.id','=','aa.advogado_id')
                ->join('apenados as a', 'a.id','=','aa.apenado_id')
                ->Where('aa.apenado_id','=', '' . $id . '')
                ->select('ad.id as idAdv', 'aa.id as idAdvApen', 'ad.*', 'aa.*')
                ->get();

             $v['listageraladvogados'] = DB::table('advogados')->pluck('nomeadvogado', 'id');

            return view('advogados.mostraradvogados', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }


    public function vincular(Request $request)
    {
        try {

            $v['titulo'] = " ADVOGADOS";
            $v['subtitulo'] = " Cadastrar Advogado para o Apenado";

            $validator = validator($request->all(),
                [
                    'advogado_id'=>'required', 'datacadastroadvogado'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! Todos os campos são obrigatórios");
                return redirect()->route('advogados.mostraradvogados', $request->input('apenado_id') );
            }

            $advApen = new AdvogadosApenados();
            $advApen->datacadastro = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datacadastroadvogado'))));
            $advApen->user_id = Auth::user()->id ;
            $advApen->datacancelamento = null ;
            $advApen->motivo = null ;
            $advApen->apenado_id = $request->input('apenado_id') ;
            $advApen->advogado_id = $request->input('advogado_id') ;

                if($advApen->save())
                {
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Advogado Vinculado com sucesso!");
                Logger::Success('Cadastro de Advogado', 'Inserido Novo Advogado - ' . $request->input('advogado_id') . ' ');
                return redirect()->route('advogados.mostraradvogados', $request->input('apenado_id'));
                return redirect()->back();

            } else {
                Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Houve um Erro na VIsita.");
                Logger::error('Nova Advogado', 'Erro na Advogado -> Novo');
                return redirect()->route('advogados.mostraradvogados', $request->input('apenado_id'));
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return  $e->getMessage();
            $this->$adv->GetExeption($e);
            Logger::error('Erro Advogado ','Erro na inclusão do Advogado - '.$e.' ');
            return redirect()->back();
        }
    }


    public function salvar(Request $request)
    {
        try {

            $v['titulo'] = " ADVOGADOS";
            $v['subtitulo'] = " Cadastrar Advogado para o Apenado";

            $validator = validator($request->all(),
                [
                    'nomeadvogado'=>'required', 'rgadvogado'=>'required', 'cpfadvogado'=>'required', 'oab'=>'required',
                    'enderecoadvogado'=>'required', 'seccional'=>'required', 'telefoneadvogado'=>'required',
                    'datacadastroadvogado'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! Todos os campos são obrigatórios");
                return redirect()->route('advogados.mostraradvogados', $request->input('apenado_id') );
            }

            $input = $request->all();
            $adv = $this->advogadoModel->fill($input);
            $adv->datacadastroadvogado = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datacadastroadvogado'))));

            //INSERE A FOTO
            // return $request->file('foto');
            if($request->file('foto'))
            {
                $foto = $request->file('foto');
                $extensao = $foto->getClientOriginalExtension();
                if($extensao != 'jpg' && $extensao != 'JPG' && $extensao != 'jpeg' && $extensao != 'JPEG' && $extensao != 'png' && $extensao != 'PNG')
                {
                    Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Este arquivo não é uma foto.");
                    return redirect()->route('advogados.mostraradvogados', $request->input('apenado_id'));
                    return redirect()->back();
                }
            }

            if($request->file('foto')) {
                $nome = sha1(microtime()).'.'.$extensao;
                File::copy($foto, public_path().'/fotosAdvogados/'.$nome);
                $adv->foto = 'fotosAdvogados/'.$nome;
            }else{
                $adv->foto = 'fotosAdvogados/semfoto.png';
            }

            if ($adv->save()) {
                //INICIA A INSERÇÃO DA PRISAO
                $advApen = new AdvogadosApenados();
                $advApen->datacadastro = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datacadastroadvogado'))));
                $advApen->user_id = Auth::user()->id ;
                $advApen->datacancelamento = null ;
                $advApen->motivo = null ;
                $advApen->apenado_id = $request->input('apenado_id') ;
                $advApen->advogado_id = $adv->id ;

                $advApen->save();

                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Advogado cadastrado com sucesso!");
                Logger::Success('Cadastro de Advogado', 'Inserido Novo Advogado - ' . $request->input('nomeadvogado') . ' ');
                return redirect()->route('advogados.mostraradvogados', $request->input('apenado_id'));
                return redirect()->back();

            } else {
                Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Houve um Erro na VIsita.");
                Logger::error('Nova Advogado', 'Erro na Advogado -> Novo');
                return redirect()->route('advogados.mostraradvogados', $request->input('apenado_id'));
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return  $e->getMessage();
            $this->$adv->GetExeption($e);
            Logger::error('Erro Advogado ','Erro na inclusão do Advogado - '.$e.' ');
            return redirect()->back();
        }
    }


    public  function advogados_update(Request $request) {
        $idAdv = $request->get('id');

        $validator = validator($request->all(),
            [
                'nomeadvogado'=>'required', 'rgadvogado'=>'required', 'cpfadvogado'=>'required', 'oab'=>'required',
                'enderecoadvogado'=>'required',
                'seccional'=>'required', 'telefoneadvogado'=>'required', 'datacadastroadvogado'=>'required'
            ]);
        if($validator->fails()){
            Flash::warning("Ops!! Todos os campos são obrigatórios");
            return redirect()->route('advogados.listaradvogados');
        }


        $advM = new Advogado();
        $adv = $advM->find($idAdv);

        $adv->nomeadvogado = $request->input('nomeadvogado');
        $adv->rgadvogado = $request->input('rgadvogado');
        $adv->cpfadvogado = $request->input('cpfadvogado');
        $adv->oab = $request->input('oab');
        $adv->enderecoadvogado = $request->input('enderecoadvogado');
        $adv->seccional = $request->input('seccional');
        $adv->telefoneadvogado = $request->input('telefoneadvogado');
        $adv->datacadastroadvogado = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datacadastroadvogado'))));


        // return $request->file('fotovisita');
        if($request->file('foto'))
        {
            $foto = $request->file('foto');
            $extensao = $foto->getClientOriginalExtension();
            if($extensao != 'jpg' && $extensao != 'JPG' && $extensao != 'jpeg' && $extensao != 'JPEG' && $extensao != 'png' && $extensao != 'PNG')
            {
                Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Este arquivo não é uma foto.");
                return redirect()->route('advogados.listaradvogados');
                return redirect()->back();
            }
        }

        if($request->file('foto')) {
            $nome = sha1(microtime()).'.'.$extensao;
            File::copy($foto, public_path().'/fotosAdvogados/'.$nome);
            $adv->foto = 'fotosAdvogados/'.$nome;
        }else{
            // $visita->fotovisita = 'semfoto.png';
        }

        if($adv->save()) {
            Flash::success("Conteudo atualizado com sucesso.");
            // Logger::success('Diario academico Conteudo', 'Conteudo atualizado com sucesso');
            return redirect()->route('advogados.listaradvogados');
            return redirect()->back();
        }
        else {
            Flash::error("Erro ao tentar atualizar conteudo..");
            return Redirect::route('advogados.listaradvogados');
        }
    }



    public function cancelar(Request $request)
    {
        $idAdvApen = $request->input('idd');

        $validator = validator($request->all(),
            [
                'datacancelamento'=>'required', 'motivo'=>'required'
            ]);
        if($validator->fails()){
            Flash::warning("Ops!! Todos os campos são obrigatórios");
            return redirect()->route('advogados.mostraradvogados', $request->input('apenado_id'));
        }

        $advApenM = new AdvogadosApenados();
        $cancela = $advApenM->find($idAdvApen);

        $cancela->datacancelamento = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datacancelamento'))));
        $cancela->motivo = $request->input('motivo');

        if($cancela->save()) {
            Flash::success("Advogado Cancelado com sucesso.");
            //Logger::success('Diario academico Conteudo', 'Conteudo atualizado com sucesso');
            return redirect()->route('advogados.mostraradvogados', $request->input('apenado_id'));
            return redirect()->back();
        }
        else {
            Flash::error("Erro ao tentar atualizar conteudo..");
            return Redirect::route('advogados.mostraradvogados');
        }

    }





    public function listaradvogados(Request $request)
    {
        try {
            $v['titulo'] = " ADVOGADOS";
            $v['subtitulo'] = " Lista de Advogados";

            //PERFIL = 'ADMIN' = MOSTRAR TODOS APENADOS DA UNIDADE DO USUÁRIO
            if ($request->has('parametro')) {
                $v['advogados'] = DB::table('advogados_apenados as aa')
                    ->join('advogados as a', 'a.id','=','aa.advogado_id')
                    ->Where('a.nomeadvogado', 'LIKE', '%' . $request->input('parametro') . '%')
                    ->orWhere('a.cpfadvogado', 'LIKE', '%' . $request->input('parametro') . '%')
                    ->orWhere('a.oab', 'LIKE', '%' . $request->input('parametro') . '%')
                    ->select('a.id as idAdv', 'a.*', 'aa.*')
                    ->orderby('a.nomeadvogado', 'asc')
                    ->paginate(10);

            } else {

                $v['advogados'] = DB::table('advogados_apenados as aa')
                    ->join('advogados as a', 'a.id','=','aa.advogado_id')
                    ->groupby('aa.advogado_id')
                    ->select('a.id as idAdv', 'a.*', 'aa.*')
                    ->orderby('a.nomeadvogado', 'asc')
                    ->paginate(10);
            }

            $v['parametro'] = $request->input('parametro');
            return view('advogados.listaradvogados', $v);

        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }




    public function detalhaclientes($id)
    {
        try {
            $v['titulo'] = " ADVOGADOS";
            $v['subtitulo'] = " Detalha Clientes";

            $v['advogado'] = DB::table('advogados as a')
                ->join('advogados_apenados as aa', 'a.id','=','aa.advogado_id')
                //->join('apenados as p', 'p.id','=','va.apenado_id')
                ->Where('a.id','=', '' . $id . '')
                ->select('a.id as idAdv', 'a.*', 'aa.id as idAdvApenado', 'aa.*')
                ->first();


            $v['apenados'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->join('advogados_apenados as aa', 'a.id', '=', 'aa.apenado_id')
                ->Where('aa.advogado_id','=', '' . $id . '')
                ->Where('m.datasaida','=', NULL)
                ->select('a.*', 'u.nomeunidade', 'c.nomecela', 'p.numeroprocesso', 'p.artigos', 'p.tempodepena', 'aa.datacancelamento')
                ->get();



            return view('advogados.detalhaclientes', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }



}
