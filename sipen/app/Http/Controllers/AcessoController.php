<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Model\App;
use App\Model\Cidades;
use App\Model\Configuracao;
use App\Model\Estado;
use App\Model\TokenAcesso;
use App\Model\Unidade;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Illuminate\Http\Request;
use Session, Redirect;
use Flash;
use Logger ;
use File;
use Mail;
use DB;


class AcessoController extends Controller
{



    public function __construct(User $user, Unidade $unidadeModel, Estado $estado, Cidades $cidades)
    {
        $this->user = $user;
        $this->unidadeModel = $unidadeModel;
        $this->estado = $estado;
        $this->cidades = $cidades;
    }


    public function listar()
    {
        try
        {
            $users = $this->user->all();
            return view('auth.listar', compact('users'));

        }
        catch (\Exception $e)
        {
            $this->user->GetExeption($e);
            return redirect()->back();
        }

    }


    public function login()
    {

        return view('auth.login');
    }

    public function validaLogin(Request $request)
    {

        try {

            $remember = $request->input(('remember') == '1');
            $UserName = $request->input('matricula');
            $Password = $request->input('password');

            if (Auth::attempt(['matricula' => $UserName , 'password' => $Password,'active' => 1],$remember)) {

                $user = $this->user->find(Auth::user()->id);
                $AppId = 2;  // App::whereId(2)->first()->id;
                $roles = $user->CountRoleUser($user->id,$AppId);

                if ($user->perfil == "Externo") {
                        //DESATIVA TODOS OS TOKEN DO USUÁRIO
                        TokenAcesso::where('fk_user', Auth::user()->id)->update(array('situacao' => 'I'));
                        //GERA NOVO TOKEN
                        \DB::beginTransaction();
                        $novo = new TokenAcesso();
                        $novo->token = geraToken();
                        $novo->fk_user = Auth::user()->id;
                        $novo->situacao = 'A';
                        $novo->push();
                        \DB::commit();
                    //ENVIA INFORMANDO O TOKEN DE ACESSO
                    $this->emailToken(Auth::user()->email, $novo->token, dataFormat($novo->created_at));

                 //   Flash::success('Token: ' .$novo->token);
                    return Redirect::route('selectToken');
                }

                if ($roles > 1) {
                    return Redirect::route('selectRole');
                    //  return Redirect::route('login');
                }
                elseif(($roles) == 1){
                   $buscaid =  $user->GetRolesId($user->id);
                   $selectedRole = $buscaid->id;
                } else {
                    Flash::warning('Perfil do usuário não tem permissão para acessar!');
                    return redirect::to('/');
                }

                $acoesPermitidas = $user->AcionsRole($selectedRole);

                Session::set('app_role_id', $selectedRole);
                Session::set('user_actions', $acoesPermitidas);
                $menus = $user->RenderMenu();
                Session::set('menus', $menus);

                //ENVIA EMAIL SE FOR LOGIN DE 0H AS 06H DA MANHÃ.
                $this->enviaEmailMeiaNoite();

                Logger::Info('Usuário logado', "O usuário {$user->nome} logou.");

                Flash::success('Seja Bem Vindo! '.Auth::user()->nome);

                return Redirect::route('home');
            }
            else
            {
                Flash::warning('Login ou Senha inválidos');
                return Redirect::to('/');
            }


        } catch (\Exception $e) {
            return $e->getMessage();
            Flash::error('Ops, houve um erro ao executar a ação.');
             Logger::exception('Usuários Autenticação', $e);
            return redirect()->back();
        }

    }

    public function enviaEmailMeiaNoite()
    {
        try{


            $hora1      = strtotime(Configuracao::config()->horainicio);
            $hora2      = strtotime(Configuracao::config()->horafim);
            $horaAtual = strtotime(date('H:i'));


                if (($horaAtual > $hora1) && ($horaAtual < $hora2))
                {

                    $data = array('nome'=>Auth::user()->nome,
                        'matricula'=>Auth::user()->matricula,
                        'unidade' => Auth::user()->unidades->nomeunidade,
                        'horario' => date('d/m/Y H:i'),
                        'tipo' => Configuracao::config()->titulo
                    );

                    Mail::send('emails.emailMadrugada', $data, function($message) use ($data) {
                        $message->to(Configuracao::config()->email_admin);
                        $message->subject($data['tipo']);
                        $message->from('admin@syspanda.com.br');
                    });
                }

        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }

    }
    public function logout()
    {
        Auth::logout();
        if (!Auth::check()) {
            Auth::logout();
        }

        Logger::Info('Usuário Saiu','O usuário saiu do sistema');
        Session::forget('app_role_id');
        Session::forget('user_actions');
        Session::forget('menus');
        Auth::logout();


        Session::forget('matricula');

        return redirect('/');

    }



