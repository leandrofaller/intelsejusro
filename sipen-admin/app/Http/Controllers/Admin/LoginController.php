<?php

namespace App\Http\Controllers\Admin;

use App\Models\Users;
use App\Models\Admin\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Flash,DB,Auth,Redirect,Session;
use App\Models\Logger;


class LoginController extends Controller
{
    public function __construct(Users $users)
    {
        $this->user = $users;
    }
    public function login()
    {
        $v['title'] = 'Autenticate';
        return View('admin.login.login', $v);
    }

    public function loginPost(Request $request)
    {
        try {

             $remember = $request->input('remember');
             $UserName = $request->input('username');
             $Password = $request->input('password');

            if (Auth::attempt(['email' => $UserName , 'password' => $Password,'active' => 1],$remember)) {

                // Authentication passed...
                 $user = $this->user->find(Auth::user()->id);
                 $AppId = 1;
                 $roles = $user->CountRoleUser($user->id,$AppId);

                if ($roles > 1) {
                    return Redirect::route('admin.selectRole');
                } else if (($roles) == 1) {

                    $buscaid =  $user->GetRolesId($user->id);
                    $selectedRole = $buscaid->id;

                } else {
                    Flash::warning('Papel do usuário não tem permissão para acessar!');
                    return Redirect::route('admin.login');
                }

                $acoesPermitidas = $user->AcionsRole($selectedRole);

                Session::put('app_role_id', $selectedRole);
                Session::put('user_actions', $acoesPermitidas);
                $menus = $user->RenderMenu();
                Session::put('menus', $menus);

                Logger::Info('Usuário logado', "O usuário {$user->nome} logou.");

                Flash::success('Seja Bem Vindo! '.Auth::user()->nome);
                return Redirect::route('homeAdmin.index');
            }
            else
            {
                Flash::warning('Login ou Senha inválidos');
                return Redirect::route('admin.login');
            }


        } catch (\Exception $e) {
            Flash::error('Ops, houve um erro ao executar a ação.');
            Logger::exception('Usuários Autenticação', $e);
            return redirect()->back();
        }
    }

     public function selectRole(Request $request)
      {

         try
          {
              if (!Auth::check()) return Redirect::route('admin.login');
              $v['title'] = 'Selecione o Papel';
              $v['usuario'] = Auth::user()->nome;
               $v['roles'] = $this->user->getRolesList(Auth::user()->id);

              return View('admin.login.selectRole', $v);
          }
         catch (\Exception $e)
          {
             return $e;
          }
      }
    public function selectRolePost(Request $request)
    {

        if (!Auth::check()) {
            return Redirect::route('login');
        }
        $user = $this->user->find(Auth::user()->id);
        $userRoles = $user->getRolesList($user->id);
        $selectedRole = $request->Input('app_role_id');
        $acoesPermitidas = $user->AcionsRole($selectedRole);
        Session::put('app_role_id', $selectedRole);
        Session::put('user_actions', $acoesPermitidas);
        $menus = $this->user->RenderMenu();
        Session::put('menus', $menus);
        Flash::success('Bem vindo ' . $user->nome . '!');
        Logger::info('Usuário logado', "O usuário {$user->nome} logou com o papel #{$selectedRole}");
        return Redirect::route('homeAdmin.index');

    }

    public function logout()
    {
        try
        {
            Logger::Info('Usuário Saiu','O usuário saiu do sistema');
            Session::forget('app_role_id');
            Session::forget('user_actions');
            Session::forget('menus');
            Auth::logout();
            return Redirect::route('admin.login');
        }
        catch (\Exception $e)
        {
            Session::forget('app_role_id');
            Session::forget('user_actions');
            Session::forget('menus');
            Auth::logout();
            return Redirect::route('admin.login');
        }



    }
}
