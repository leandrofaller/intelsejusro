<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarceragemRequest;
use App\Http\Requests\UnidadesRequest;
use App\Model\Carceragem;
use App\Model\Cela;
use App\Model\Faccao;
use App\Model\Unidade;
use Illuminate\Http\Request;
use DB;
use Flash;

class CarceragemController extends Controller
{
    protected $carceragemModel;
    protected $unidadeModel;
    public function __construct(Carceragem $carceragemModel, Unidade $unidadeModel, Faccao $faccaoModel)
    {
        $this->carceragemModel=$carceragemModel;
        $this->unidadeModel=$unidadeModel;
        $this->faccaoModel=$faccaoModel;
    }

    public function index(Request $request, $idUnidade)
    {
        try {
            $v['titulo'] = " Carceragens";
            $v['subtitulo'] = " Relação de Carceragens cadastradas para a Unidade Prisional";

            $v['idUnidade'] = $idUnidade;
            $v['carceragens'] = $this->carceragemModel->where('unidade_id', $idUnidade)->orderby('nomecarceragem','ASC')->get();

            $v['unidade'] = $this->unidadeModel->find($idUnidade);


            return view('carceragens.index', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            //$this->auxiliar->GetExeption($e);
            return redirect()->back();
        }

    }



    public function novo($idUnidade)
    {
        $v['titulo'] = " Carceragens";
        $v['subtitulo'] = " Nova Carceragem";

        $v['faccoes'] = $this->faccaoModel->pluck('sigla', 'id');
        $v['faccoes'][0] = 'Nenhum';

        $v['unidade'] = $this->unidadeModel->find($idUnidade);
//        $v['unidade'] = $this->unidadeModel->where('recebeapenados', 'Sim')->orderBy('nomeunidade')->get();

        $v['idUnidade'] = $idUnidade;
        return view('carceragens.novo', $v);
    }

    public function salvar(CarceragemRequest $request)
    {

        try {
            $input = $request->all();
            $carc = $this->carceragemModel->fill($input);
            $carc->status = 'Ativo';
            $carc->save();
            $v['idUnidade'] = $request->input('unidade_id');
            if($carc){
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Salvo com sucesso!");
                return redirect()->route('carceragens.index', $v);
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$carc->GetExeption($e);
            return redirect()->back();
        }

    }



    public function editar(Unidade $unidade, $id, $idUnidade)
    {
        $v['titulo'] = " Carceragens";
        $v['subtitulo'] = " Editar Carceragem";

        $v['faccoes'] = $this->faccaoModel->pluck('sigla', 'id');
        $v['faccoes'][0] = 'Nenhum';
        $v['unidade'] = $this->unidadeModel->where('recebeapenados', 'Sim')->pluck('nomeunidade', 'id');
        $v['carceragem'] = $this->carceragemModel->find($id);

        $v['idUnidade'] = $idUnidade;

        return view('carceragens.editar', $v);

    }


  public function update(CarceragemRequest $request, $id, $idUnidade)
    {
        try {
            $v['idUnidade'] = $idUnidade;
            $car = $this->carceragemModel->find($id);
            $car->update($request->all());

            if($car){
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Alterado com sucesso!");
                return redirect()->route('carceragens.index', $v);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$car->GetExeption($e);
            return redirect()->back();
        }
    }



    public function selectCarceragem($idUnid)
    {
        try
        {
            return $this->carceragemModel->orderby('nomecarceragem','asc')->where('unidade_id',$idUnid)->get();
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }




}
