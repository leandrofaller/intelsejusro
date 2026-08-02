<?php

namespace App\Http\Controllers;

use App\Model\Regioes;
use Illuminate\Http\Request;
use Flash;

class RegioesController extends Controller
{
    private $regiao;
    public function __construct(Regioes $regiao)
    {
        $this->regiao = $regiao;
    }

    public function index(){
        $regioes = $this->regiao->all();

        $titulo = " REGIÃO";
        $subtitulo = "Listagem";
        return view('regiao.index', compact('regioes', 'titulo', 'subtitulo'));
    }

    public function novo()
    {
        $v['titulo'] = "REGIÃO";
        $v['subtitulo'] = " Novo Cadastro";
        return view('regiao.novo', $v);
    }
    public function salvar( Request $request)
    {
        try {
            $v['titulo'] = "REGIÃO";
            $v['subtitulo'] = " Relação Geral";
            $input = $request->all();
            $regiao = $this->regiao->fill($input);
            $regiao->status = 'A';
            $regiao->save();

            if($regiao){
                Flash::success("Regiao cadastrada com sucesso!");
                return redirect()->route('regioes.index');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            // $e->getMessage();
            $this->$regiao->GetExeption($e);
            return redirect()->back();
        }
    }

    public function editar($id)
    {
        $titulo = " REGIÃO";
        $subtitulo = " Editar Cadastro";
        $regiao = $this->regiao->find($id);
        return view('regiao.editar', compact('regiao' ,'titulo', 'subtitulo'));
    }
    public function update(Request $request, $id)
    {
        try {

            $regiao = $this->regiao->find($id);
          //  $regiao->status = 'A';
            $regiao->update($request->all());



            if($regiao){
                Flash::success("Região Alterada com sucesso!");
                return redirect()->route('regioes.index');
                return redirect()->back();
            }
        } catch (\Exception $e) {
             $e->getMessage();
            $this->$regiao->GetExeption($e);
            return redirect()->back();
        }
    }


}
