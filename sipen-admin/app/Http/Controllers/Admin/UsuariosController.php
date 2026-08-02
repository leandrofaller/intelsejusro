<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cidades;
use App\Models\Admin\Regioes;
use App\Models\Admin\Unidades;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Admin\EstadoCivil;
use App\Models\Admin\AppRole;
use App\Models\Admin\AppRoleUser;
use App\Models\Admin\Estados;
use DB, Response, Redirect, View;
use App\Models\Flash;
use App\Models\Logger;
use DateTime;
use Mail;


class UsuariosController extends Controller
{
    protected $usuario;

    public function __construct( Unidades $unidades, Users $usuario, AppRole $papel, AppRoleUser $papelUsuario, EstadoCivil $estadoCivil, Estados $estados,Cidades $cidades)
    {
        $this->usuario = $usuario;
        $this->papel = $papel;
        $this->papelUsuario = $papelUsuario;
        $this->estado_civil = $estadoCivil;
        $this->estados = $estados;
        $this->cidades = $cidades;
        $this->unidades = $unidades;
    }

    public function index(Request $request)
    {
        try {
            $v['title'] = 'Usuários';
            // $sort  = $request->has('sort') ? $request->get('sort') : 'firstname';
            $v['usuarios'] = $this->usuario->orderBy('nome', 'desc');
            if ($request->has('q')) {
                $query = strtolower('%' . $request->get('q') . '%');
                $v['usuarios'] = $v['usuarios']->where(DB::raw('LOWER(nome)'), 'LIKE', $query)
                    ->orWhere(DB::raw('LOWER(email)'), 'LIKE', $query);
            }
            $v['usuarios'] = $v['usuarios']->paginate(20);

            return view('admin.usuarios.index', $v);
        } catch (\Exception $e) {
            return $e->getMessage();
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Usuários Index : Index', $e);
            return Redirect::route('admin.usuarios.index')->withErrors(['usuarios.index' => $e->getMessage()]);
        }
    }

    public function create()
    {
        $v['title'] = 'Cadastrar Usuário';
        $v['sexo'] = ['M' => 'Masculino', 'F' => 'Feminino'];
        $v['estado_civil'] = $this->estado_civil->pluck('descricao', 'id');

        $v['estados'] = $this->estados->pluck('nome', 'id');
        $v['unidades'] = $this->unidades->pluck('nomeunidade', 'id');
        $v['estados'][0] = '';
        return view('admin.usuarios.create', $v);
    }

    public function store(Request $request)
    {
        try {
            $validator = validator($request->all(),
                [
                    'nome' => 'required', 'matricula' => 'required', 'cpf' => 'required', 'email' => 'required|email',
                    'estado_civil_id' => 'required', 'cidade_id' => 'required'
                ]);
            if ($validator->fails()) {
                return redirect()->route('usuarios.create')->withInput()->withErrors($validator);
            }
            $cpf = preg_replace('/\D/', '', $request->input('cpf'));
            $dt_nascimento = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dt_nascimento'))));

            $this->usuario->fill($request->all());
            $this->usuario->cpf = $cpf;
            $this->usuario->dt_nascimento = $dt_nascimento;
            $this->usuario->password = bcrypt(123456);
            $this->usuario->save();
            Flash::success("Usuario \"{$this->usuario->nome}\" criado com sucesso.");
            return Redirect::route('usuarios.create');

        } catch (\PDOException $e) {

            Flash::error('Oops : ' . implode(",", $e->errorInfo));
            Logger::exception('Usuários Novo : create', $e);
            return Redirect::route('usuarios.create')->withInput();
        }

    }

