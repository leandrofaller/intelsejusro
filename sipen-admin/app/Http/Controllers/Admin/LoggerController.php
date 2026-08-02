<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\App;
use App\Models\Admin\Logger;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Flash,DB,Redirect;
use DateTime;


class LoggerController extends Controller
{
    public function __construct(App $app, Logger $logger, Users $user)
    {
        $this->app = $app;
        $this->logger = $logger;
        $this->user = $user;
    }

    public function index(Request $request)
    {

        try {
            $v['title'] = 'Logs de Atividades';
            $v['apps'] = $this->app->orderBy('name')->pluck('name', 'id');
            $v['alert'] = ['T'=>'Todos Tipos','S'=>'Sucesso','I'=>'Informação','W'=>'Atenção','E'=>'Exeção'];
            $v['hoje'] = (new DateTime())->format('d/m/Y');

            if ($request->has('app_id')) {

                $app = $request->get('app_id');
                if ($request->has('dt_inicio')) {
                    $startAt = \DateTime::createFromFormat('d/m/Y', $request->get('dt_inicio'));
                    $startAt = $startAt->format('Y-m-d');
                } else {
                    $startAt = date('Y-m-d');
                }

                if ($request->has('dt_fim')) {
                    $endAt = \DateTime::createFromFormat('d/m/Y', $request->get('dt_fim'));
                    $endAt = $endAt->format('Y-m-d');
                } else {
                    $endAt = date('Y-m-d');
                }


                $alert = array($request->get('alert'));

                if ($request->get('alert') == 'T') {
                    $alert = array('S', 'I', 'W', 'E');

                }

                $argumento = $request->get('argumento');
                $v['logs'] = DB::table('logger')
                    ->join('users as user', 'user.id', '=', 'logger.fkuser')
                    ->join('app', 'app.id', '=', 'logger.app_id')
                    ->where('logger.app_id', $app)
                    ->whereIn('logger.alert', $alert)
                    ->whereRaw(DB::raw("DATE(logger.created_at) >= '{$startAt}'"))
                    ->whereRaw(DB::raw("DATE(logger.created_at) <= '{$endAt}'"))
                    ->where('user.nome', 'like', '%' . $argumento . '%')
                    //->orwhere('user.cpf', 'like', '%' . $argumento . '%')
                    //->orwhere('user.email', 'like', '%' . $argumento . '%')
                    ->select('logger.id', 'logger.alert', 'logger.title', 'logger.message', 'logger.created_at', 'logger.fkuser', 'logger.app_id', 'user.nome', 'user.email','app.name')
                    ->orderby('created_at', 'DESC')
                    ->get();
            }

            return view('admin.logger.index', $v);


        } catch (\Exception $e) {
            Flash::error('Erro ao consultar os logs.'.$e->getMessage());
            return Redirect::route('logger.index');

        }
    }
}
