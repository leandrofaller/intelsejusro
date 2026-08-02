<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\App;
use App\Models\Admin\AppActionRole;
use App\Models\Admin\AppRole;
use App\Models\Admin\AppAction;
use App\Models\Admin\AppRoleUser;
use DB, View, Redirect,Flash,Logger;

use Illuminate\Http\Request;

class PapeisController extends Controller
{
    public function __construct(App $sistema, AppRole $papel, AppAction $acao,AppActionRole $actionRole,AppRoleUser $appRoleUser)
    {
        $this->papel = $papel;
        $this->sistema = $sistema;
        $this->acao = $acao;
        $this->app_action_role = $actionRole;
        $this->app_role_user = $appRoleUser;
    }

    public function index(Request $request)
    {
        try {
            $v['title'] = 'Papéis de usuários';
            $v['papeis'] = $this->papel->orderBy('name');
            $v['sistemas'] = $this->sistema->pluck('name', 'id');
            $v['sistemas'][0] = 'Selecione um sistema';
            if ($request->has('q')) {
                //Parametro para consulta
                $query = strtolower('%'. $request->input('q') .'%');
                //Consulta
                $v['papeis'] = $v['papeis']->JOIN('app', 'app_role.app_id', '=', 'app.id')
                    ->where(DB::raw('LOWER(app_role.name)'), 'LIKE', $query)
                    ->orWhere(DB::raw('LOWER(app.name)'), 'LIKE', $query);
            }

            $v['papeis'] = $v['papeis']->select('app_role.*')->paginate(20);


            return View('admin.papeis.index', $v);
        } catch (\Exception $e) {
            Logger::exception('Papeis Index', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return Redirect::route('papeis.index');
        }

    }

    public function create()
    {
        try {
            $v['title'] = 'Cadastrar Papel';
            $v['sistemas'] = $this->sistema->pluck('name', 'id');
            return View('admin.papeis.create', $v);
        } catch (\Exception $e)
        {
            Logger::exception('Papeis Create', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return Redirect::route('papeis.index');
        }


    }

    public function store(Request $request)
    {

        try {

            $validator = validator($request->all(),
                ['name'=>'required', 'app_id'=>'required','active'=>'required']);
            if($validator->fails()){
                return redirect()->route('papeis.create')->withInput()->withErrors($validator);
            }

            $this->papel->create($request->all());
            Flash::success("Papel cadastrado com sucesso.");
            return Redirect::route('papeis.index');

        }
        catch (\Exception $e)
        {
            Logger::exception('Papeis Store', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return Redirect::route('papeis.index');
        }

    }

    public function edit($id)
    {
        try
        {
            $v['title'] = 'Editar Papel';
            $v['sistemas'] = $this->sistema->pluck('name', 'id');
            $v['papel'] = $this->papel->findOrFail($id);

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
            return View('admin.papeis.edit', $v);
        }
        catch (\Exception $e) {
            Logger::exception('Papeis Edit', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return Redirect::route('papeis.index');
        }

    }

    public function update($id, Request $request)
    {
        try {
            $papel = $this->papel->findOrFail($id);
            $papel->update($request->all());
            Flash::success("Papel editado com sucesso.");
            return Redirect::route('papeis.edit', $id);

        } catch (\Exception $e)
        {
            Logger::exception('Papeis Update', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return Redirect::route('papeis.index');
        }

    }

    public function destroy($id)
    {
        try {

            $this->app_action_role->where('app_role_id', $id)->delete();
            $this->app_role_user->where('app_role_id', $id)->delete();
            $this->papel->where('id', $id)->delete();
            Flash::success("Papel excluído com sucesso.");

        } catch (\PDOException $e) {
            Logger::exception('Papeis Destroy', $e);
            Flash::error('Oops!! '. implode(",", $e->errorInfo));
            return Redirect::route('papeis.index');
        }

        return Redirect::route('papeis.index');
    }
}
