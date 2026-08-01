<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\CargosFaccao;
use DB;

class Faccao extends Model
{
    protected $table = 'faccoes';
    protected $fillable = ['id', 'nomefaccao', 'sigla', 'anofundacao', 'origem', 'historico', 'cor'];

    public function cargosfaccoes()
    {
        return $this->hasMany('App\Model\CargosFaccao');
    }

    //MOSTRA SIGLA FACÇÃO
    public static function mostraSiglaFaccao($id)
    {
        if (($id == 0) or ($id == '')) {
            return "Nenhum";
        } else {
            $mostra = Faccao::find($id);
            if (empty($mostra->sigla)) {
                return '';
            } else {
                return $mostra->sigla;
            }
        }

    }

    //MOSTRA SIGLA FACÇÃO
    public static function mostraNomeFaccao($id)
    {
        if (($id == 0) or ($id == '')) {
            return "Nenhum";
        } else {
            $mostra = Faccao::find($id);
            if (empty($mostra->nomefaccao)) {
                return '';
            } else {
                return $mostra->nomefaccao;
            }
        }

    }


    //AUXILIARES
    public static $cores = [
        'red' => 'Vermelho',
        'blue' => 'Azul',
        'green' => 'Verde',
        'yellow' => 'Amarelo',
        'purple' => 'Roxo',
        'black' => 'Preto',
    ];

//BUSCA COR PREDOMINANTE DA FACÇÃO PELA SIGLA
    public static function mostraCorFaccao($sigla)
    {
        $result = DB::table('faccoes as f')
            ->Where('f.sigla', $sigla)
            ->first();
        if (empty($result))
            return '';
        else {
            return $result->cor;
        }
    }
}