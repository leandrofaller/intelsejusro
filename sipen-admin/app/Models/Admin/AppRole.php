<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AppRole extends Model
{
    protected $table    = 'app_role';

    protected $guarded  = [];

    protected $fillable = ['name', 'app_id','active'];

    public function sistema()
    {
        return $this->belongsTo('App\Models\Admin\App', 'app_id');
    }

    public function usuarios()
    {
        return $this->hasMany('App\Models\Admin\AppRoleUser', 'app_role_id');
    }

    public function acoes()
    {
        return $this->hasMany('App\Models\Admin\AppActionRole', 'app_role_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Admin\Role', 'role_id');
    }
}
