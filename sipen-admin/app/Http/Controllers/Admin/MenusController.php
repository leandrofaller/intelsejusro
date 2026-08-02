<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AppMenuChildren;
use Illuminate\Http\Request;
use App\Models\Admin\App;
use App\Models\Admin\AppRole;
use App\Models\Admin\AppMenu;
use App\Models\Admin\AppAction;
use DB, Input, Redirect, View;
use App\Models\Flash, Logger;

class MenusController extends Controller
{
    public function __construct(App $sistema, AppRole $papel, AppMenu $menu, AppAction $acao, AppMenuChildren $appMenuChildren)
    {
        $this->acao = $acao;
        $this->papel = $papel;
        $this->menu = $menu;
        $this->sistema = $sistema;
        $this->menusFilhos = $appMenuChildren;
    }

    public function index(Request $request)
    {
        try {
            $v['title'] = 'Menus';
            $v['sistemas'] = $this->sistema->pluck('name', 'id');
            $v['papeis'] = $this->papel->orderby('name')->whereAppId($request->get('app_id'))->pluck('name', 'id');

            if ($request->has('app_id')) {
                $v['sistema'] = $this->sistema->find($request->get('app_id'));
            }

            if ($request->has('app_id') && $request->has('app_role_id')) {
                $v['menus'] = $this->menu->orderBy('order')->whereAppRoleId($request->get('app_role_id'))->get();
                $v['routes'] = $this->acao->join('app_action_role', 'app_action.id', '=', 'app_action_role.app_action_id')
                    ->where('app_action_role.app_role_id', $request->get('app_role_id'))
                    ->orderBy('app_action.title')
                    ->select(DB::raw("CONCAT(app_action.title,' - ', app_action.route) AS title, app_action.id"))
                    ->pluck('title', 'id');
                $v['routes']['Opcional:'] = [''=>'- Sem Rotas -'];

                $v['menuPrincipal'] = $this->menu->whereAppRoleId($request->get('app_role_id'))->get();
                $v['menuPai'] = $v['menuPrincipal']->pluck('title', 'id');

                $v['routesMenuPai'] = $this->acao->join('app_action_role', 'app_action.id', '=', 'app_action_role.app_action_id')
                    ->where('app_action_role.app_role_id', $request->get('app_role_id'))
                    ->orderBy('app_action.title')
                    ->select(DB::raw("CONCAT(app_action.title,' - ', app_action.route) AS title, route"))
                    ->pluck('title', 'route');
                $v['routesMenuPai']['Opcional:'] = [''=>'- Sem Rotas -'];

                if ($request->get('app_menu_id')) {
                    $v['menusFilhos'] = $this->menusFilhos->findOrFail($request->input('app_menu_id'));
                }
                if ($request->get('app_menu_pai')) {

                    $v['menusPais'] = $this->menu->findOrFail($request->input('app_menu_pai'));
                }
            }
            return view('admin.menus.index', $v);

        } catch (\Exception $e) {
            return $e->getMessage();
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Menu Index', $e);
            return redirect()->back();
        }

    }


    public function storePais(Request $request)
    {
        try {
            $validator = validator($request->all(),
                ['title' => 'required', 'order' => 'required', 'icon' => 'required', 'app_role_id' => 'required']);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $this->menu->create($request->all());
            Flash::success('Menu Pai criado com sucesso.');
            return redirect()->back();
            //return Redirect::route('menus.index', ['app_id' => $request->get('app_id'), 'app_role_id' => $request->get('app_role_id')]);

        } catch (\Exception $e) {
            return $e->getMessage();
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
       //     Logger::exception('Menu Editar', $e);
            return redirect()->back();
            //return Redirect::route('menus.index')->withErrors(['menus.index' => $e->getMessage()]);
        }
    }

    public function updatePais(Request $request, $id)
    {
        try {
            $validator = validator($request->all(),
                ['title' => 'required', 'order' => 'required', 'icon' => 'required']);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $menuPai = $this->menu->findOrFail($id);
            $menuPai->fill($request->all());
            $menuPai->save();
            Flash::success('Menu Pai editado com sucesso.');
            return redirect()->back();

            //return Redirect::route('menus.index', [ 'app_menu_id' => $id, 'app_id' => $request->get('app_id'), 'app_role_id' => $request->get('app_role_id') ]);

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
      //      Logger::exception('Menu Editar', $e);
            return redirect()->back();

        }
    }

    public function destroyMenuPais($id)
    {
        try {

            $this->menusFilhos->where('app_menu_id', $id)->delete();
            $this->menu->where('id', $id)->Delete();
            Flash::success('Menu Pai excluído com sucesso');

            return Redirect::route('menus.index');
            //return redirect()->back();

        } catch (\Exception $e) {
            return $e->getMessage();
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Menu Excluir', $e);
            return redirect()->back();
        }
    }


    public function storeFilhos(Request $request)
    {
        try {
            $validator = validator($request->all(),
                ['title' => 'required', 'order' => 'required', 'icon' => 'required', 'app_menu_id' => 'required']);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $this->menusFilhos->create($request->all());
            Flash::success('Menu Filho criado com sucesso.');
            return redirect()->back();
            //return Redirect::route('menus.index', ['app_id' => $request->get('app_id'), 'app_role_id' => $request->get('app_role_id')]);

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Menu Editar', $e);
            return redirect()->back();
            //return Redirect::route('menus.index')->withErrors(['menus.index' => $e->getMessage()]);
        }
    }

    public function updateFilhos(Request $request, $id)
    {
        try {
            $validator = validator($request->all(),
                ['title' => 'required', 'order' => 'required', 'icon' => 'required', 'app_menu_id' => 'required']);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $menuFilhos = $this->menusFilhos->findOrFail($id);
            $menuFilhos->fill($request->all());
            $menuFilhos->save();
            Flash::success('Menu Filho editado com sucesso.');
            return redirect()->back();
            //return Redirect::route('menus.index', ['app_menu_id' => $id, 'app_id' => $request->get('app_id'), 'app_role_id' => $request->get('app_role_id')]);

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Menu Editar', $e);
            return redirect()->back();

        }
    }

    public function destroyMenuFilho($id)
    {
        try {

            $this->menusFilhos->where('id', $id)->delete();
            Flash::success('Menu Filho excluído com sucesso');
            return Redirect::route('menus.index');

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Menu Excluir', $e);
            return redirect()->back();
        }
    }


}
