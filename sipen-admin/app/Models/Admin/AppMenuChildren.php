<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class AppMenuChildren extends Model
{
    protected $table = 'app_menu_children';
    protected $fillable = ['title','icon','order','app_menu_id','app_action_id'];

    public static function RenderMenuChildren($idMenu)
    {
        return DB::table('app_menu_children as amc')
            ->join('app_action as ac','ac.id','=','amc.app_action_id')
            ->where('amc.app_menu_id',$idMenu)
            ->where('ac.active','1')
            ->orderby('order','ASC')
            ->select('ac.route','amc.id','amc.app_action_id','amc.icon','amc.title')
            ->get();
    }
}
