<?php

namespace App\Http\Controllers;

use App\Model\CargosFaccao;
use App\Model\Faccao;
use Illuminate\Http\Request;
use Flash;
use App\Model\Logger;

class CargosFaccaoController extends Controller
{
    protected $faccaoModel;
    protected $cargosFaccaoModel;
    public function __construct(Faccao $faccaoModel, CargosFaccao $cargosFaccaoModel)
    {
        $this->faccaoModel=$faccaoModel;
        $this->cargosFaccaoModel = $cargosFaccaoModel;
    }

    public function index()
    {
        $v['titulo'] = " CARGOS DE FACÇÕES";
        $v['subtitulo'] = " Cargos de Facções Cadastradas";
        $v['cargos'] = $this->cargosFaccaoModel->all();
        return view('faccaocargo.index', $v);
    }

    public function novo()
    {
        $v['titulo'] = " CARGOS DE FACÇÕES";
        $v['subtitulo'] = " Novo Cadastro";
        $v['faccoes'] = $this->faccaoModel->pluck('nomefaccao','id');

        return view('faccaocargo.novo', $v);
    }

    public function salvar(Request $request)
    {
        try {

            $validator = validator($request->all(),
                [
                    'nomecargo'=>'required', 'descricao'=>'required', 'nivel'=>'required',
                    'faccao_id'=>'required'
                ]);
            if($validator->fails()){
                return redirect()->route('faccaocargo.novo')->withInput()->withErrors($validator);
            }

            $input = $request->all();
            $cargo = $this->cargosFaccaoModel->fill($input);
            $cargo->save();

            if($cargo){
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Salvo com sucesso!");
                return redirect()->route('faccaocargo.index');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$cargo->GetExeption($e);
            return redirect()->back();
        }

    }

    public function editar(Request $request, $id)
    {
        $v['titulo'] = " CARGOS DE FACÇÕES";
        $v['subtitulo'] = " Editar Cargo";

        $v['cargo'] = $this->cargosFaccaoModel->find($id);
        $v['faccoes'] = $this->faccaoModel->pluck('nomefaccao','id');
        return view('faccaocargo.editar', $v );
    }


    public function update(Request $request, $id)
    {
        try {

            $validator = validator($request->all(),
                [
                    'nomecargo'=>'required', 'descricao'=>'required', 'nivel'=>'required',
                    'faccao_id'=>'required'
                ]);
            if($validator->fails()){
                return redirect()->route('faccaocargo.editar', $id)->withInput()->withErrors($validator);
            }

            $cargo = $this->cargosFaccaoModel->find($id);
            $cargo->update($request->all());

            if($cargo){
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Alterado com sucesso!");
                return redirect()->route('faccaocargo.index');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$cargo->GetExeption($e);
            return redirect()->back();
        }
    }


    public function selectCargos($idFac)
    {
        try
        {
            return $this->cargosFaccaoModel->orderby('nomecargo','asc')->where('faccao_id',$idFac)->get();
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }

}
