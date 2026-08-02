<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Cidades;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CidadesController extends Controller
{
    public function __construct(Cidades $cidades)
    {
        $this->cidades = $cidades;

    }
    public function index($idEstado)
      {
         try
          {
              return $this->cidades->orderby('nome','asc')->where('estado_id',$idEstado)->get();
          }
          catch (\Exception $e)
           {
               return 'Erro Consulta';
           }
      }
}
