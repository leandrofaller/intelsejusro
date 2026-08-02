<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Users extends Authenticatable
{
    protected $table = 'users';
    protected $fillable = ['nome','cpf','matricula','rg','email','password','orgao_expedidor',
        'sexo','estado_civil_id','dt_nascimento','nome_mae','nome_pai','rua','numero','complemento',
        'bairro','cidade_id','cep','fone_fixo','celular','foto','active', 'unidade_id', 'perfil' , 'anexodocumento'];
    protected $guarded = array('password');
    protected $hidden = array('password', 'remember_token');


    public function papeis()
    {
        return $this->hasMany('App\Models\Admin\AppRoleUser', 'user_id', 'id');
    }

    public function unidades(){
        return $this->belongsTo('App\Models\Admin\Unidades','unidade_id', 'id');
    }

    public function getRolesList($idUser)
    {
        return DB::table('app_role_user as aru')
            ->join('app_role as ar','ar.id','=','aru.app_role_id')
            ->where('aru.user_id',$idUser)
            ->where('ar.app_id', 1)
            ->orderby('ar.name','ASC')
            ->pluck('ar.name','ar.id');
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
            ->where('ar.app_id',1)
            ->orderby('ar.name','ASC')
            ->first();
    }

    public function RenderMenu()
    {
        return DB::table('app_menu as am')
            ->where('am.app_role_id',Session::get('app_role_id'))
            ->orderby('order','ASC')
            ->select('am.id','am.icon','am.title')
            ->get();
    }

    public function AcionsRole($app_role_id)
    {
        return  DB::table('app_action')
            ->join('app_action_role', 'app_action.id', '=', 'app_action_role.app_action_id')
            ->where('app_action.active', '=', 'TRUE')
            ->where('app_action_role.app_role_id', '=', $app_role_id)
            ->pluck('app_action.route');
    }

}
