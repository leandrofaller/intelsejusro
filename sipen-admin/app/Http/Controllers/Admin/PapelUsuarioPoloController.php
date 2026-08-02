<?php

namespace App\Http\Controllers;

use App\Models\Flash;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\AppRole;
use App\Models\AppPolo;
use App\Models\AppRoleUser;
use App\Models\AppRoleUserPolo;
use Input, Redirect, View;
use App\Models\Logger;

class PapelUsuarioPoloController extends Controller
{
    public function __construct(Usuario $usuario, AppRole $papel, AppPolo $polo,
                                AppRoleUser $roleUser, AppRoleUserPolo $roleUserPolo) {
        $this->usuario = $usuario;
        $this->papel = $papel;
        $this->polo = $polo;
        $this->roleUser = $roleUser;
        $this->roleUserPolo = $roleUserPolo;
    }

    public function edit($id) {
        try
        {
            $v['title'] = 'Editar papel do usuário';
            $v['roleUser'] = $this->roleUser->find($id);
            $v['papel']   = $this->papel->find($v['roleUser']->app_role_id);
            $v['usuario'] = $this->usuario->find($v['roleUser']->user_id);
            $user_polos_id = $v['roleUser']->polos()->pluck('app_polo_id');
            $polos = $this->polo->orderBy('name');

            if(count($user_polos_id) > 0) {
                $polos = $polos->whereNotIn('id', $user_polos_id);
            }
            $v['polos'] = $polos->pluck('fullname', 'id');

            return view('papel_usuario_polo.edit', $v);

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Papel Usuário Polo - edit', $e);
            return Redirect::route('papel_usuario_polo.edit', $id)->withErrors(['papel_usuario_polo.edit' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $selecionouIFRO = $request->input('ifro_check');
            $selecionouSEDUC = $request->input('seduc_check');

            $validator = validator($request->all(),
                [ 'app_role_user_id'=>'required', 'app_polo_id'=>'required' ]);
            if($validator->fails()){
                Flash::error('Oops! Informe todos os campos');
              //  return redirect()->route('papel_usuario_polo.edit')->withInput()->withErrors($validator);
            }

            $selecionados = array();

            if (!empty($selecionouIFRO))
                 $selecionados = $this->polo->where('ifro_app_polo.name', 'like', '%GRUPORO%')->pluck('id');
            if ($selecionouSEDUC)

                $selecionados = $this->polo->where('ifro_app_polo.name', 'like', 'SED%')->pluck('id');
                $selecionadosFormSELECT = $request->input('app_polo_id');

            if ($selecionadosFormSELECT)
                $selecionados += $selecionadosFormSELECT;

            // pega todos os ids selecionados e vincula aos polos
            // foreach (Input::get('app_polo_id') as $app_polo_id) {
            foreach ($selecionados as $app_polo_id) {
                $role_user_polo = $this->roleUserPolo->firstOrNew([
                    'app_polo_id' => $app_polo_id,
                    'app_role_user_id' => $request->input('app_role_user_id')
                ]);

                if($role_user_polo->save()) {
                    Flash::success('Associado polo ao papel do usuário.');
                }
                else {
                    Flash::error('Ops, não foi possível associar polo papel do usuário.');
                }
            }
            return Redirect::back();

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Papel Usuário Polo - store', $e);
            return Redirect::route('papel_usuario_polo.edit')->withErrors(['papel_usuario_polo.edit' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try
        {
            $role_user_polo = $this->roleUserPolo->find($id);
            if($role_user_polo->delete())
            {
                Flash::success('Excluído associação de polo ao papel do usuário.');
            }
            else
            {
                Flash::error('Ops, não foi possível excluir associação de polo do papel do usuário.');
            }

                return Redirect::back();

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Papel Usuário Polo - destroy', $e);
            return Redirect::route('papel_usuario_polo.destroy')->withErrors(['papel_usuario_polo.destroy' => $e->getMessage()]);
        }
    }
}
