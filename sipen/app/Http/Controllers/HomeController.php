<?php

namespace App\Http\Controllers;

use App\Model\Apenado;
use App\Model\Carceragem;
use App\Model\Faccao;
use App\Model\Integrantes;
use App\Model\Movimentacao;
use App\Model\Temporaria;
use Charts;
use Illuminate\Http\Request;
use App\Model\Unidade;
use DB;
use Illuminate\Support\Facades\Auth;
use Flash;
use Khill\Lavacharts\Lavacharts;
use Lava;

class HomeController extends Controller
{
    private $unidadesModel;
    private $faccaoModel;
    private $carcModel;
    public function __construct(Unidade $unidadesModel, Faccao $faccaoModel, Carceragem $carcModel)
    {
        $this->unidadesModel = $unidadesModel ;
        $this->faccaoModel = $faccaoModel;
        $this->carcModel = $carcModel;
    }

    public function index()
    {
        //Pega Usuario Logado
        $perfil = Auth::user()->perfil;
        $idUnid = Auth::user()->unidade_id;
        try
        {
            //**PERFIL*ADMIN****************************************************************************************
           if($perfil == 'Admin') {
//               $v['fugas'] = DB::table('processos as p')
//                   ->join('apenados as a', 'a.id', '=', 'p.apenado_id')
//                   ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
//                   ->join('fugas as f', 'f.processo_id', '=', 'p.id')
//                   ->where('f.datarecaptura', NULL)
//                   ->get();

//               //MOSTRA APENADOS QUE ESTÃO AGUARDANDO RECEBIMENTO NA UNIDADE
//               $v['recebimento'] = DB::table('processos as p')
//                   ->join('apenados as a', 'a.id', '=', 'p.apenado_id')
//                   ->join('movimentacoes as m', 'm.processo_id', '=', 'p.id')
//                   ->Where('m.cela_id', NULL)
//                   ->where('m.regime', '')
//                   ->orderby('a.nomeapenado', 'desc')
//                   ->get();
               $v['totalGeral'] = DB::table('movimentacoes as m')
                   ->Where('m.datasaida', null)
                   ->select(DB::raw("COUNT(m.unidade_id) as total"))
                   ->pluck('total');


               $v['totalGeralFaccionados'] = DB::table('integrantes as i')
                   ->join('apenados as a', 'a.id','=','i.apenado_id')
                   ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
                   ->join('processos as p', 'a.id','=','p.apenado_id')
                   ->join('movimentacoes as m', 'm.processo_id','=','p.id')
                   ->Where('i.datasaida', NULL )
                   ->Where('i.faccao_possiveis_id', 1) //1=comprovado
                   ->Where('m.datasaida', NULL )
                   ->select(DB::raw("COUNT(i.faccao_id) as total"))
                   ->pluck('total');

               $v['unidades'] = $this->unidadesModel->where('recebeapenados', 'Sim')->orderBy('nomeunidade')->get();

               $v['faccoes'] = $this->faccaoModel->orderby('id', 'asc')->get();


               $v['chart'] =  Charts::create('line', 'highcharts')
                   ->title('My nice chart')
                   ->labels(['First', 'Second', 'Third'])
                   ->values([5,10,20])
                   ->dimensions(0,500);

               $v['chartUnidade'] = Charts::database(
                   DB::table('movimentacoes as m')
                       ->join('unidades as u', 'u.id', '=', 'm.unidade_id')
                       ->where('m.datasaida', NULL)
                       ->get(), 'pie', 'highcharts')
                   ->title("GRÁFICO PRESOS POR UNIDADES PRISIONAIS")
                   ->labels('u.nomeunidade')
                   ->dimensions(1000, 800)
                   ->responsive(true)
                   ->groupBy('nomeunidade'); // Usuários vão ser agrupados pelo campo série


               $v['chartFaccoes'] = Charts::database(
                   DB::table('faccoes as f')
                      ->join('integrantes as i', 'f.id', '=', 'i.faccao_id')
                       ->where('i.datasaida', NULL)
                       ->Where('i.faccao_possiveis_id', 1) //1=comprovado
                       ->get(), 'pie', 'highcharts')
                   ->title("REPRESENTATIVIDADE DE FACÇÕES")
                   ->labels('f.sigla')
                   ->dimensions(1000, 500)
                   ->responsive(true)
                   ->groupBy('sigla'); // Usuários vão ser agrupados pelo campo série

               $v['chartFaccoesPossiveis'] = Charts::database(
                   DB::table('faccoes as f')
                       ->join('integrantes as i', 'f.id', '=', 'i.faccao_id')
                       ->where('i.datasaida', NULL)
                       ->Where('i.faccao_possiveis_id', '<>', 1) //1=comprovado
                       ->get(), 'pie', 'highcharts')
                   ->title("REPRESENTATIVIDA DE POSSÍVEIS FACCIONADOS")
                   ->labels('f.sigla')
                   ->dimensions(1000, 500)
                   ->responsive(true)
                   ->groupBy('sigla'); // Usuários vão ser agrupados pelo campo série



               $v['chartFaccoesUnidades'] = Charts::database(
                      DB::table('movimentacoes as m')
                           ->join('processos as p', 'p.id', '=', 'm.processo_id')
                           ->join('apenados as a', 'a.id', '=', 'p.apenado_id')
                           ->join('unidades as u', 'u.id', '=', 'm.unidade_id')
                           ->join('integrantes as i', 'i.apenado_id', '=', 'a.id')
                           ->join('faccoes as f', 'f.id', '=', 'i.faccao_id')
                           ->where('m.datasaida', NULL)
                           ->where('i.datasaida', NULL)
                          ->Where('i.faccao_possiveis_id', 1) //1=comprovado

                          ->get(), 'bar', 'highcharts')

                       ->title("FACÇÕES POR UNIDADE PRISIONAL")
                       ->elementLabel('FACÇÕES')
                       ->labels('u.nomeunidade')
                       ->dimensions(1000, 800)
                       ->responsive(true)
                       ->groupBy('nomeunidade' ); // Usuários vão ser agrupados pelo campo nomeunidade



               $v['chartTodasFaccoesUnidades'] = Charts::multiDatabase('bar', 'material')
                   ->dataset('Unidades ', Unidade::all())
                   ->dataset('Facções', Faccao::all())
                   ->groupBy('nomeunidade');

//                   $v['chartTodasFaccoesUnidades'] = Charts::multi('bar', 'material')
//                   // Setup the chart settings
//                   ->title("My Cool Chart")
//                   // A dimension of 0 means it will take 100% of the space
//                   ->dimensions(0, 400) // Width x Height
//                   // This defines a preset of colors already done:)
//                   ->template("material")
//                   // You could always set them manually
//                    ->colors(['#2196F3', '#F44336', '#FFC107'])
//                   // Setup the diferent datasets (this is a multi chart)
//                   ->dataset('Element 1', [5,20,100])
//                   ->dataset('Element 2', [15,30,80])
//                   ->dataset('Element 3', [25,10,40])
//                   // Setup what the values mean
//                   ->labels(['One', 'Two', 'Three']);

               //GRAFICO LARACHART - GOOGLE
//               $viewer = View::select(DB::raw("SUM(numberofview) as count"))
//                   ->orderBy("created_at")
//                   ->groupBy(DB::raw("year(created_at)"))
//                   ->get()->toArray();

               return view('home.index', $v);
               //*******************************************************************************************
           }elseif($perfil == 'Servidor') {
                    //**PERFIL*SERVIDOR*********************************************************************
                    $v['unidades'] = $this->unidadesModel->where('recebeapenados', 'Sim')->where('regiao_id', Auth::user()->regiao_id)->orderBy('nomeunidade')->get();
                    $v['faccoes'] = $this->faccaoModel->orderby('id', 'asc')->get();

                    return view('home.index', $v);
                   //*******************************************************************************************
            }else{
                   //**PERFIL*EXTERNO***************************************************************************
                   return view('home.index');
                   //*******************************************************************************************

           }


        }
        catch (\Exception $e)
        {
            return $e;
            return redirect()->back();
        }

    }




}
