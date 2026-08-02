<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Cela;
use App\Model\Unidade;

class Carceragem extends Model
{
    protected $table = 'carceragens';
    protected $fillable = ['id', 'nomecarceragem', 'tipocarceragem', 'status', 'unidade_id','faccao'];

    public function unidades()
    {
        return $this->belongsTo('App\Model\Unidade', 'unidade_id', 'id');
    }

    public function celas(){
        return $this->hasMany('App\Model\Cela');
    }

    //AUXILIARES
    public static $tipo = [
        'Normal' => 'Normal',
        'Especial' => 'Especial',
    ];







}
