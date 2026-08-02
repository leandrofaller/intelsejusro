<?php

namespace App\Http\Controllers;

use App\Model\Apenado;
use App\Model\Temporaria;
use Illuminate\Http\Request;
use DB, Flash, Redirect, Logger, Auth;

class TemporariasController extends Controller
{

    protected $temporarias;
    public function __construct(Temporaria $temporaria)
    {
        $this->temporarias=$temporaria;
    }

    public function mostradados($id)
    {
        try {
            $v['titulo'] = " TEMPORÁRIAS";
            $v['subtitulo'] = " Controle de Permissão de Saída / Saída Temporária";

            $v['apenado'] = DB::table('apenados as a')
                ->join('processos as p', 'a.id','=','p.apenado_id')
                ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                ->join('unidades as u', 'm.unidade_id','=','u.id')
                ->join('celas as c', 'c.id', '=', 'm.cela_id')
                ->Where('a.id','=', '' . $id . '')
                ->Where('m.datasaida','=', NULL)
                ->select('a.*', 'm.id as idMovimentacao', 'm.unidade_id','m.cela_id', 'c.nomecela', 'u.nomeunidade', 'p.id as idProcesso')
                ->first();

            $v['temporarias'] = Temporaria::where('movimentacao_id', $v['apenado']->idMovimentacao)
                                    ->where('dataretorno', NULL)
                                    ->get();

            return view('temporarias.mostradados', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }
    }



    public function salvar(Request $request)
    {
        try {
            $v['titulo'] = " TEMPORÁRIAS";
            $v['subtitulo'] = " Controle de Permissão de Saída / Saída Temporária";

            $validator = validator($request->all(),
                [
                    'tipo'=>'required', 'motivo'=>'required', 'descricao'=>'required', 'datasaida'=>'required',
                    'horasaida'=>'required', 'documento'=>'required'
                ]);
            if($validator->fails()){
                Flash::warning("Ops!! Todos os campos são obrigatórios");
                return redirect()->route('temporarias.mostradados', $request->input('apenado_id') );
            }

            $input = $request->all();

            \DB::beginTransaction();

                $temporarias = $this->temporarias->fill($input);
                $temporarias->datasaida = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('datasaida'))));
                $temporarias->user_id = Auth::user()->id;
                $temporarias->push();

            \DB::commit();

            Flash::success("Temporária Registrada com Sucesso!");
            Logger::Success('Registrar Temporária ', 'Temporária - ');
            return redirect()->route('apenados.index');
            return redirect()->back();


        } catch (\Exception $e) {
            return  $e->getMessage();
            $this->$pad->GetExeption($e);
            Logger::error('Erro TEMPORÁRIA ','Erro na inclusão do TEMPORÁRIA - '.$e.' ');
            return redirect()->back();
        }
    }



    public function editar($id)
    {
        try {
            $v['titulo'] = " TEMPORÁRIAS";
            $v['subtitulo'] = " Edição";

            $v['temporaria'] = Temporaria::find($id);
            $v['apenado'] =  Apenado::find($v['temporaria']->apenado_id);

            return view('temporarias.editar', $v );

        } catch (\Exception $e) {
            return  $e->getMessage();
            Logger::error('Erro TEMPORÁRIA ','Erro na inclusão do TEMPORÁRIA - '.$e.' ');
            return redirect()->back();
        }
    }


    public function update(Request $request)
    {
        try {
            $id = $request->input('id_temporaria');

            $validator = validator($request->all(),
                [
                    'dataretorno' => 'required', 'horaretorno' => 'required', 'descricaoretorno' => 'required'
                ]);
            if ($validator->fails()) {
                Flash::warning("Ops!! Todos os campos são obrigatórios");
                redirect()->route('temporarias.editar', $id);
            }

            \DB::beginTransaction();

            $temporaria = $this->temporarias->find($id);
            $temporaria->dataretorno = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dataretorno'))));
            $temporaria->horaretorno = $request->input('horaretorno');
            $temporaria->descricaoretorno = $request->input('descricaoretorno');
            $temporaria->push();

            \DB::commit();

            Flash::success("Retorno Lançado com Sucesso.");
           return redirect()->route('listagem.temporarias', $temporaria->tipo);
            //  return redirect()->back();

        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$pad->GetExeption($e);
            Logger::error('Erro TEMPORÁRIA ', 'Erro na edição da TEMPORÁRIA - ' . $e . ' ');
            return redirect()->back();
        }
    }

}
