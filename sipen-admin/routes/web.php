<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Redirect::route('admin.login');
});


//Routes Admin Login
Route::get('admin/login', 'Admin\LoginController@login')->name('admin.login');
Route::post('admin/login', 'Admin\LoginController@loginPost')->name('admin.login.post');;
Route::get('admin/selectRole', 'Admin\LoginController@selectRole')->name('admin.selectRole');;
Route::post('admin/selectRole', 'Admin\LoginController@selectRolePost')->name('admin.selectRole.post');;
Route::get('admin/logout', 'Admin\LoginController@logout')->name('admin.logout');;
//End Admin Login
//Route::resource('email', 'Admin\EmailController@confirmaacesso')->name('admin.email.confirmaacesso');;

//Group of routes for Admin
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('cidades/{idEstado}', 'Admin\CidadesController@index')->name('cidades.index');

    Route::get('/', 'Admin\HomeController@index')->name('homeAdmin.index');
    Route::get('sistemas', 'Admin\SistemasController@index')->name('sistemas.index');
    Route::get('sistemas/create', 'Admin\SistemasController@create')->name('sistemas.create');
    Route::post('sistemas/store', 'Admin\SistemasController@store')->name('sistemas.store');
    Route::get('sistemas/edit/{id}', 'Admin\SistemasController@edit')->name('sistemas.edit');
    Route::post('sistemas/update/{id}', 'Admin\SistemasController@update')->name('sistemas.update');
    Route::post('sistema/destroy/{id}', 'Admin\SistemasController@destroy')->name('sistemas.destroy');
    Route::post('sistemas/configuracao/{id}', 'Admin\SistemasController@configuracao')->name('sistemas.configuracao');


    Route::get('acoes', 'Admin\AcoesController@index')->name('acoes.index');
    Route::get('acoes/create', 'Admin\AcoesController@create')->name('acoes.create');
    Route::post('acoes/store', 'Admin\AcoesController@store')->name('acoes.store');
    Route::get('acoes/edit/{id}', 'Admin\AcoesController@edit')->name('acoes.edit');
    Route::post('acoes/update/{id}', 'Admin\AcoesController@update')->name('acoes.update');
    Route::get('acoes/destroy/{id}', 'Admin\AcoesController@destroy')->name('acoes.destroy');


    Route::get('papeis', 'Admin\PapeisController@index')->name('papeis.index');
    Route::get('papeis/create', 'Admin\PapeisController@create')->name('papeis.create');
    Route::post('papeis/store', 'Admin\PapeisController@store')->name('papeis.store');
    Route::get('papeis/edit/{id}', 'Admin\PapeisController@edit')->name('papeis.edit');
    Route::post('papeis/update/{id}', 'Admin\PapeisController@update')->name('papeis.update');
    Route::get('papeis/destroy/{id}', 'Admin\PapeisController@destroy')->name('papeis.destroy');

    Route::get('acaopapel', 'Admin\AcaoPapelController@index')->name('acaopapel.index');
    Route::get('acaopapel/create/{idPapel}', 'Admin\AcaoPapelController@create')->name('acaopapel.create');
    Route::post('acaopapel/store', 'Admin\AcaoPapelController@store')->name('acaopapel.store');
    Route::post('acaopapel/destroy/{id}', 'Admin\AcaoPapelController@destroy')->name('acaopapel.destroy');

    Route::get('usuarios', 'Admin\UsuariosController@index')->name('usuarios.index');
    Route::get('usuarios/show/{id}', 'Admin\UsuariosController@show')->name('usuarios.show');
    Route::get('usuarios/create', 'Admin\UsuariosController@create')->name('usuarios.create');
    Route::post('usuarios/store', 'Admin\UsuariosController@store')->name('usuarios.store');
    Route::get('usuarios/edit/{id}', 'Admin\UsuariosController@edit')->name('usuarios.edit');
    Route::post('usuarios/update/{id}', 'Admin\UsuariosController@update')->name('usuarios.update');
    Route::post('usuarios/create_role', 'Admin\UsuariosController@createRole')->name('usuarios.create_role');

    Route::post('usuarios/createRegiao', 'Admin\UsuariosController@createRegiao')->name('usuarios.createRegiao');

    Route::get('usuarios/delete_role/{idRole}/{idUsuario}', 'Admin\UsuariosController@deleteRole')->name('usuarios.delete_role');
    Route::get('usuarios/reset_password/{idUser}', 'Admin\UsuariosController@resetPassword')->name('usuarios.reset_password');
    Route::get('usuarios/AtivarInativar/{idUser}/{status}', 'Admin\UsuariosController@AtivarInativarUser')->name('usuarios.ativar_inativar');
    Route::get('usuarios/deletar/{idUser}', 'Admin\UsuariosController@deletar')->name('usuarios.deletar');


    Route::get('menus', 'Admin\MenusController@index')->name('menus.index');
    Route::post('menus/pais/store', 'Admin\MenusController@storePais')->name('menus.pais.store');
    Route::post('menus/pais/update/{id}', 'Admin\MenusController@updatePais')->name('menus.pais.update');
    Route::get('menus/pais/destroy/{id}', 'Admin\MenusController@destroyMenuPais')->name('menus.pais.destroy');
    Route::post('menus/filhos/store', 'Admin\MenusController@storeFilhos')->name('menus.filhos.store');
    Route::post('menus/filhos/update/{id}', 'Admin\MenusController@updateFilhos')->name('menus.filhos.update');
    Route::get('menus/filhos/destroy/{id}', 'Admin\MenusController@destroyMenuFilho')->name('menus.filhos.destroy');


    Route::post('papel_usuario_polo/store', 'Admin\PapelUsuarioPoloController@store')->name('papel_usuario_polo.store');
    Route::get('papel_usuario_polo/edit/{id}', 'Admin\PapelUsuarioPoloController@edit')->name('papel_usuario_polo.edit');
    Route::post('papel_usuario_polo/destroy/{id}', 'Admin\PapelUsuarioPoloController@destroy')->name('papel_usuario_polo.destroy');

    Route::get('logger', 'Admin\LoggerController@index')->name('logger.index');

});
//End routes Admin
