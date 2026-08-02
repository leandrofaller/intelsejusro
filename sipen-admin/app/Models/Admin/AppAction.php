<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AppAction extends Model
{
    protected $table    = 'app_action';
    protected $fillable = ['title', 'route', 'app_id', 'active'];


    public function sistema()
    {
        return $this->belongsTo('App\Models\Admin\App', 'app_id');
    }


}
