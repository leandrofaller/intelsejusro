<?php

namespace App\Http\Controllers;

use App\Model\Anexo;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use File;
use Flash;
use App\Model\Logger;

class AnexosController extends Controller
{

   private $anexoModel;
    public function __construct(Anexo $anexoModel)
    {
        $this->anexoModel = $anexoModel;
    }

    public function index(Request $request, $id)
    {
        $v['id'] = $id;
        $v['titulo'] = " ANEXAR DOCUMENTOS";
        $v['subtitulo'] = " Documentos Digitalizados dos Apenados";
        $v['apenado'] = DB::table('apenados as a')
            ->join('processos as p', 'a.id','=','p.apenado_id')
            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
            ->join('unidades as u', 'm.unidade_id','=','u.id')
            ->join('celas as c', 'c.id', '=', 'm.cela_id')
            ->Where('a.id','=', '' . $id . '')
            ->Where('m.datasaida','=', NULL)
            ->select('a.*', 'p.id as idProcesso', 'm.id as idMovimentacao', 'm.unidade_id','m.cela_id', 'c.nomecela', 'u.nomeunidade')
            ->first();

        $v['anexos'] = DB::table('anexos as an')
            ->join('apenados as a', 'an.apenado_id', '=', 'a.id')
            ->Where('an.apenado_id','=', '' . $id . '' )
            ->Where('an.tipodocumento', '=', 'CADASTRO')
            ->select('an.*')
            ->orderby('an.id', 'desc')
            ->paginate(20);

        return view('anexos.index', $v);
    }

    public function gravar(Request $request)
    {
        try {
            $v['titulo'] = " ANEXAR DOCUMENTOS";
            $v['subtitulo'] = " Documentos Digitalizados dos Apenados";

            $idApen = $request->input('idapenid');
            $idProcesso = $request->input('idprocessoid');

            $validator = validator($request->all(),
                [ 'titulo'=>'required', 'foto'=>'required' ]);
            if($validator->fails()){
                Flash::warning("Ops!! Todos os campos são obrigatórios");
                return redirect()->route('anexos.index', $idApen);
            }

            //INSERE A FOTO
            // return $request->file('foto');
            if($request->file('foto'))
            {
                $foto = $request->file('foto');
                $extensao = $foto->getClientOriginalExtension();
                if($extensao == 'exe')
                {
                    Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Este arquivo não é uma foto.");
                    return redirect()->route('anexos.index', $idApen);
                    return redirect()->back();
                }
            }

            $input = $request->all();
            $anexo = $this->anexoModel->fill($input);
            $anexo->titulo = $request->input('titulo');
            $anexo->tipodocumento = 'CADASTRO'; //FACCAO OU CADASTRO
            $anexo->user_id = Auth::user()->id;
            $anexo->processo_id = $idProcesso;
            $anexo->apenado_id = $idApen;
            $anexo->integrante_id = '';
            $anexo->datalancamento = date("Y-m-d");

            $nome = sha1(microtime()).'.'.$extensao;
            File::copy($foto, public_path().'/documentos_Apenado/'.$nome);
            $anexo->nomearquivo = 'documentos_Apenado/'.$nome;

            if ($anexo->save()) {

                Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Documento Enviado com Sucesso!");
                Logger::Success('Cadastro de Anexo/Documento - APENADO', 'Inserido Documento APENADO - ' . $idApen . ' ');
                return redirect()->route('anexos.index', $idApen);
                return redirect()->back();

            } else {
                Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Houve um Erro na VIsita.");
                return redirect()->route('anexos.index', $idApen);
                return redirect()->back();
            }

        } catch (\Exception $e) {
            return  $e->getMessage();
            $this->$anexo->GetExeption($e);
            Logger::error('Anexar Documento APENADO','Erro na inclusão da Documento APENADO - '.$e.' ');
            return redirect()->back();
        }

    }

    public function destroy($id, $idApen)
    {
        try
        {
            $this->anexoModel->where('id',$id)->delete();
            Flash::success("Anexo Excluido com Sucesso.");
            return redirect()->route('anexos.index', $idApen);
        }
        catch (\Exception $e) {
            $e->getMessage();
            Logger::exception('Anexo destroy', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }
    }


}
