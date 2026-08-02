<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Configuracao;
use Illuminate\Http\Request;
use App\Models\Admin\App;
use App\Models\Admin\AppAction;
use DB, View, Redirect, Input,Flash,Logger;



class SistemasController extends Controller
{
    //protected $sistema;

    public function __construct(App $sistema, AppAction $acao, Configuracao $configuracao)
    {
        $this->sistema = $sistema;
        $this->acao = $acao;
        $this->configuracao = $configuracao;
    }

    public function index(Request $request)
    {

        try {
            $v['title'] = 'Sistemas';
            $v['sistemas'] = $this->sistema->paginate(4);
            if ($request->has('q')) {
                $query = strtolower('%' . $request->input('q') . '%');
                $v['sistemas'] = DB::table('app')
                    ->where(DB::raw('LOWER(name)'), 'LIKE', $query)
                    ->orWhere('url', 'LIKE', $query)
                    ->paginate(10);
            }

            return view('admin.sistemas.index', $v);

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Sistema Index', $e);
            return Redirect::route('sistemas.index')->withErrors(['sistemas.index' => $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            $v['title'] = 'Cadastrar Sistema';
            return view('admin.sistemas.create', $v);
        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Sistema Create', $e);
            return Redirect::route('sistemas.index')->withErrors(['sistemas.index' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = validator($request->all(),
                ['name' => 'required', 'url' => 'required', 'active' => 'required']);
            if ($validator->fails()) {
                return redirect()->route('sistemas.create')->withInput()->withErrors($validator);
            }
            $this->sistema->create($request->all());
            Flash::success("Sistema cadastrado com sucesso.");
            return Redirect::route('sistemas.index');

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Sistema Salvar : store', $e);
            return Redirect::route('sistemas.create')->withInput();
        }

    }

    public function edit(Request $request, $id)
    {
        try {
            $v['title'] = 'Editar Sistema';
            $v['sistema'] = $this->sistema->findOrFail($id);
            $v['configuracao'] = $this->configuracao->findOrFail(1);

            if ($request->has('app_action_id')) {
                $v['acao'] = $this->acao->findOrFail($request->get('app_action_id'));
            }
            return view('admin.sistemas.edit', $v);

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Sistema Editar : edit', $e);
            return Redirect::route('sistemas.index');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = validator($request->all(),
                ['name' => 'required', 'url' => 'required', 'active' => 'required']);
            if ($validator->fails()) {
                return redirect()->route('sistemas.edit', $id)->withInput()->withErrors($validator);
            }
            $sistema = $this->sistema->find($id);
            $sistema->update($request->all());
            Flash::success("Sistema editado com sucesso.");
            return Redirect::route('sistemas.edit', $id);

        }
        catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Sistema Editar : update', $e);
            return Redirect::route('sistemas.edit',$id)->withInput();

        }

    }

    public function configuracao(Request $request, $id)
    {
        try {
//            $validator = validator($request->all(),
//                ['name' => 'required', 'url' => 'required', 'active' => 'required']);
//            if ($validator->fails()) {
//                return redirect()->route('sistemas.edit', $id)->withInput()->withErrors($validator);
//            }
            $configuracao = $this->configuracao->find(1);
            $configuracao->update($request->all());
            Flash::success("Configuração editada com sucesso.");
            return Redirect::route('sistemas.edit', $id);

        }
        catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Sistema Editar : update', $e);
            return Redirect::route('sistemas.edit',$id)->withInput();

        }

    }



    public function destroy($id)
    {
        try {

            $this->sistema->where('id', $id)->delete();
            Flash::success("Sistema excluído com sucesso.");

            return Redirect::route('sistemas.index');

        } catch (Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Sistema Deletar : destroy', $e);
            return Redirect::route('sistemas.index');
        }

    }
}
