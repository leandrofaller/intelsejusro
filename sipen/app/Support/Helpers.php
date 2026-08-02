<?php
use Carbon\Carbon;
use App\Model\AppMenuChildren;

function zeroAsquerda($numero)
{
   return str_pad($numero, 4, "0", STR_PAD_LEFT);  // retorno "0000000007"
}

//status do relatório de produção
function statusRelatorio($status)
{
    switch ($status) {
        case 1:
            return 'warning';
            break;
        case 2:
            return 'info';
            break;
        case 3:
            return 'success';
            break;
        case 4:
            return 'danger';
            break;
    }
}

function geraToken($tamanho = 5, $maiusculas = true, $numeros = true)
{

// Caracteres de cada tipo
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
// Variáveis internas
    $retorno = '';
    $caracteres = '';
// Agrupamos todos os caracteres que poderão ser utilizados
    $caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
    if ($numeros) $caracteres .= $num;
// Calculamos o total de caracteres possíveis
    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {
// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
        $rand = mt_rand(1, $len);
// Concatenamos um dos caracteres na variável $retorno
        $retorno .= $caracteres[$rand - 1];
    }
    return    $retorno ;
}


function geraChave($id){
    $hash = strtoupper(uniqid($id));

    $parte_um = substr($hash, 0, 4);
    $parte_dois = substr($hash, 4, 4);
    $parte_tres = substr($hash, 8, 4);
    $parte_quatro = substr($hash, 12, 2);

    return "$parte_um.$parte_dois.$parte_tres-$parte_quatro";
}

function icon($ico)
{
    echo "<i class=\"fa fa-{$ico}\"></i> ";
}

function MenusChildren($idMenu)
{
    return AppMenuChildren::RenderMenuChildren($idMenu);
}

function MotivoTemporarias($motivo){
    switch ($motivo) {
        case '1': $motivo = 'Falecimento de Familiar'; break;
        case '2': $motivo = 'Atendimento Médico / Hospitalar'; break;
        case '3': $motivo = 'Delegacia'; break;
        case '4': $motivo = 'Forum'; break;
        case '5': $motivo = 'Cartório'; break;
        case '6': $motivo = 'Banco'; break;
        case '7': $motivo = 'Inss'; break;

        case '8': $motivo = 'Visita de Familiar (07 dias)'; break;
        case '9': $motivo = 'Frequência a Curso'; break;
        case '10': $motivo = 'Projeto de Ressocialização'; break;
        case '11': $motivo = 'Ordem Judicial'; break;
    }
    return $motivo;
}

function TipoTemporarias($motivo){
    switch ($motivo) {
        case '1': $motivo = 'PERMISSÃO DE SAÍDA'; break;
        case '2': $motivo = 'SAÍDA TEMPORÁRIA'; break;
        }
    return $motivo;
}


function idade($datanascimento)
{
    // $data = '29/08/2008';

    // Separa em dia, mês e ano
    list($dia, $mes, $ano) = explode('/', $datanascimento);

    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $datanascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $datanascimento) / 60) / 60) / 24) / 365.25);
    return $idade;
}

function dataFormat($data, $hora = null)
{
//    if ($data instanceof DateTime)
//    {
    //se passado $hora = true como parametro ele mostra Data:Hora
    if ($hora != false) {
        return date('d/m/Y H:i:s', strtotime($data));
    } //Se não mostrar soemente a Data
    else {
        return date('d/m/Y', strtotime($data));
    }
}

function data_extenso($date)
{
    $mes = MesFormatado(date('m',strtotime($date)));
    return 'Porto Velho, ' .date('d',strtotime($date)). ' de '.$mes.' '.date('Y',strtotime($date));
}

function tiposaida($tipo){
    switch ($tipo) {

//        case '1': $tipo = 'Transferência'; break;
//        case '10': $tipo = 'Abandono'; break;
//        case '11': $tipo = 'Fuga'; break;
//        case '4': $tipo = 'Soltura'; break;
//        case '7': $tipo = 'Óbito'; break;
//        case '13': $tipo = 'Saída Temporária'; break;
//        case '14': $tipo = 'Prisão Domiciliar'; break;

        case '1': $tipo = 'Transferência'; break;
        case '2': $tipo = 'Transferência'; break;
        case '3': $tipo = 'Transferência'; break;

        case '4': $tipo = 'Solto'; break;
        case '5': $tipo = 'Solto'; break;
        case '6': $tipo = 'Solto'; break;

        case '7': $tipo = 'Óbito'; break;
        case '8': $tipo = 'Óbito'; break;
        case '9': $tipo = 'Óbito'; break;

        case '10': $tipo = 'Evasão / Abandono'; break;
        case '11': $tipo = 'Fuga'; break;
        case '12': $tipo = 'Fuga'; break;
        case '15': $tipo = 'Preso em Trânsito'; break;
        case '16': $tipo = 'Preso Recambiado'; break;

    }
    return $tipo;
}


