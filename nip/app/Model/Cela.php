<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Carceragem;
use App\Model\Apenado;
class Cela extends Model
{
    protected $table = 'celas';
    protected $fillable = ['id', 'nomecela', 'tipocela', 'capacidade', 'status', 'carceragem_id'];

    public function carceragem()
    {
        return $this->belongsTo('App\Model\Carceragem', 'carceragem_id', 'id');
    }

    public function apenados(){
        return $this->hasMany('App\Model\Apenado');
    }

    public function movimentacoes(){
        return $this->hasMany('App\Model\Movimentacao');
    }


    //AUXILIARES
    public static $motivomudancadecela = [
        '' => '',
        'Convivência' => 'Convivência',
        'A Pedido' => 'A Pedido',
        'Mudança Sem Autorização' => 'Mudança Sem Autorização',
        'Medida Disciplinar' => 'Medida Disciplinar',
        'Saída Medida Disciplinar' => 'Saída Medida Disciplinar',
        'Entrada na Triagem' => 'Entrada na Triagem',
        'Saída da Triagem' => 'Saída da Triagem',
        'Outros' => 'Outros',
    ];


    //AUXILIARES
    public static $tipo = [
        'Normal' => 'Normal',
        'Igreja' => 'Igreja',
        'Escola' => 'Escola',
        'PNE' => 'PNE',
        'Idosos' => 'Idosos',
        'Medida Disciplinar' => 'Medida Disciplinar',
        'Triagem' => 'Triagem',
        'Isolamento' => 'Isolamento',
        'Inclusão' => 'Inclusão',

    ];
}
