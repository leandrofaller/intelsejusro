<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AppRole extends Model
{
    protected $table    = 'app_role';

    protected $guarded  = [];

    protected $fillable = ['name', 'app_id','active'];

    public function sistema()
    {
        return $this->belongsTo('App\Model\App', 'app_id');
    }

    public function usuarios()
    {
        return $this->hasMany('App\Model\AppRoleUser', 'app_role_id');
    }

    public function acoes()
    {
        return $this->hasMany('App\Model\AppActionRole', 'app_role_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Model\Role', 'role_id');
    }
}