function legenda($tipo){
    switch ($tipo) {


        case '1': $tipo = 'Aguardando Recebimento'; break;
        case '2': $tipo = 'Aguardando Recebimento'; break;
        case '3': $tipo = 'Aguardando Recebimento'; break;

        case '4': $tipo = 'Solto'; break;
        case '5': $tipo = 'Solto'; break;
        case '6': $tipo = 'Solto'; break;

        case '7': $tipo = 'Óbito'; break;
        case '8': $tipo = 'Óbito'; break;
        case '9': $tipo = 'Óbito'; break;

        case '10': $tipo = 'Fuga'; break;
        case '11': $tipo = 'Fuga'; break;
        case '12': $tipo = 'Fuga'; break;

        case '13': $tipo = 'Saída Temporária'; break;
        case '14': $tipo = 'Prisão Domiciliar'; break;



    }
    return $tipo;
}



function verificaMes($mes){

    switch ($mes) {
        case '01': $mes = 'JANEIRO'; break;
        case '02': $mes = 'FEVEREIRO'; break;
        case '03': $mes = 'MARÇO'; break;
        case '04': $mes = 'ABRIL'; break;
        case '05': $mes = 'MAIO'; break;
        case '06': $mes = 'JUNHO'; break;
        case '07': $mes = 'JULHO'; break;
        case '08': $mes = 'AGOSTO'; break;
        case '09': $mes = 'SETEMBRO'; break;
        case '10': $mes = 'OUTUBRO'; break;
        case '11': $mes = 'NOVEMBRO'; break;
        case '12': $mes = 'DEZEMBRO'; break;
    }
    return $mes;
}

function verificastatus($idApen)
{

    $status = \App\Model\Apenado::situacaoAtual($idApen);
    if ($status == 'Apenado Preso') {
       return $legenda = "<span class=\"label label-grey arrowed\">Apenado Preso</span>";
    } elseif ($status == 'Aguardando Recebimento') {
       return $legenda = "<span class=\"label label-warning arrowed\">Aguardando Recebimento</span>";
    } elseif ($status == 'Sinistro') {
        $legenda1 = \App\Model\Apenado::mostraSinistro($idApen);
       return $legenda = "<span class=\"label label-danger arrowed\"> $legenda1 </span>";

    } else {
        $legenda2 = tiposaida($status);
        if (($status == 4) or ($status == 5) or ($status == 6)) {
           return $legenda = "<span class=\"label label-success arrowed\"> $legenda2 </span>";
        } else {
           return $legenda = "<span class=\"label label-purple arrowed\"> $legenda2 </span>";
        }
    }

}

function corPorSiglaFaccaoHelper($sigla)
{
    $cor = \App\Model\Faccao::mostraCorFaccao($sigla);
    switch ($cor) {
        case 'red': $cor = 'danger'; break;
        case 'blue': $cor = 'info'; break;
        case 'green': $cor = 'success'; break;
        case 'yellow': $cor = 'warning'; break;
        case 'purple': $cor = 'purple'; break;
        case 'black': $cor = 'inverse'; break;
    }
    return $cor;
}

//função para pegar dias do mes / ano bisexto
function diasMes($mes, $ano)
{
    return cal_days_in_month(CAL_GREGORIAN, $mes, $ano); // 31
}


//funcao calcular dias entre duas datas
function calculaDias($di, $df)
{
        //if a data fim for null - manda a data do dia
    if(empty($df)){
        $df = date('Y-m-d');
    }
        // Usa a função strtotime() e pega o timestamp das duas datas:
    $dti = strtotime($di);
    $dtf = strtotime($df);
        // Calcula a diferença de segundos entre as duas datas:
    $result = $dtf - $dti; // segundos
        // Calcula a diferença de dias
    $dias = (int)round( $result / (60 * 60 * 24)); // 225 dias
    return $dias;
}

function calculaQtdMeses($di, $df){
     if(empty($df)){
         $df = date('Y-m-d');
     }
        // Usa a função strtotime() e pega o timestamp das duas datas:
    $dti = strtotime($di);
    $dtf = strtotime($df);
    $result = $dtf - $dti; // segundos
    return $meses = round($result / (60 * 60 * 24 * 30));
}

function datamaior($di, $df, $dbaixa)
{
    $hoje = strtotime(date('Y-m-d'));
    $dti = strtotime($di);
    $dtf = strtotime($df);
    if($dbaixa == null) {
        if ($dtf > $hoje) {
            return "<span class=\"badge badge-success\">EM CUMPRIMENTO</span>";
        } elseif ($dtf == $hoje) {
            return "<span class=\"badge badge-warning\">VENCE HOJE</span>";
        } elseif ($dtf < $hoje) {
            return "<span class=\"badge badge-danger\">VENCIDO</span>";
        }
    }else{
        return "<span class=\"badge badge-info\">BAIXADO</span>";
    }
}


