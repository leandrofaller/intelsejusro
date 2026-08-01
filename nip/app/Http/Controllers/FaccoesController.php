<?php

namespace App\Http\Controllers;

use App\Model\Faccao;
use Illuminate\Http\Request;
use Flash;
use App\Model\Logger;


class FaccoesController extends Controller
{

    protected $faccaoModel;
    public function __construct(Faccao $faccaoModel)
    {
        $this->faccaoModel=$faccaoModel;
    }

    public function index()
    {
        $v['titulo'] = " FACÇÕES";
        $v['subtitulo'] = " Facções Cadastradas";
         $v['faccoes'] = $this->faccaoModel->all();
        return view('faccaocadastro.index', $v);
    }

    public function novo()
    {
        $v['titulo'] = " FACÇÕES";
        $v['subtitulo'] = " Novo Cadastro";
        return view('faccaocadastro.novo', $v);
    }

    public function salvar(Request $request)
    {
        try {

            $validator = validator($request->all(),
                [
                    'nomefaccao'=>'required', 'sigla'=>'required', 'anofundacao'=>'required',
                    'origem'=>'required', 'historico'=>'required'
                ]);
            if($validator->fails()){
                return redirect()->route('faccaocadastro.novo')->withInput()->withErrors($validator);
            }

            $input = $request->all();
            $faccao = $this->faccaoModel->fill($input);
            $faccao->save();

            if($faccao){
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Salvo com sucesso!");
                return redirect()->route('faccaocadastro.index');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$cela->GetExeption($e);
            return redirect()->back();
        }

    }

    public function editar(Request $request, $id)
    {
        $v['titulo'] = " FACÇÕES";
        $v['subtitulo'] = " Editar Facção";
        $v['faccao'] = $this->faccaoModel->find($id);
        return view('faccaocadastro.editar', $v );
    }



    public function update(Request $request, $id)
    {
        try {

            $validator = validator($request->all(),
                [
                    'nomefaccao'=>'required', 'sigla'=>'required', 'anofundacao'=>'required',
                    'origem'=>'required', 'historico'=>'required'
                ]);
            if($validator->fails()){
                return redirect()->route('faccaocadastro.editar', $id)->withInput()->withErrors($validator);
            }

            $faccao = $this->faccaoModel->find($id);
            $faccao->update($request->all());

            if($faccao){
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Alterado com sucesso!");
                return redirect()->route('faccaocadastro.index');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            $this->$cela->GetExeption($e);
            return redirect()->back();
        }
    }
}
