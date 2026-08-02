<?php

namespace App\Http\Controllers;

use App\Model\GaleriaCategoria;
use App\Model\Galerias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File, Flash, DB;
use App\Model\Logger;

class GaleriaController extends Controller
{
    private $galeriaModel;
    public function __construct(Galerias  $galeriaModel)
    {
        $this->galeriaModel = $galeriaModel;
    }

    public function galerias(Request $request)
    {
        $v['titulo'] = "GALERIA DE FOTOS";
        $v['subtitulo'] = "ARQUIVO VIRTUAL DE FOTOS DO SISTEMA PRISIONAL";

        $v['anexospublicos'] = Galerias::where('publico', 'PÚBLICO')->orderby('created_at', 'desc')->get();
        $v['anexosprivados'] = Galerias::where('publico', 'SIGILOSO')->where('fk_user', Auth::user()->id)->orderby('created_at', 'desc')->get();

        $v['servidores'] = DB::table('galerias as g')
                ->join('users as u', 'g.fk_user', '=', 'u.id')
                ->groupby('u.id')
                ->orderby('u.nome', 'asc')
                ->pluck('u.nome', 'u.id');
        $v['servidores'][0] = '';

        $v['categorias'] = GaleriaCategoria::pluck('nome', 'id');
        $v['categorias'][0] = '';

        $v['exibe'] = true;
        $v['exibesigilo'] = true;

        if ((empty(!$request->input('categoria'))) && (empty(!$request->input('parametro'))) && (empty(!$request->input('servidor'))) )
        {
           // return 'AMBOS';
            $v['exibe'] = true;
            $v['exibesigilo'] = false;

            $v['anexos'] = Galerias::where('fk_categoria', $request->input('categoria'))
                ->Where('titulo', 'LIKE', '%' . $request->input('parametro') . '%')
                ->orWhere('descricao', 'LIKE', '%' . $request->input('parametro') . '%')
                ->orWhere('fk_user', $request->input('servidor') )
                ->where('publico', 'PÚBLICO')
                ->get();
        }
        if ((!empty($request->input('categoria'))) && (empty($request->input('parametro'))) && (empty($request->input('servidor'))) )
        {
            // return 'SÓ CATEGORIA';
            $v['exibe'] = true;
            $v['exibesigilo'] = false;
            $v['anexos'] = Galerias::where('fk_categoria', $request->input('categoria'))
                ->where('publico', 'PÚBLICO')
                ->get();
        }

        if ((empty($request->input('categoria'))) && (!empty($request->input('parametro'))) && (empty($request->input('servidor'))) )
        {
             // return 'SÓ PARAMETRO';
            $v['exibe'] = true;
            $v['exibesigilo'] = false;
            $v['anexos'] = Galerias::Where('titulo', 'LIKE', '%' . $request->input('parametro') . '%')
                ->orWhere('descricao', 'LIKE', '%' . $request->input('parametro') . '%')
                ->where('publico', 'PÚBLICO')
                ->get();
        }
        if ((empty($request->input('categoria'))) && (empty($request->input('parametro'))) && (!empty($request->input('servidor'))) )
        {
         //    return 'SÓ SERVIDOR';
            $v['exibe'] = true;
            $v['exibesigilo'] = false;
            $v['anexos'] = Galerias::Where('fk_user', $request->input('servidor'))
                ->where('publico', 'PÚBLICO')
                ->get();
        }
        if ((!empty($request->input('categoria'))) && (empty($request->input('parametro'))) && (!empty($request->input('servidor'))) )
        {
         //   return 'SÓ CATEGORIA E SERVIDOR';
            $v['exibe'] = true;
            $v['exibesigilo'] = false;
            $v['anexos'] = Galerias::Where('fk_user', $request->input('servidor'))
                ->where('fk_categoria', $request->input('categoria'))
                ->where('publico', 'PÚBLICO')
                ->get();
        }

        if ((!empty($request->input('categoria'))) && (empty($request->input('parametro'))) && (!empty($request->input('servidor'))) )
        {
           // return 'SÓ parametro E SERVIDOR';
            $v['exibe'] = true;
            $v['exibesigilo'] = false;
            $v['anexos'] = Galerias::Where('fk_user', $request->input('servidor'))
                ->Where('titulo', 'LIKE', '%' . $request->input('parametro') . '%')
                ->orWhere('descricao', 'LIKE', '%' . $request->input('parametro') . '%')
                ->where('publico', 'PÚBLICO')
                ->get();
        }
        return view('galerias.galeria', $v);
    }

    public function novo(Request $request)
    {
        $v['titulo'] = "INCLUIR FOTOS";
        $v['subtitulo'] = "";

        $v['categorias'] = GaleriaCategoria::pluck('nome', 'id');

        return view('galerias.novo', $v);
    }





    public function salvar(Request $request)
    {
        try {
            $v['titulo'] = "INCLUIR FOTOS";
            $v['subtitulo'] = "";

            $categoria = $request->input('categoria');
            $titulo = $request->input('titulo');
            $descricao = $request->input('descricao');
            $restricao = $request->input('restricao');

            $validator = validator($request->all(),
                [ 'categoria'=>'required', 'imagem'=>'required', 'restricao'=>'required' ]);
            if($validator->fails()){
                Flash::warning("Ops!! Todos os campos são obrigatórios");
                return redirect()->route('galerias.novo');
            }

            //INSERE A FOTO
            // return $request->file('foto');
            if($request->file('imagem'))
            {
                $foto = $request->file('imagem');
                $extensao = $foto->getClientOriginalExtension();
                if($extensao == 'exe')
                {
                    Flash::warning("Oops! Este arquivo não é permitido.");
                    return redirect()->back();
                }
            }

            $input = $request->all();
            $anexo = $this->galeriaModel->fill($input);
            $anexo->titulo = $titulo;
            $anexo->descricao = $descricao;
            $anexo->publico = $restricao;
            $anexo->fk_categoria = $categoria;
            $anexo->fk_user = Auth::user()->id;

            $nome = sha1(microtime()).'.'.$extensao;
            File::copy($foto, public_path().'/imgGalerias/'.$nome);
            $anexo->imagem = 'imgGalerias/'.$nome;

            if ($anexo->save()) {

                Flash::success("Foto Enviada com Sucesso!");
                return redirect()->back();

            } else {
                Flash::warning("Oops! Houve um Erro na VIsita.");
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return  $e->getMessage();
            $this->$anexo->GetExeption($e);
            Logger::error('','Erro na inclusão da GALERIA - '.$e.' ');
            return redirect()->back();
        }

    }

    public function excluir($id)
    {
        try
        {
            $this->galeriaModel->where('id',$id)->delete();
            Flash::success("Arquivo Excluido com Sucesso.");
            return redirect()->back();
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Anexo destroy', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }


}
