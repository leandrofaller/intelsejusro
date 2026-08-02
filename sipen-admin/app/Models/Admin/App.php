<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $table    = 'app';

    protected $guarded  = [];

    protected $fillable = ['name', 'url', 'active'];

    public function papeis()
    {
        return $this->hasMany('App\Models\Admin\AppRole');
    }

    public function acoes()
    {
        return $this->hasMany('App\Models\Admin\AppAction');
    }
}
