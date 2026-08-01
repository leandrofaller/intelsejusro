<?php

namespace App\Http\Middleware;

use Closure;

//use Illuminate\Contracts\Auth\Guard;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Session;
use Route,Redirect;
use Flash;


class Authenticate
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }


    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        if(!Session::has('app_role_id'))
        {
            return redirect()->guest('login');
        }
        $current = Route::current()->getName();
        $allowedActions = Session()->get('user_actions');
        if($allowedActions && count($allowedActions) > 0)
        {
            $pesquisa = strpos($allowedActions,$current);
            if ($pesquisa == false)
            {
                Flash::error('O Perfil de usuário atual não tem permissão para a ação desejada.');
                return redirect()->guest('home');
            }
        }
        else
        {
            Flash::warning('Seu Perfil não tem nenhuma ação. Contate o administrador');
            Session::forget('app_role_id');
            Session::forget('user_actions');
            Session::forget('menus');
            return Redirect::route('login');
        }
        return $next($request);

    }
}
