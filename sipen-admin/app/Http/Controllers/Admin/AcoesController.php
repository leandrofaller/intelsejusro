<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\App;
use App\Models\Admin\AppAction;
use App\Models\Admin\AppActionRole;
use App\Models\Flash;
use Input, View, Redirect, DB;
use App\Models\Logger;

use Illuminate\Http\Request;

class AcoesController extends Controller
{
    public function __construct(App $sistema, AppAction $acao,AppActionRole $actionRole)
    {
        $this->acao = $acao;
        $this->sistema = $sistema;
        $this->app_action_role = $actionRole;
    }

    public function index(Request $request)
    {
        try {
            $v['title'] = 'Ações';
            if ($request->has('q')) {
                $query = strtolower('%'.$request->input('q').'%');
                $v['acoes'] = $this->acao
                    ->where(DB::raw('LOWER(title)'), 'LIKE', $query)
                    ->orWhere(DB::raw('LOWER(route)'), 'LIKE', $query)
                    ->paginate(30);
                return view('admin.acoes.index', $v);
            }
            $v['acoes'] = $this->acao->orderby('id', 'desc')->paginate(40);
            return view('admin.acoes.index', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            Flash::error('Ops. Contacte o Administrador do Sistema');
            Logger::exception('Ações Index', $e);
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $v['title'] = 'Cadastrar Ação';
            $v['sistemas'] = $this->sistema->orderby('id', 'desc')->pluck('name', 'id');
            return View('admin.acoes.create', $v);
        } catch (\Exception $e) {
            Logger::exception('Ações Create', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return Redirect::route('acoes.index');
        }


    }

    public function store(Request $request)
    {
        try {
            $validator = validator($request->all(),
                ['title' => 'required', 'route' => 'required', 'app_id' => 'required', 'active' => 'required']);
            if ($validator->fails()) {
                return redirect()->route('acoes.create')->withInput()->withErrors($validator);
            }

            $this->acao->create($request->all());
            Flash::success("Ação cadastrada com sucesso.");
            return Redirect::route('acoes.index');
        } catch (\Exception $e) {
            Flash::error('Ops. Contacte o Administrador do Sistema');
            Logger::exception('Ações Store', $e);
            return redirect()->back();
        }

    }

    public function edit($id)
    {
        try {
            $v['title'] = 'Editar Ação';
            $v['sistemas'] = $this->sistema->pluck('name', 'id');
            $v['acao'] = $this->acao->findOrFail($id);
            return View('admin.acoes.edit', $v);
        } catch (\Exception $e) {
            Logger::exception('Ações Edit', $e);
            Flash::error('Oops!! desculpe, houve um erro inesperado ao processar a solicitação, contate o adminstrador.');
            return Redirect::route('acoes.index');
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $validator = validator($request->all(),
                ['title' => 'required', 'route' => 'required', 'app_id' => 'required', 'active' => 'required']);
            if ($validator->fails()) {
                return redirect()->route('acoes.edit', $id)->withInput()->withErrors($validator);
            }
            $acao = $this->acao->findOrFail($id);
            $acao->update($request->all());
            Flash::success("Ação editada com sucesso.");
            return Redirect::route('acoes.index');
            //return Redirect::route('acoes.edit', $id);

        } catch (\Exception $e) {
            Flash::error('Ops. Contacte o Administrador do Sistema');
            Logger::exception('Ações - Sistema', $e);
            return Redirect::route('acoes.index');
        }
    }

    public function destroy($id)
    {
        try {
            $app_action_role =  $this->app_action_role->find($id);

            if($app_action_role != null)
            {
                Flash::warning('Oops!! Primeiro delete a Ação atribuido ao Papel.');
                return redirect()->back();
            }


            $this->acao->where('id', $id)->delete();
            Flash::success("Ação excluída com sucesso.");
            return Redirect::route('acoes.index');

        } catch (Exception $e) {
            Flash::error('Ops. Contacte o Administrador do Sistema');
            Logger::exception('Ações - Destroy', $e);
            return Redirect::route('acoes.index');
        }


    }
}