    public function selectRole(Request $request)
    {

        try
        {
            if (!Auth::check()) return Redirect::route('login');
            $v['title'] = 'Selecione o Papel';
            $v['usuario'] = Auth::user()->nome;
            $v['roles'] = $this->user->getRolesList(Auth::user()->id);
            $v['unidades'] = $this->user->getUnidadesList();

            return View('auth.selectRole', $v);
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }
    public function selectRolePost(Request $request)
    {
        try
        {
            if (!Auth::check()) {
            return Redirect::route('login');
        }


        $user = $this->user->find(Auth::user()->id);

        $userRoles = $user->getRolesList($user->id);
        $selectedRole = $request->Input('app_role_id');
        $unidade_id = $request->Input('unidade_id');

        $acoesPermitidas = $user->AcionsRole($selectedRole);
        Session::set('app_role_id', $selectedRole);
        Session::set('user_actions', $acoesPermitidas);
        $menus = $this->user->RenderMenu();
        Session::set('menus', $menus);

        //ATUALIZA A UNIDADE PRISIONAL DE TRABALHO

            $UnidadeUser = User::find($user->id);
            $UnidadeUser->unidade_id = $unidade_id;
            $UnidadeUser->update();

            //ENVIA EMAIL SE FOR LOGIN DE 0H AS 06H DA MANHÃ.
            $this->enviaEmailMeiaNoite();

        Flash::success('Bem vindo ' . $user->nome . '!');
        Logger::info('Usuário logado', "O usuário {$user->nome} logou com o papel #{$selectedRole}");
        return Redirect::route('home');
        }
        catch (\Exception $e)
        {
            return $e;
        }
    }



    public function selectToken(Request $request)
    {

        try
        {
            if (!Auth::check()) return Redirect::route('login');
            $v['title'] = 'Selecione o Papel';
            $v['usuario'] = Auth::user()->nome;

            return View('auth.token', $v);
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }






public function token(Request $request)
    {
        try
        {
            if (!Auth::check()) {
                return Redirect::route('login');
            }

            $user = $this->user->find(Auth::user()->id);
            $AppId = 2;  // App::whereId(2)->first()->id;
            $roles = $user->CountRoleUser($user->id,$AppId);

            $user = $this->user->find(Auth::user()->id);
            //VALIDA TOKEN DO ACESSO EXTERNO
            if ($user->perfil == "Externo") {
               $valido = TokenAcesso::where('fk_user', $user->id)->where('token', $request->input('token'))->where('situacao', 'A')->first();
                if (empty($valido)) {
                    Flash::warning("TOKEN INFORMADO ESTÁ INVÁLIDO!");
                    return Redirect::route('selectToken');
                }
            }

            if ($roles > 1) {
                return Redirect::route('selectRole');
                //  return Redirect::route('login');
            }
            elseif(($roles) == 1){
                $buscaid =  $user->GetRolesId($user->id);
                $selectedRole = $buscaid->id;
            } else {
                Flash::warning('Perfil do usuário não tem permissão para acessar!');
                return redirect::to('/');
            }

            $acoesPermitidas = $user->AcionsRole($selectedRole);

            Session::set('app_role_id', $selectedRole);
            Session::set('user_actions', $acoesPermitidas);
            $menus = $user->RenderMenu();
            Session::set('menus', $menus);

            //ENVIA EMAIL SE FOR LOGIN DE 0H AS 06H DA MANHÃ.
            $this->enviaEmailMeiaNoite();

            Logger::Info('Usuário logado', "O usuário {$user->nome} logou.");

            Flash::success('Seja Bem Vindo! '.Auth::user()->nome);

            return Redirect::route('home');


        }
        catch (\Exception $e)
        {
            return $e;
        }


}


    public function alterarPassword(){
        try {
            $v['titulo'] = "ALTERAÇÃO DE SENHA";
            $v['subtitulo'] = "Por questões de segurança altere sua senha sempre que possível";
            $v['usuarios'] = $this->user->find(Auth::user()->id);
            return view('auth.alterarPassword', $v);
        } catch (\Exception $e) {
            Flash::error("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops!! houve uma erro ao tentar acessar a página");
            return redirect()->back();
        }
    }


    public function cidades($idEstado)
    {
        try
        {
            return $this->cidades->orderby('nome','asc')->where('estado_id',$idEstado)->get();
        }
        catch (\Exception $e)
        {
            return 'Erro Consulta';
        }
    }

    public function solicitaracesso(Request $request)
    {
        try
        {
            $v['title'] = 'SOLICITAÇÃO DE ACESSO';
            $v['sexo'] = ['M' => 'Masculino', 'F' => 'Feminino'];

            $v['estados'] =  $this->estado->where('id', 21)->pluck('nome', 'id');
            $v['estados'][0] = '';
            $v['unidades'] = $this->unidadeModel->pluck('nomeunidade', 'id');
            return View('solicitaracesso.index', $v);
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }
    public function solicitaracessoSalvar(Request $request)
    {
        try {
            $validator = validator($request->all(),
                [
                    'nome' => 'required', 'matricula' => 'required', 'cpf' => 'required', 'email' => 'required|email',
                    'cidade_id' => 'required', 'celular'=>'required',
                    'rua'=>'required', 'numero'=>'required', 'bairro'=>'required', 'estado'=>'required',
                    'cidade_id'=>'required', 'unidade_id'=>'required',
                    'anexodocumento'=>'required'
                ]);
            if ($validator->fails()) {
                return redirect()->route('solicitaracesso')->withInput()->withErrors($validator);
            }

        // ************ VALIDA CPF
           $cpf = preg_replace('/\D/', '', $request->input('cpf'));
            $possuicpf = $this->user->where('cpf', $cpf)->first();
            if($possuicpf) {
                Flash::warning("Já possui cadastro para o CPF!");
                return redirect()->route('solicitaracesso')->withInput();
            }
        // ************ VALIDA CPF
        // ************ VALIDA EMAIL
            $possuiemail = $this->user->where('email', $request->input('email'))->first();
            if($possuiemail) {
                Flash::warning("Já possui cadastro para o E-mail!");
                return redirect()->route('solicitaracesso')->withInput();
            }
        // ************ VALIDA EMAIL
        // ************ VALIDA MATRICULA
            $possuiemail = $this->user->where('matricula', $request->input('matricula'))->first();
            if($possuiemail) {
                Flash::warning("Já possui cadastro para a Matricula!");
                return redirect()->route('solicitaracesso')->withInput();
            }
        // ************ VALIDA MATRICULA


        //INSERE A FOTO
            // return $request->file('foto');
            if($request->file('anexodocumento'))
            {
                $foto = $request->file('anexodocumento');
                $extensao = $foto->getClientOriginalExtension();
                if($extensao == 'exe')
                {
                    Flash::warning("Oops! Este arquivo não é permitido.");
                    return redirect()->route('solicitaracesso')->withInput();
                }

                $nomefoto = sha1(microtime()).'.'.$extensao;
                File::copy($foto, public_path().'/documentoServidores/'.$nomefoto);

            }

            $dt_nascimento = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dt_nascimento'))));

            $this->user->fill($request->all());
            $this->user->anexodocumento = $nomefoto;
            $this->user->cpf = $cpf;
            $this->user->dt_nascimento = $dt_nascimento;
            $this->user->active = 0;
            $this->user->estado_civil_id = 1;
            $this->user->password = bcrypt(123456);
          //  $this->user->perfil = 'Acesso Servidor - Unidades Prisionais';


            if($this->user->save())
            {
                $data = array('nome'=>$this->user->nome,
                    'matricula'=>$this->user->matricula,
                    'tipo' => 'SOLICITAÇÃO DE ACESSO'
                );

                Mail::send('emails.usuarioSolicitacao', $data, function($message) use ($data) {
                    $message->to(Configuracao::config()->email_admin);
                    $message->subject($data['tipo']);
                    $message->from('admin@syspanda.com.br');
                });


                Flash::success("Solicitação de Acesso para o Usuário \"{$this->user->nome}\" criado com sucesso. 
                                                Em breve você receberá um e-mail com as informações de login");
            }

            return Redirect::route('solicitaracesso');

        } catch (\PDOException $e) {
            Flash::error('Oops : ' . implode(",", $e->errorInfo));
            Logger::exception('Usuários Novo : solicitarAcesso', $e);
            return Redirect::route('solicitaracesso')->withInput();
        }
    }



    public function alterarPasswordSalvar(Request $request){
        $validator = validator($request->all(),
            [
                'password'=>'required', 'password2'=>'required'
            ]);
        if($validator->fails()){
            Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops!! Preencha todos os campos.");
            return redirect()->route('alterarPassword');
        }
        if ($request->input('password') != $request->input('password2'))
        {
            Flash::warning("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops!! as <strong>SENHAS</strong> digitadas não conferem.");
            return redirect()->back()->withInput();
        }
        $user = $this->user->find(Auth::user()->id);
        $user->password = bcrypt($request->input('password'));
        if($user->save()){
            Flash::success("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Senha Alterada com sucesso!");
            Logger::Success('Servidores','Alteração de Senha - '. Auth::user()->id.' ');
            return redirect()->route('logout');
            return redirect()->back();
        }
    }




    public function code($id)
    {
        $v['title'] = 'VALIDAÇÃO DE RELATÓRIO - QR-CODE';

        $chave = base64_decode($id);
        $v['producao'] = DB::table('producao as p')
            ->join('producao_tipo as pt', 'pt.id','=','p.tipo_id')
            ->join('producao_status as ps', 'ps.id','=','p.status_id')
            ->Where('p.chave', $chave)
            ->orderby('p.numero', 'desc')
            ->select('p.id as idRel', 'p.*', 'pt.descricao', 'ps.nomestatus')
            ->first();
        return view('producao.code', $v);

    }


    public function emailToken($email, $token, $data)
    {
        $data = array('email'=>$email,
            'token'=>$token,
            'data' =>$data,
            'tipo' => 'TOKEN DE ACESSO'

        );

        Mail::send('emails.emailToken', $data, function($message) use ($data) {
            $message->to($data['email']);
            $message->subject($data['tipo']);
            $message->from('admin@sipen.kinghost.com.br');
        });


    }

    /*
        public function deploy()
        {
            chdir(base_path());
            shell_exec('./deploy.sh');
        }
    */


}
