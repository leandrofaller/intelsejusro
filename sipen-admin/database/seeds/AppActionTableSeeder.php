<?php

use App\Models\Admin\App;
use App\Models\AppAction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class AppActionTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('app_action')->delete();

        $app_id = App::whereName('Admin')->first()->id;
        $actionAdmin = [
            ['title' => 'Home', 'route' => 'homeAdmin.index', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],

            ['title' => 'Sistemas', 'route' => 'sistemas.index', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Sistema Cadastrar', 'route' => 'sistemas.create', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Sistema Cadastrar[Salvar]', 'route' => 'sistemas.store', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Sistema Editar', 'route' => 'sistemas.edit', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Sistema Editar[salvar]', 'route' => 'sistemas.update', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Sistema Excluir', 'route' => 'sistemas.destroy', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],

            ['title' => 'Papéis', 'route' => 'papeis.index', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Papel Cadastrar', 'route' => 'papeis.create', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Papel Cadastrar[Salvar]', 'route' => 'papeis.store', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Papel Editar', 'route' => 'papeis.edit', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Papel Editar [salvar]', 'route' => 'papeis.update', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Papel Excluir', 'route' => 'papeis.destroy', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],

            ['title' => 'Ação', 'route' => 'acoes.index', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Ação Cadastrar', 'route' => 'acoes.create', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Ação Cadastrar[Salvar]', 'route' => 'acoes.store', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Ação Atualizar', 'route' => 'acoes.edit', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Ação Atualizar[Salvar]', 'route' => 'acoes.update', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Ação Excluir', 'route' => 'acoes.destroy', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],

            ['title' => 'Ação/Papel Salvar', 'route' => 'acaopapel.store', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Ação/Papel Excluir', 'route' => 'acaopapel.destroy', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],

            ['title' => 'Menus', 'route' => 'menus.index', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Menus Cadastrar Pais', 'route' => 'menus.pais.store', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Menus Atualizar Pais', 'route' => 'menus.pais.update', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Menus Excluir Pais', 'route' => 'menus.pais.destroy', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Menus Cadastrar Filho', 'route' => 'menus.filhos.store', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Menus Atualizar Filhos', 'route' => 'menus.filhos.update', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Menus Excluir Filho', 'route' => 'menus.filhos.destroy', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],

            ['title' => 'Usuários', 'route' => 'usuarios.index', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Usuário Informações', 'route' => 'usuarios.show', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Usuário Cadastrar', 'route' => 'usuarios.create', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Usuário Cadastrar[Salvar]', 'route' => 'usuarios.store', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Usuário Atualizar', 'route' => 'usuarios.edit', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Usuário Atualizar [salvar]', 'route' => 'usuarios.update', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Usuário Criar Papel', 'route' => 'usuarios.roleCreate', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Usuário Excluir Papel', 'route' => 'usuarios.roleDelete', 'app_id' => $app_id, 'active' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ];

        DB::table('app_action')->insert($actionAdmin);


    }
}