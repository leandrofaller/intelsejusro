<?php

namespace App\Http\Controllers;

use App\Model\Apenado;
use App\Model\Fuga;
use App\Model\Movimentacao;
use App\Model\Unidade;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Flash;
use App\Model\Logger;

class ForagidosController extends Controller
{
    public function __construct(Apenado $apenModel, Unidade $unidadeModel, Fuga $fugaModel, Movimentacao $movimentacaoModel)
    {
        $this->apenModel = $apenModel;
        $this->unidadeModel = $unidadeModel;
        $this->fugaModel = $fugaModel;
        $this->movimentacaoModel = $movimentacaoModel;
    }


    public function index()
    {
        try {
            $v['titulo'] = " FORAGIDOS DO SISTEMA PRISIONAL";
            $v['subtitulo'] = "Apenado Foragidos";

            $v['apenados'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('fugas as f', 'f.movimentacao_id', '=', 'm.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->join('celas as c', 'm.cela_id', '=', 'c.id')
                ->Where('m.datasaida', '=', NULL)
                ->Where('f.datarecaptura', '=', NULL)
                ->select('a.*', 'f.datafuga', 'u.nomeunidade', 'c.nomecela', 'f.tipo' )
                ->paginate(10);

            return view('foragidos.index', $v);
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }


    public function recaptura($idApen)
    {
        try {
            $v['titulo'] = " FORAGIDOS DO SISTEMA PRISIONAL";
            $v['subtitulo'] = " Recaptura de Apenado";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id', '=', 'p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
                ->join('fugas as f', 'f.movimentacao_id', '=', 'm.id')
                ->join('unidades as u', 'm.unidade_id', '=', 'u.id')
                ->join('celas as c', 'm.cela_id', '=', 'c.id')
                ->Where('m.datasaida', '=', NULL)
                ->Where('f.datarecaptura', '=', NULL)
                ->Where('a.id', '=', '' . $idApen . '')
                ->select('a.id as idApen', 'a.*', 'p.id as idProcesso', 'p.*', 'm.id as idMovimentacao', 'm.*', 'c.nomecela', 'u.nomeunidade', 'f.datafuga', 'f.id as idFuga')
                ->first();

            $perfil = Auth::user()->perfil;
            $idUnid = Auth::user()->unidade_id;

            if ($perfil == 'Admin') {
               // $v['unidades'] = $this->unidadeModel->all();
                $v['unidades'] = $this->unidadeModel->where('recebeapenados', 'Sim')->orderBy('nomeunidade')->get();
            } else {
               // $v['unidades'] = $this->unidadeModel->where('id', $idUnid)->get();
                $v['unidades'] = $this->unidadeModel->where('recebeapenados', 'Sim')->where('id', $idUnid)->orderBy('nomeunidade')->get();
            }

            return view('foragidos.recaptura', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }

    public function recapturaSalvar(Request $request, $id)
    {
        try {

//                if ($request->input('unidade_preso') == $request->input('unidade_id'))
//                {
//                    $validator = validator($request->all(),
//                        [ 'cela_id'=>'required', 'dataentrada'=>'required', 'oficioentrada'=>'required',
//                            'descricaorecaptura'=>'required' ]);
//                    if($validator->fails()){
//                        Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Todas os Campos são Obrigatórios.");
//                        return redirect()->route('foragidos.recaptura', $id)->withInput();
//                    }
//
//                    //BAIXA NA TABELA DE FUGAS
//                    $fuga = $this->fugaModel->find($request->input('idFuga'));
//                    $fuga->datarecaptura = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataentrada'))));
//                    $fuga->descricaorecaptura = $request->input('descricaorecaptura');
//                    $fuga->update();
//
//                    if($fuga) {
//
//                        //se a recaptura do preso estiver sendo dado entrada para a mesma unidade de origem da epoca da fuga
//                        // efetua baixa na fuga
//                        // retira o sinistro do motivosaida e atualiza cela.
//                        $mov = $this->movimentacaoModel->find($request->input('idMovimentacao'));
//
//                        $mov->motivosaida = NULL;
//                        $mov->cela_id = $request->input('cela_id');
//                        if ($mov->update()) {
//                            Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Recaptura Lançada com Sucesso.!");
//                            Logger::info('Recaptura de Apenado', 'Lançado com Sucesso Sem Mudança de Unidade -> Recaptura Apenado ' . $id . ' - ' . $request->input('nomeapenadoc'));
//                            return redirect()->route('foragidos.index');
//                            return redirect()->back();
//                        }
//                    }
//                }else{

                    $validator = validator($request->all(),
                        [ 'cela_id'=>'required', 'dataentrada'=>'required', 'oficioentrada'=>'required',
                            'descricaorecaptura'=>'required', 'regime'=>'required', 'monitorado'=>'required',
                            'presooriundo'=>'required', 'situacao'=>'required'
                        ]);
                    if($validator->fails()){
                        Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Todas os Campos são Obrigatórios.");
                        return redirect()->route('foragidos.recaptura', $id)->withInput();
                    }

                    //BAIXA NA TABELA DE FUGAS
                    $fuga = $this->fugaModel->find($request->input('idFuga'));
                    $fuga->datarecaptura = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataentrada'))));
                    $fuga->descricaorecaptura = $request->input('descricaorecaptura');
                    $fuga->update();

                        if($fuga) {
                            //se a entrada for para outra unidade, dar baixa na movimentação anterior e criar uma nova
                            //com os dados da nova unidade
                            $mov = $this->movimentacaoModel->find($request->input('idMovimentacao'));
                            $mov->datasaida = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataentrada'))));
                            $mov->oficiosaida = $request->input('oficioentrada');
                            $mov->motivosaida = 'Recapturado';
                            $mov->unidadedestino = $request->input('unidade_id'); //unidade de destino
                            $mov->update();

                            if ($mov) {

                                //REALIZA A NOVA INSERÇÃO EM MOVIMENTAÇÃO POR CAUSA DO RECEBIMENTO DO PRESO EM UNI. DIFERENTE
                                //INICIA A INSERÇÃO DO MOVIMENTAÇÃO
                                $movimentacao = new Movimentacao();
                                $movimentacao->regime = $request->input('regime');
                                $movimentacao->dataentrada = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataentrada'))));
                                $movimentacao->oficioentrada = $request->input('oficioentrada');
                                $movimentacao->presooriundo = $request->input('presooriundo');
                                $movimentacao->situacao = $request->input('situacao');
                                $movimentacao->monitorado = $request->input('monitorado');
                                $movimentacao->processo_id = $request->input('idProcesso');
                                $movimentacao->unidadeorigem = $mov->unidade_id; //unidade de origem
                                $movimentacao->unidade_id = $request->input('unidade_id');
                                $movimentacao->cela_id = $request->input('cela_id');

                                if ($movimentacao->save()) {
                                    Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Recaptura Lançada com Sucesso.");
                                    Logger::info('Recaptura de Apenado', 'Lançado com Sucesso -> Recaptura Com Mudança de Unidade : Apenado ' . $id . ' - ' . $request->input('nomeapenadoc'));
                                    return redirect()->route('foragidos.index');
                                    return redirect()->back();
                                }

                            }
                        }
             //   }



        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }

    }


}
