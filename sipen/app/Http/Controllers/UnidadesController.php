<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadesRequest;
use App\Model\Informacao;
use App\Model\Regioes;
use App\Model\Unidade;
use Illuminate\Http\Request;
use Flash;

class UnidadesController extends Controller
{

    private $unidadesModel;
    private $informacoesModel;
    public function __construct(Informacao $informacoesModel, Unidade $unidadesModel)
    {
        $this->unidadesModel = $unidadesModel ;
        $this->informacoesModel = $informacoesModel;
    }

    public function index(){
        $unidades = $this->unidadesModel->all();

        $titulo = " Unidades Prisionais";
        $subtitulo = "Relação de Unidades Cadastradas";
        return view('unidadesprisionais.index', compact('unidades', 'titulo', 'subtitulo'));
    }

    public function novo()
    {
        $v['titulo'] = " Unidades Prisionais";
        $v['subtitulo'] = " Novo Cadastro";
        $v['regioes'] = Regioes::get();
        return view('unidadesprisionais.novo', $v);
    }
    public function salvar(UnidadesRequest $request)
    {
        try {
            $v['titulo'] = " Unidades Prisionais";
            $v['subtitulo'] = " Relação de Unidades Cadastradas";
            $input = $request->all();
            $unidades = $this->unidadesModel->fill($input);
            $unidades->save();

            if($unidades){
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Unidade Prisional cadastrada com sucesso!");
                return redirect()->route('unidadesprisionais.index');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            // $e->getMessage();
             $this->$unidades->GetExeption($e);
            return redirect()->back();
        }
    }

    public function editar($id)
    {
        $v['titulo'] = " Unidades Prisionais";
        $v['subtitulo'] = " Editar Cadastro";

        $v['unidade'] = $this->unidadesModel->find($id);
        $v['regioes'] = Regioes::pluck('nomeregiao', 'id');

        return view('unidadesprisionais.editar', $v);
    }
    public function update(UnidadesRequest $request, $id)
    {
        try {

            $unidade = $this->unidadesModel->find($id);
            $unidade->update($request->all());

            if($unidade){
                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Unidade Prisional Alterada com sucesso!");
                return redirect()->route('unidadesprisionais.index');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // $e->getMessage();
            $this->$unidade->GetExeption($e);
            return redirect()->back();
        }
    }


}
