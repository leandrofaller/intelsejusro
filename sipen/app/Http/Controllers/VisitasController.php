<?php

namespace App\Http\Controllers;

use App\Model\Visita;
use App\Model\VisitasApenados;
use Illuminate\Http\Request;
use Flash;
use App\Model\Logger;
use Auth;
use DB;
use File;

class VisitasController extends Controller
{
    protected $visitasModel;
    protected $visitasApenadosModel;
    public function __construct(Visita $visitasModel, VisitasApenados $visitasApenadosModel)
    {
        $this->visitasModel = $visitasModel;
        $this->visitasApenadosModel = $visitasApenadosModel;
    }

    public function mostrarapenados(Request $request)
    {
        try {

            $v['titulo'] = " VISITANTES";
            $v['subtitulo'] = " Selecine o Apenado para Inclusão de Visitantes";

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
                        ->orWhere('a.alcunha', 'LIKE', '%' . $request->input('parametro') . '%')
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
                        ->orWhere('a.nomepai', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.nomemae', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('a.alcunha', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->select('a.*')
                        ->orderby('a.nomeapenado', 'asc')
                        ->get();
                } else {
                    $v['apenados'] = '';

                }
            }

            $v['parametro'] = $request->input('parametro');
            return view('visitas.mostrarapenados', $v);

        } catch (\Exception $e) {
            return $e;
            //$this->auxiliar->GetExeption($e);
            return redirect()->back();
        }
    }

    public function listarvisitantes(Request $request)
    {
        try {
            $v['titulo'] = " VISITANTES";
            $v['subtitulo'] = " Lista de Visitantes";

                //PERFIL = 'ADMIN' = MOSTRAR TODOS APENADOS DA UNIDADE DO USUÁRIO
                if ($request->has('parametro')) {
                    $v['visitas'] = DB::table('visitas_apenados as va')
                        ->join('visitas as v', 'v.id','=','va.visita_id')
                        ->Where('v.nomevisita', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->orWhere('v.cpfvisita', 'LIKE', '%' . $request->input('parametro') . '%')
                        ->select('v.id as idVisita', 'v.*', 'va.*')
                        ->orderby('v.nomevisita', 'asc')
                        ->paginate(10);

                } else {

                    $v['visitas'] = DB::table('visitas_apenados as va')
                        ->join('visitas as v', 'v.id','=','va.visita_id')
                        ->select('v.id as idVisita', 'v.*', 'va.*')
                        ->orderby('v.nomevisita', 'asc')
                        ->paginate(10);
                }

            $v['parametro'] = $request->input('parametro');
            return view('visitas.listarvisitantes', $v);

        } catch (\Exception $e) {
            return $e;
            return redirect()->back();
        }
    }



    public function mostrarvisitantes($id)
    {
        try {
            $v['titulo'] = " VISITANTES";
            $v['subtitulo'] = " Mostrar Visitantes do Apenado";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id','=', '' . $id . '')
                ->Where('m.datasaida','=', NULL )
                ->select('a.*', 'm.id as idMovimentacao', 'm.unidade_id','m.cela_id', 'c.nomecela', 'u.nomeunidade')
                ->first();

            $v['visitas'] = DB::table('visitas_apenados as va')
                ->join('visitas as v', 'v.id','=','va.visita_id')
                ->join('apenados as p', 'p.id','=','va.apenado_id')
                ->Where('va.apenado_id','=', '' . $id . '')
                ->select('v.*', 'v.nomevisita', 'va.id as idVisitaApenado', 'va.*')
                ->get();

            return view('visitas.mostrarvisitantes', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }




    public function novo(Request $request)
    {

        try {

            $v['titulo'] = "VISITANTES";
            $v['subtitulo'] = "Novo Cadastrar de Visitante";

            $idApen = $request->input('apenado_id');

         $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id','=', '' . $idApen . '')
                ->Where('m.datasaida','=', NULL )
                ->select('a.*', 'm.id as idMovimentacao', 'm.unidade_id','m.cela_id', 'c.nomecela', 'u.nomeunidade')
                ->first();

         $v['tipovisita'] = $request->input('tipoparente');
         $v['cpfvisita'] = $request->input('cpfvisita');

            return view('visitas.novo', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }



    }

    public function salvar(Request $request)
    {
        try {

            $v['titulo'] = " VISITANTES";
            $v['subtitulo'] = " Cadastrar Visitante para o Apenado";

            $validator = validator($request->all(),
                [
                    'nomevisita'=>'required', 'cpfvisita'=>'required', 'rgvisita'=>'required', 'datanascimentovisita'=>'required',
                    'fotovisita'=>'required', 'parentescovisita'=>'required', 'enderecovisita'=>'required',
                    'ufvisita'=>'required', 'cidadevisita'=>'required', 'telefonecontato'=>'required', 'dataemicaocarteirinha'=>'required',
                    'parentescovisita'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! Todos os campos são obrigatórios");
                return redirect()->route('visitas.mostrarvisitantes', $request->input('apenado_id') );
            }

            $input = $request->all();
            $visita = $this->visitasModel->fill($input);
            $visita->datanascimentovisita = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datanascimentovisita'))));
            $visita->dataemicaocarteirinha = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataemicaocarteirinha'))));

            //INSERE A FOTO
            // return $request->file('foto');
            if($request->file('fotovisita'))
            {
                $fotovisita = $request->file('fotovisita');
                $extensao = $fotovisita->getClientOriginalExtension();
                if($extensao != 'jpg' && $extensao != 'JPG' && $extensao != 'jpeg' && $extensao != 'JPEG' && $extensao != 'png' && $extensao != 'PNG')
                {
                    Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Este arquivo não é uma foto.");
                    return redirect()->route('visitas.incluirvisitantes', $request->input('apenado_id'));
                    return redirect()->back();
                }
            }

            if($request->file('fotovisita')) {
                $nomefoto = sha1(microtime()).'.'.$extensao;
                File::copy($fotovisita, public_path().'/fotosVisitas/'.$nomefoto);
                $visita->fotovisita = 'fotosVisitas/'.$nomefoto;
            }else{
                $visita->fotovisita = 'fotosVisitas/semfoto.png';
            }

            if ($visita->save()) {
                //INICIA A INSERÇÃO DA PRISAO
                $visitaApen = new VisitasApenados();
                $visitaApen->datacadastro = date("Y-m-d");
                $visitaApen->user_id = Auth::user()->id ;
                $visitaApen->datacancelamento = null ;
                $visitaApen->parentescovisita = $request->input('parentescovisita') ;
                $visitaApen->motivo = null ;
                $visitaApen->apenado_id = $request->input('apenado_id') ;
                $visitaApen->visita_id = $visita->id ;

                $visitaApen->save();

                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Visita cadastrada com sucesso!");
                Logger::Success('Cadastro de Visitante', 'Inserido Novo Visitante - ' . $request->input('nomevisita') . ' ');
                return redirect()->route('visitas.mostrarvisitantes', $request->input('apenado_id'));
                return redirect()->back();

            } else {
                Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Houve um Erro na VIsita.");
                Logger::error('Nova Visita', 'Erro na Visita -> Novo');
                return redirect()->route('visitas.mostrarvisitantes');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return  $e->getMessage();
            $this->$visita->GetExeption($e);
            Logger::error('Erro Visita','Erro na inclusão da Visita - '.$e.' ');
            return redirect()->back();
        }
    }


    public  function visitas_update(Request $request) {
        $idVisita = $request->get('id');

        $validator = validator($request->all(),
            [
                'nomevisita'=>'required', 'cpfvisita'=>'required', 'rgvisita'=>'required', 'datanascimentovisita'=>'required',
                'enderecovisita'=>'required',
                'ufvisita'=>'required', 'cidadevisita'=>'required', 'telefonecontato'=>'required', 'dataemicaocarteirinha'=>'required',
            ]);
        if($validator->fails()){
            Flash::warning("Ops!! Todos os campos são obrigatórios");
            return redirect()->route('visitas.listarvisitantes');
        }



        $visitaM = new Visita();
        $visita = $visitaM->find($idVisita);

        $visita->nomevisita = $request->input('nomevisita');
        $visita->cpfvisita = $request->input('cpfvisita');
        $visita->rgvisita = $request->input('rgvisita');
        // $visita->parentescovisita = $request->input('parentescovisita');
        $visita->enderecovisita = $request->input('enderecovisita');
        $visita->ufvisita = $request->input('ufvisita');
        $visita->cidadevisita = $request->input('cidadevisita');
        $visita->telefonecontato = $request->input('telefonecontato');

        $visita->datanascimentovisita = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datanascimentovisita'))));
        $visita->dataemicaocarteirinha = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataemicaocarteirinha'))));


        // return $request->file('fotovisita');
        if($request->file('fotovisita'))
        {
            $fotovisita = $request->file('fotovisita');
            $extensao = $fotovisita->getClientOriginalExtension();
            if($extensao != 'jpg' && $extensao != 'JPG' && $extensao != 'jpeg' && $extensao != 'JPEG' && $extensao != 'png' && $extensao != 'PNG')
            {
                Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Este arquivo não é uma foto.");
                return redirect()->route('visitas.listarvisitantes');
                return redirect()->back();
            }
        }

        if($request->file('fotovisita')) {
            $nomefoto = sha1(microtime()).'.'.$extensao;
            File::copy($fotovisita, public_path().'/fotosVisitas/'.$nomefoto);
            $visita->fotovisita = 'fotosVisitas/'.$nomefoto;
        }else{
           // $visita->fotovisita = 'semfoto.png';
        }

        if($visita->save()) {
            Flash::success("Conteudo atualizado com sucesso.");
           // Logger::success('Diario academico Conteudo', 'Conteudo atualizado com sucesso');
            return redirect()->route('visitas.listarvisitantes');
            return redirect()->back();
        }
        else {
            Flash::error("Erro ao tentar atualizar conteudo..");
            return Redirect::route('visitas.listarvisitantes');
        }
    }



    public function cancelar(Request $request)
    {
        $idvisitaapenado = $request->input('visitaapen');

        $validator = validator($request->all(),
            [
                'datacancelamento'=>'required', 'motivo'=>'required'
            ]);
        if($validator->fails()){
            Flash::warning("Ops!! Todos os campos são obrigatórios");
            return redirect()->route('visitas.mostrarvisitantes', $request->input('apenado_id'));
        }

        $visitaApenM = new VisitasApenados();
        $cancela = $visitaApenM->find($idvisitaapenado);

        $cancela->datacancelamento = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datacancelamento'))));
        $cancela->motivo = $request->input('motivo');

        if($cancela->save()) {
            Flash::success("Conteudo atualizado com sucesso.");
            //Logger::success('Diario academico Conteudo', 'Conteudo atualizado com sucesso');
            return redirect()->route('visitas.mostrarvisitantes', $request->input('apenado_id'));
            return redirect()->back();
        }
        else {
            Flash::error("Erro ao tentar atualizar conteudo..");
            return Redirect::route('visitas.listarvisitantes');
        }

    }



    public function detalhavisitas($id)
    {
        try {
            $v['titulo'] = " VISITANTES";
            $v['subtitulo'] = " Detalha Visitados";

            $v['visita'] = DB::table('visitas as v')
                ->join('visitas_apenados as va', 'v.id','=','va.visita_id')
                //->join('apenados as p', 'p.id','=','va.apenado_id')
                ->Where('v.id','=', '' . $id . '')
                ->select('v.id as idVisita', 'v.*', 'va.id as idVisitaApenado', 'va.*')
                ->first();

            $v['apenados'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->join('visitas_apenados as va', 'a.id', '=', 'va.apenado_id')
                ->Where('va.id','=', '' . $id . '')
                ->Where('m.datasaida','=', NULL)
                ->select('a.*', 'u.nomeunidade', 'c.nomecela', 'p.numeroprocesso', 'p.artigos', 'p.tempodepena', 'va.datacancelamento', 'va.parentescovisita')
                ->get();



            return view('visitas.detalhavisitas', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }



}
