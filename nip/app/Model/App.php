<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $table    = 'app';

    protected $guarded  = [];

    protected $fillable = ['name', 'url', 'active'];
}
