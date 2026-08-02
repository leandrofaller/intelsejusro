<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Session;
use Route;
use Flash;

class Admin
{
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
                return redirect()->guest('admin/login');
            }
        }
        if(!Session::has('app_role_id'))
        {
            return redirect()->guest('admin/login');
        }
        $current = Route::current()->getName();
        $allowedActions = Session::get('user_actions');

        if($allowedActions && count($allowedActions) > 0)
        {
            $pesquisa = strpos($allowedActions,$current);
            if ($pesquisa == false)
            {
                Flash::error('Sem Permissão para Acessar, Contate o Administrador.');
                return redirect()->guest('admin/');
            }

        }
        return $next($request);
    }
}
