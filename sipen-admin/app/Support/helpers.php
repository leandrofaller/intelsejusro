<?php
use App\Models\Admin\AppMenuChildren;

function icon($ico)
{
    if ($ico == 'moodle') echo '<img src="/img/icon-moodle.png">';

    echo "<i class=\"fa fa-{$ico}\"></i> ";
}


function MenusChildren($idMenu)
{
    return AppMenuChildren::RenderMenuChildren($idMenu);
}


function confirm($msg = 'Confirma excluir?')
{
    return " onclick=\"return confirm('{$msg}');\"";
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

function horaFormatada($data)
{
    return date('H:i:s', strtotime($data));
}

function alert($alert)
{
    switch ($alert) {
        case 'I':
            return 'info';
            break;

        case 'S':
            return 'success';
            break;

        case 'W':
            return 'warning';
            break;

        case 'E':
            return 'danger';
            break;
    }

}

function alertIcon($alert)
{
    switch ($alert) {
        case 'I':
            return 'info';
            break;

        case 'S':
            return 'check';
            break;

        case 'W':
            return 'warning';
            break;

        case 'E':
            return 'bug';
            break;
    }

}


function cpf_valido($cpf)
{
    $c = preg_replace('/\D/', '', $cpf);
    if (strlen($c) != 11) {
        return false;
    }
    for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) ;
    if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
        return false;
    }
    for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) ;
    if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
        return false;
    }
    return true;
}