<?php

namespace App\Http\Controllers;

use App\Model\Apenado;
use App\Model\Unidade;
use Illuminate\Http\Request;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use DB;

class MapController extends Controller
{
    public function index()
    {

        Mapper::map(-10, -62, ['marker' => false]);
        $collection = DB::table('unidades as u')
            ->Where('u.latitude','!=', '')
            ->Where('u.longitude','!=', '')
            ->get();
        $collection->each(function($address)
        {
            $content1 = $address->nomeunidade;
            $total = Apenado::contaApenadoUnidade($address->id)[0];
            $content = 'Nome Unidade: ' .  $content1 . ' <hr> Total de Apenados: ' . $total ;
            Mapper::informationWindow($address->latitude, $address->longitude, $content);
        });

        return view('mapa.index', compact('collection'));

    }
}
