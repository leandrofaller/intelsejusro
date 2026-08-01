<?php

namespace App\Model;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\Unidade;
use DB, Session, Redirect;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
//    protected $fillable = [
//        'nome', 'email','telefone','matricula', 'password', 'perfil','status', 'unidade_id'
//    ];
//
    protected $fillable = ['nome','cpf','matricula','rg','email','password','orgao_expedidor',
        'sexo','estado_civil_id','dt_nascimento','nome_mae','nome_pai','rua','numero','complemento',
        'bairro','cidade_id','cep','fone_fixo','celular','foto','active', 'unidade_id', 'perfil', 'anexodocumento'];

    public function unidades(){
        return $this->belongsTo('App\Model\Unidade','unidade_id', 'id');
    }

    protected $hidden = [
        'password', 'remember_token',
    ];


    //MOSTRA NOME SERVIDOR
    public static function NomeServidor($id)
    {
        $mostra = User::find($id);
        if(empty($mostra->nome))
        {
            return '';
        }else{
            return $mostra->nome;
        }
    }


    public function CountRoleUser($idUser,$AppId)
    {
        return DB::table('app_role_user as aru')
            ->join('app_role as ar','ar.id','=','aru.app_role_id')
            ->where('aru.user_id',$idUser)
            ->where('ar.app_id',$AppId)
            ->where('ar.active', 1)
            ->count();
    }

    public function GetRolesId($idUser)
    {
        return DB::table('app_role_user as aru')
            ->join('app_role as ar','ar.id','=','aru.app_role_id')
            ->where('aru.user_id',$idUser)
            ->where('ar.app_id',2)
            ->orderby('ar.name','ASC')
            ->first();
    }

    public function getRolesList($idUser)
    {
        return DB::table('app_role_user as aru')
            ->join('app_role as ar','ar.id','=','aru.app_role_id')
            ->where('aru.user_id',$idUser)
            ->where('ar.app_id', 2)
            ->orderby('ar.name','ASC')
            ->pluck('ar.name','ar.id');
    }

    public function getUnidadesList()
    {
        return DB::table('unidades')
            ->where('recebeapenados', 'Sim')
            ->orderby('nomeunidade','ASC')
            ->pluck('nomeunidade','id');
    }


    public function RenderMenu()
    {
        return DB::table('app_menu as am')
            ->where('am.app_role_id',Session::get('app_role_id'))
            ->orderby('order','ASC')
            ->select('am.id','am.icon','am.title', 'am.order' )
            ->get();
    }

    public function AcionsRole($app_role_id)
    {
        return  DB::table('app_action')
            ->join('app_action_role', 'app_action.id', '=', 'app_action_role.app_action_id')
            ->where('app_action.active', '=', 1)
            ->where('app_action_role.app_role_id', '=', $app_role_id)
            ->pluck('app_action.route');
    }


}
