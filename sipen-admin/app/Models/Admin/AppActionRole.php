<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AppActionRole extends Model
{
    protected $table    = 'app_action_role';
    //protected $guarded  = [];
    protected $fillable = ['app_role_id','app_action_id'];

    //public $timestamps = false;

    public function acao()
    {
        return $this->belongsTo('App\Models\Admin\AppAction', 'app_action_id');
    }

    public function papel()
    {
        return $this->belongsTo('App\Models\Admin\AppRole', 'app_role_id');
    }
}
