<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AppRoleUser extends Model
{
    protected $table    = 'app_role_user';
    protected $fillable = ['app_role_id', 'user_id'];

    public function papel()
    {
        return $this->belongsTo('App\Models\Admin\AppRole', 'app_role_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Users', 'user_id');
    }

    public function polos()
    {
        return $this->hasMany('App\Models\Admin\AppRoleUserPolo', 'app_role_user_id');
    }
}
