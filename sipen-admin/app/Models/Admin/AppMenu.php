<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB,Session;

class AppMenu extends Model
{
    protected $table    = 'app_menu';

    protected $guarded  = [];

    protected $fillable = ['title', 'icon', 'order','route', 'app_role_id'];

    public function acao()
    {
        return $this->belongsTo('App\Models\Admin\AppAction');
    }

    public function papel()
    {
        return $this->belongsTo('App\Models\Admin\AppRole');
    }

    public function menuPai()
    {
        return $this->belongsTo('App\Models\Admin\AppMenu', 'app_menu_id');
    }

    public function menusChildrens()
    {
        return $this->hasMany('App\Models\Admin\AppMenuChildren');
    }

}
