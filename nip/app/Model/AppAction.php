<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AppAction extends Model
{
    protected $table    = 'app_action';
    protected $fillable = ['title', 'route', 'app_id', 'active'];


    public function sistema()
    {
        return $this->belongsTo('App\Model\App', 'app_id');
    }


}
