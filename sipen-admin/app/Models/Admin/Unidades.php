<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
    protected $table = 'unidades';
    protected $fillable = ['id', 'nomeunidade', 'siglaunidade', 'cidadeunidade', 'tipoestabelecimento',
        'nomediretorgeral', 'nomediretoradm', 'nomediretorseg', 'telefoneunidade', 'categoria', 'capacidade', 'obs'];


    public function users(){
        return $this->hasMany('App\Models\Users');
    }


    //AUXILIARES
    public static $perfis = [
        '' => '',
        'Admin' => 'Acesso Master ao Sistema',
        'Servidor' => 'Acesso Servidor - Unidades Prisionais',
        'Externo' => 'Acesso Externo',
    ];


}
