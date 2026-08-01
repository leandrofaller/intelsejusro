<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Galerias extends Model
{
    protected $table = 'galerias';
    protected $fillable = ['id', 'titulo','descricao', 'imagem', 'publico', 'fk_categoria', 'fk_user'];

    public function categorias()
    {
        return $this->belongsTo('App\Model\GaleriaCategoria', 'fk_categoria', 'id');
    }


    public function users()
    {
        return $this->belongsTo('App\Model\User', 'fk_user', 'id');
    }


    //AUXILIARES
    public static $restricao = [
        'PÚBLICO' => 'PÚBLICO',
        'SIGILOSO' => 'SIGILOSO'
    ];


}
