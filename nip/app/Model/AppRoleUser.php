<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class AppRoleUser extends Model
{
    protected $table    = 'app_role_user';
    protected $fillable = ['app_role_id', 'user_id'];

    public function papel()
    {
        return $this->belongsTo('App\Model\AppRole', 'app_role_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Model\Users', 'user_id');
    }

}
