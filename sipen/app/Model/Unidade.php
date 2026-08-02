<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Apenado;
use App\Model\User;
use App\Model\Carceragem;
use DB;


class Unidade extends Model
{
    protected $table = 'unidades';
    protected $fillable = ['id', 'nomeunidade', 'siglaunidade', 'cidadeunidade', 'tipoestabelecimento',
        'nomediretorgeral', 'cnpj', 'endereco', 'nomediretoradm', 'nomediretorseg', 'telefoneunidade',
        'categoria', 'capacidade', 'obs', 'latitude', 'longitude', 'recebeapenados', 'regiao_id'];

    public function apenados(){
        return $this->hasMany('App\Model\Apenado');
    }

    public function users(){
        return $this->hasMany('App\Model\User');
    }

    public function carceragem(){
        return $this->hasMany('App\Model\Carceragem');
    }

    public function movimentacoes(){
        return $this->hasMany('App\Model\Movimentacao');
    }


    //AUXILIARES
    public static $categorias = [
        '' => '',
        'Masculino' => 'Masculino',
        'Feminino' => 'Feminino',
        'Mista' => 'Mista',
        'Infopen' => 'Infopen',
    ];

    //AUXILIARES
    public static $recebeapenados = [
        '' => '',
        'Sim' => 'Sim',
        'Não' => 'Não'
    ];

    //AUXILIARES
    public static $tipo = [
        'NULL' => '',
        'trânsito' => 'trânsito',
        'recambiamento' => 'recambiamento'
    ];


    public static $tipoestabelecimento = [
        '' => '',
        'Penitenciária' => 'Penitenciária',
        'Cadeia Pública' => 'Cadeia Pública',
        'Casa de Detenção' => 'Casa de Detenção',
        'Casa de Albergado' => 'Casa de Albergado',
        'Centro de Ressocialização' => 'Centro de Ressocialização',
        'Colônia Penal' => 'Colônia Penal',
        'Patronato' => 'Patronato',
        'Presídio' => 'Presídio',
        'SemiAberto' => 'SemiAberto',
        'SemiAberto-Albergue' => 'SemiAberto-Albergue',
        'Unidade Medidas de Segurança' => 'Unidade Medidas de Segurança',
        'Infopen' => 'Infopen',
        'Recambiamento' => 'Recambiamento',

    ];


    //CONTA PRESOS POR CARCERAGEM
    public static function contaPresosCarceragem($idCarc)
    {
       // return $idCarc;

        return $conta = DB::table('movimentacoes as m')
            ->join('celas as c', 'c.id', '=' , 'm.cela_id')
           // ->join('carceragens as car', 'car.id', '=' , 'm.cela_id')
            ->Where('c.carceragem_id', $idCarc)
            ->Where('m.datasaida', null)
            ->Where('m.motivosaida', null)
            ->select(DB::raw("COUNT(m.cela_id) as total"))
            ->pluck('total')[0];


//        return $conta = DB::table('movimentacoes as m')
//            ->join('celas as c', 'c.id','=','m.cela_id')
//            ->join('carceragens as car', 'car.id','=','c.id')
//            ->Where('m.cela_id', '=', 'c.id')
//            ->Where('car.id', $idCarc)
        //    ->Where('m.datasaida','=', NULL )
          //  ->select(DB::raw("COUNT(m.id) as total"))
          //  ->pluck('total')[0];
//              ->get();
//        return $conta = DB::table('apenados as a')
//            ->join('processos as p', 'a.id','=','p.apenado_id')
//            ->join('movimentacoes as m', 'm.processo_id','=','p.id')
//            ->join('unidades as u', 'm.unidade_id','=','u.id')
//            ->join('carceragens as c', 'c.unidade_id','=','u.id')
//            ->join('celas as cl', 'cl.carceragem_id','=','c.id')
//            ->Where('m.cela_id', '=', 'cl.id')
//            ->Where('c.id', $idCarc)
//            ->Where('m.datasaida','=', NULL )
//            ->select(DB::raw("COUNT(a.id) as total"))
//            ->pluck('total')[0];


    }



    //CONTA QUANTIDADE DE CARCERAGENS NA UNIDADE
    public static function contaQtdCarceragem($idUnid)
    {
        return $conta = DB::table('carceragens as c')
            ->Where('c.unidade_id', $idUnid)
            ->select(DB::raw("COUNT(c.unidade_id) as total"))
            ->pluck('total')[0];

    }

    //CONTA QUANTIDADE DE CELAS NA UNIDADE
    public static function contaQtdCela($idUnid)
    {
        return $conta = DB::table('celas as c')
            ->join('carceragens as car', 'car.id', '=' , 'c.carceragem_id')
            ->Where('car.unidade_id', $idUnid)
            ->select(DB::raw("COUNT(car.unidade_id) as total"))
            ->pluck('total')[0];

    }



    //MOSTRA NOME UNIDADE
    public static function mostraNomeUnidade($id)
    {
        $mostra = Unidade::find($id);
        if(empty($mostra->nomeunidade))
        {
            return '';
        }else{
            return $mostra->nomeunidade;
        }
    }






}
