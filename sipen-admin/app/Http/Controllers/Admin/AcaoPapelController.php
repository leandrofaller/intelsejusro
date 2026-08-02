<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\App;
use App\Models\Admin\AppAction;
use App\Models\Admin\AppRole;
use Illuminate\Http\Request;
use App\Models\Admin\AppActionRole;
use Redirect, Flash, Logger, DB;

class AcaoPapelController extends Controller
{
    public function __construct(AppActionRole $acaopapel,App $sistema, AppRole $papel, AppAction $acao)
    {
        $this->acaopapel = $acaopapel;
        $this->papel = $papel;
        $this->sistema = $sistema;
        $this->acao = $acao;
    }

    public function index(Request $request)
    {
        try
        {
            $v['title'] = 'Ações do Papel';
            $v['papeis'] = $this->papel->orderBy('name');

            if ($request->has('q')) {
                //Parametro para consulta
                $query = strtolower('%'. $request->input('q') .'%');
                //Consulta
                $v['papeis'] = $v['papeis']
                    ->where(DB::raw('LOWER(app_role.name)'), 'LIKE', $query);
            }

            $v['papeis'] = $v['papeis']->select('app_role.*')->paginate(20);

            return View('admin.acoesPapel.index', $v);
        } catch (\Exception $e) {
            Logger::exception('Papeis Edit', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return Redirect::route('acaopapel.index');
        }
    }

     public function create($idPapel)
      {
          try
          {
              $v['title'] = 'Associar Ações ao Papel';
              $v['sistemas'] = $this->sistema->pluck('name', 'id');
              $v['papel'] = $this->papel->findOrFail($idPapel);

              $acoes = $this->acao;
              $acoesAssociadas = $v['papel']->acoes->pluck('app_action_id');
              if (count($acoesAssociadas) > 0) {
                  $acoes = $acoes->whereNotIn('id', $acoesAssociadas);
              }
              $acoes = $acoes->whereAppId($v['papel']->app_id)
                  ->groupBy('id', 'title', 'route')
                  ->orderBy('title')
                  ->select(DB::raw("CONCAT(app_action.title,' - ', app_action.route) AS title, app_action.id"))
                  // ->select(DB::raw("app_action.title || ' (' || app_action.route || ')' AS title"), 'app_action.id')
                  ->pluck('title', 'id');

              //$acoes[0] = 'Selecione uma ação';
              $v['acoes'] = $acoes;
              return View('admin.acoesPapel.create', $v);
          }
          catch (\Exception $e) {
              Logger::exception('Papeis Edit', $e);
              Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
              return Redirect::route('acaopapel.index');
          }
      }

    public function store(Request $request)
    {
        try {
            if ($request->get('app_action_id') == 0 || $request->get('app_action_id') == '') {
                Flash::warning("Ops, nenhuma ação para associar.");
                return redirect()->back();
            }

            $acoes = $request->get('app_action_id');
            foreach ($acoes as $acoe) {
                $acaopapel = new AppActionRole;
                $acaopapel->app_role_id = $request->get('app_role_id');
                $acaopapel->app_action_id = $acoe;
                $acaopapel->save();
            }
            Flash::success("Ação Associada com sucesso.");
            return redirect()->back();
        } catch (\Exception $e) {
            Logger::exception('AçõesPapeis Edit', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }


    }

    public function destroy(Request $request, $id)
    {
        try
        {
            $app_role_id = $request->get('app_role_id');
            $this->acaopapel->where('id',$id)->delete();
            Flash::success("Associação removida do papel com sucesso.");
            return Redirect::route('acaopapel.create', $app_role_id);
        }
        catch (\Exception $e) {
            return $e->getMessage();
            Logger::exception('AçõesPapeis destroy', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return redirect()->back();
        }


    }
}
