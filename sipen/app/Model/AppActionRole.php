<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AppActionRole extends Model
{
    protected $table    = 'app_action_role';
    //protected $guarded  = [];
    protected $fillable = ['app_role_id','app_action_id'];

    //public $timestamps = false;

    public function acao()
    {
        return $this->belongsTo('App\Model\AppAction', 'app_action_id');
    }

    public function papel()
    {
        return $this->belongsTo('App\Model\AppRole', 'app_role_id');
    }
}
