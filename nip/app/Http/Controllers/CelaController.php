<?php

namespace App\Http\Controllers;

use App\Http\Requests\CelaRequest;
use App\Model\Carceragem;
use App\Model\Cela;
use Illuminate\Http\Request;
use DB;
use Flash;
use App\Model\Logger;


class CelaController extends Controller
{
    protected $carceragemModel;
    protected $celaModel;
    public function __construct(Cela $celaModel, Carceragem $carceragemModel)
    {
        $this->celaModel=$celaModel;
        $this->carceragemModel=$carceragemModel;
    }

    public function index(Request $request, $idCarceragem)
    {
        try {
        $v['titulo'] = " Celas";
        $v['subtitulo'] = " Relação de celas cadastradas para a Carceragem da Unidade Prisional";

        $v['idCarceragem'] = $idCarceragem;
        $v['celas'] = $this->celaModel->where('carceragem_id', $idCarceragem)->orderby('nomecela','ASC')->get();
        $v['carceragem'] = $this->carceragemModel->find($idCarceragem);
            return view('celas.index', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back();
        }

    }

    public function novo($idCarceragem)
    {
        $v['titulo'] = " Celas";
        $v['subtitulo'] = " Nova Cela";

        $v['carceragem'] = $this->carceragemModel->find($idCarceragem);
        $v['idCarceragem'] = $idCarceragem;
        return view('celas.novo', $v);
    }
    public function salvar(CelaRequest $request)
    {
        try {

            $input = $request->all();

            $cela = $this->celaModel->fill($input);
            $cela->status = 'Ativo';
            $cela->save();
            $v['idCarceragem'] = $request->input('carceragem_id');

            if($cela){
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Salvo com sucesso!");
                return redirect()->route('celas.index', $v);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$cela->GetExeption($e);
            return redirect()->back();
        }

    }



    public function editar(Carceragem $carceragem, $id, $idCarceragem)
    {
        $v['titulo'] = " Celas";
        $v['subtitulo'] = " Editar Cela";

        $v['idCarceragem'] = $idCarceragem;
        $v['cela'] = $this->celaModel->find($id);
        return view('celas.editar', $v );
    }


    public function update(CelaRequest $request, $id, $idCarceragem)
    {
        try {

            $v['idCarceragem'] = $idCarceragem;
            $cela = $this->celaModel->find($id);
            $cela->update($request->all());

            if($cela){
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Alterado com sucesso!");
                return redirect()->route('celas.index', $v);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$cela->GetExeption($e);
            return redirect()->back();
        }
    }

    public function selectCelas($idCarc)
    {
        try
        {
            return $this->celaModel->orderby('nomecela','asc')->where('carceragem_id',$idCarc)->get();
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }


    public function destroy(Request $request, $id, $idCarceragem)
    {
        try
        {
            $v['idCarceragem'] = $idCarceragem;
            $this->celaModel->where('id',$id)->delete();
            Flash::success("Cela Excluida com Sucesso.");
            return redirect()->route('celas.index', $v);
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Celas destroy', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }


}