    public function edit($id)
    {
        try {
            $v['title'] = 'Editar Usuário';
            $v['usuario'] = $this->usuario->find($id);
            $v['unidades'] = $this->unidades->pluck('nomeunidade', 'id');
            $v['regioes'] = Regioes::pluck('nomeregiao', 'id');
            $cidade = $this->cidades->where('id',$v['usuario']->cidade_id)->first();
            $v['estado_id'] = $cidade->estado_id;
            $v['cidade'] = [$cidade->id => $cidade->nome];

            $v['papeis'] = $this->papel;
            $v['sexo'] = ['M' => 'Masculino', 'F' => 'Feminino'];
            $v['estado_civil'] = $this->estado_civil->pluck('descricao', 'id');
            $v['estados'] = $this->estados->where('id', 21)->pluck('nome', 'id');
            $v['estados'][0] = '';

            $papelUsuarios = $v['usuario']->papeis()->get()->pluck('app_role_id');
            if (count($papelUsuarios) > 0) {
                $v['papeis'] = $v['papeis']->whereNotIn('id', $papelUsuarios);
            }
            $v['papeis'] = $v['papeis']->get();
            $papeis = [];
            foreach ($v['papeis'] as $papel) {
                $papeis[$papel->id] = $papel->sistema->name . ' - ' . $papel->name;
            }
            $v['papeis'] = $papeis;
            return view('admin.usuarios.edit', $v);

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Usuários Salvar : edit', $e);
            return Redirect::route('usuarios.index')->withErrors(['usuarios.index' => $e->getMessage()]);
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $validator = validator($request->all(),
                ['nome' => 'required', 'matricula' => 'required', 'cpf' => 'required', 'email' => 'required|email', 'estado_civil_id' => 'required', 'cidade_id' => 'required']);
            if ($validator->fails()) {
                return redirect()->route('usuarios.edit', $id)->withInput()->withErrors($validator);
            }

            $cpf = preg_replace('/\D/', '', $request->input('cpf'));
            $dt_nascimento = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('dt_nascimento'))));

            $usuario = $this->usuario->find($id);
            $usuario->fill($request->all());
            $usuario->cpf = $cpf;
            $usuario->dt_nascimento = $dt_nascimento;
            $usuario->save();

            Flash::success("Usuario \"{$usuario->nome}\" atualizado com sucesso.");
            return Redirect::route('usuarios.index');

        } catch (\PDOException $e) {

            Flash::error('Oops : ' . implode(",", $e->errorInfo));
            Logger::exception('Usuários Edit : update', $e);
            return Redirect::route('usuarios.edit', $id)->withInput();
        }
    }

    public function show($id)
    {
        $v['title'] = 'Informações do Usuário';
        $v['usuario'] = $this->usuario->findOrFail($id);

        return view('admin.usuarios.show', $v);
    }

    public function createRole(Request $request)
    {
        try {

            if ($request->input('app_role_id') == null) {
                Flash::warning("Ops, nenhuma papel para associar.");
                return redirect()->back();
            }
            $papelUsuario = new AppRoleUser;
            $papelUsuario->user_id = $request->input('user_id');
            $papelUsuario->app_role_id = $request->input('app_role_id');
            $papelUsuario->save();
            Flash::success("Papel adicionado com sucesso.");
            return Redirect::route('usuarios.edit', $papelUsuario->user_id);

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Usuários Create Role : createRole', $e);
            return Redirect::route('usuarios.edit', $papelUsuario->user_id)->withInput();
        }
    }

    public function createRegiao(Request $request)
    {
        try {

            if ($request->input('regiao_id') == null) {
                Flash::warning("Ops, nenhuma Região Selecionada.");
                return redirect()->back();
            }

            $usuario = $this->usuario->find($request->input('user_id'));
            $usuario->regiao_id = $request->input('regiao_id');
            $usuario->save();

            Flash::success("Região Adicionada com Sucesso.");
            return Redirect::route('usuarios.edit', $usuario->id);

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Usuários Create Role : createRole', $e);
            return Redirect::route('usuarios.edit', $usuario->id)->withInput();
        }
    }


    public function resetPassword($idUser)
    {
        try {
            $user = $this->usuario->find($idUser);
            $user->password =  bcrypt('gip2015');
            $user->save();
            if($user->save())
             {
                $data = array('nome'=>$user->nome,
                    'email'=>$user->email,
                    'matricula'=>$user->matricula,
                    'senha' => 'gip2015',
                    'tipo' => 'RESET DE SENHA',
                    'msg' => 'Sua senha ao sistema foi resetada com sucesso, utilize a senha indicada abaixo. Por motivos de
                    segurança orientamos que a mesma seja alterada no primeiro acesso.'
                );

               // Mail::send('emails.usuarioReset', $data, function($message) use ($data) {
               //     $message->to($data['email']);
               //     $message->subject('Reset de Senha');
               //     $message->from('admin@syspanda.com.br');
               // });

            }
            Flash::success('Usuário '.$user->nome.' Resetado com sucesso. Senha: gip2015');
            return Redirect::route('usuarios.index');

        } catch (\Exception $e) {
            Flash::error('Ops, houve um erro ao Cancelar o requerimento.');
            return Redirect::route('');
        }
    }

    public function AtivarInativarUser($idUser, $status)
    {
        try {

            $msn =$status ? 'Ativado':'Inativado';

            $user = $this->usuario->find($idUser);
            $user->active = $status;
            $user->save();

/*
            if($msn == 'Ativado')
            {
                $data = array('nome'=>$user->nome,
                    'email'=>$user->email,
                    'matricula'=>$user->matricula,
                    'senha' => '123456',
                    'tipo' => 'LIBERAÇÃO DE ACESSO',
                    'msg' => 'Parabéns, seu acesso foi liberado com sucesso.'
                );

                Mail::send('emails.usuarioLiberado', $data, function($message) use ($data) {
                    $message->to($data['email']);
                    $message->subject('Autorização de Acesso');
                    $message->from('admin@syspanda.com.br');
                });
            }

*/
            Flash::success('Usuário '.$msn.'  com sucesso.');
            return Redirect::route('usuarios.index');

        } catch (\Exception $e) {
            return $e->getMessage();
            Flash::error('Ops, houve um erro ao executar a ação.');
            Logger::exception('Usuários AtivarInativar', $e);
            return redirect()->back();
        }
    }

    public function deleteRole($idRoleUser, $idUser)
    {
        try {

            $this->papelUsuario->where('id', $idRoleUser)->delete();
            Flash::success("Papel removido com sucesso.");

            return Redirect::route('usuarios.edit', $idUser);

        } catch (\Exception $e) {
            Flash::error('Oops! Houve um erro na solicitação, contacte o administrador.');
            Logger::exception('Usuários Deletar Role : deleteRole', $e);
            return Redirect::route('usuarios.edit',$idUser)->withInput();
        }
    }

    //DELETAR USUÁRIO
    public function deletar($idUser)
    {
        try {
            $this->papelUsuario->where('user_id', $idUser)->delete();
            $this->usuario->where('id', $idUser)->delete();

            Flash::success("Usuário removido com sucesso.");

            return Redirect::route('usuarios.index', $idUser);

        } catch (\Exception $e) {
           // return $e->getMessage();
            Flash::error('Oops! Usuário não pode ser excluido, pois já efetuou um login no sistema.');
            Logger::exception('Usuários Deletar : delete Usuário', $e);
            return Redirect::route('usuarios.index',$idUser)->withInput();
        }
    }
}
