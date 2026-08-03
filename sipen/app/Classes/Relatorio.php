<?php
/**
 * Created by PhpStorm.
 * User: mmc
 * Date: 17/11/16
 * Time: 18:06
 */

namespace App\Classes;

use PDF;

class Relatorio
{

    private function gerar_pdf($titulo, $com_ou_sem_Header, $conteudo, $nome_do_arquivo, $orientacao_pagina) {
        // para geração de PDFs, utilizamos a biblioteca open source TCPDF, disponível em https://tcpdf.org/

        // https://tcpdf.org/docs/license/
        // LICENSE
        // SOFTWARE  : tcpdf
        // AUTHOR    : Nicola Asuni
        // COPYRIGHT : 2002-2016 Nicola Asuni - Tecnick.com LTD
        //	-----------------------------------------------------------------------
        //  This is free software: you can redistribute it and/or modify it
        //  under the terms of the GNU Lesser General Public License as
        //  published by the Free Software Foundation, either version 3 of the
        //  License, or (at your option) any later version.
        //-----------------------------------------------------------------------
        //                   GNU LESSER GENERAL PUBLIC LICENSE
        //                       Version 3, 29 June 2007
        // Copyright (C) 2007 Free Software Foundation, Inc.
        //	Everyone is permitted to copy and distribute verbatim copies
        // of this license document, but changing it is not allowed.

        // Com base no exemplo 006 : WriteHTML() https://tcpdf.org/examples/example_006/
        // criamos um método público para facilitar a impressão e padronização dos PDFs
         define ('K_PATH_IMAGES', public_path()); // obtem o path do projeto para a logo no SetHeaderData
        $obj_tcpdf = new \TCPDF();
        $obj_tcpdf->SetAuthor('sejus');  // definindo o Autor do pdf
        $obj_tcpdf->SetTitle($titulo);  // definindo o Título do pdf
        $obj_tcpdf->SetSubject($titulo);  // definindo o SubTítulo do pdf

        if ($com_ou_sem_Header) {
//             se TRUE definir o conteúdo do header do pdf
//             nos diários por exemplo não tem header do PDF
            //           $obj_tcpdf->setPrintHeader(false); //tira a barra que aparece na header
            $obj_tcpdf->SetHeaderData('/sejus-ro.jpg', 10,
                'GOVERNO DO ESTADO DE RONDÔNIA',
                'SECRETARIA DE ESTADO DE JUSTIÇA');

        }
        $obj_tcpdf->SetMargins(5, 25, 5);
        $obj_tcpdf->SetHeaderMargin(5);
        $obj_tcpdf->SetRightMargin(5);
        $obj_tcpdf->SetFooterMargin(10);


        // definindo o estilo da fonte..
        $obj_tcpdf->SetFont('helvetica', '', 11);
        $obj_tcpdf->setHeaderFont(Array('helvetica', '', 14));

        // add página com orientação
        // https://tcpdf.org/examples/example_028/
        // $obj_tcpdf->AddPage('P', 'A4'); PORTRAIT / RETRATO
        // $obj_tcpdf->AddPage('L', 'A4'); LANDSCAPE / PAISAGEM
        $obj_tcpdf->AddPage($orientacao_pagina, 'A4');


        // repassando o conteúdo em html pra essa página
        $obj_tcpdf->writeHTML($conteudo);

        // definindo o fim da página
        $obj_tcpdf->lastPage();

        // nomeando o arquivo gerado
        // $arquivo_path = storage_path() . '/' . $nome_do_arquivo . '_' . date('Ymdhis') . '.pdf';
        $arquivo = $nome_do_arquivo . '_' . date('Y-m-d_His') . '.pdf';

        // gerando o arquivo em PDF
        // https://tcpdf.org/docs/source_docs/classTCPDF/#a3d6dcb62298ec9d42e9125ee2f5b23a1
        // I: gera o pdf no browser apenas
        // D: força o download apenas
        // F: salva no servidor local
        // S: return the document as a string (name is ignored).
        // FI: equivalent to F + I option
        // FD: equivalent to F + D option
        // E: return the document as base64 mime multi-part email attachment (RFC 2045)
        $obj_tcpdf->output($arquivo, 'I');

        // Salvando o LOG
        Logger::success('Gerado PDF', 'Gerado PDF: ' . $titulo . ' - ' . $arquivo);

        return Response::download($arquivo);
    }

    function gerar_pdf_retrato($titulo, $conteudo, $nome_do_arquivo)
    {
        //$cabecalho = $this->cabecalho();
        //$this->gerar_pdf($titulo, true, $cabecalho.$conteudo, $nome_do_arquivo, 'R');

        $this->gerar_pdf($titulo, true, $conteudo, $nome_do_arquivo, 'R');
    }


    function gerar_pdf_retrato_sem_header($titulo, $conteudo, $nome_do_arquivo) {
        $this->gerar_pdf($titulo, false, $conteudo, $nome_do_arquivo, 'R');
    }

    function gerar_pdf_paisagem($titulo, $conteudo, $nome_do_arquivo) {
        $this->gerar_pdf($titulo, true, $conteudo, $nome_do_arquivo, 'L');
    }

    function gerar_pdf_paisagem_sem_header($titulo, $conteudo, $nome_do_arquivo) {
        $this->gerar_pdf($titulo, false, $conteudo, $nome_do_arquivo, 'L');
    }

    function table_padrao_pdf_html() {
        return '<table border="1px" cellpadding="1px">';
    }

    function tr_header_table_padrao_pdf() {
        return '<tr align="center" style="font-weight: bold; font-size: 10px; background-color: #ddd; ">';
    }

    function tr_body_table_padrao_pdf() {
        return '<tr valign="middle" style="font-size: 7px; text-align: center; vertical-align: middle; ">';
    }
    function p_legenda_padrao_pdf() {
        return '<p style="font-size:7px;">';
    }

    function cabecalho()
    {
        return $this->css() . '<table class="table bordaBotton">
           <tr>
            <td class="centralizar"><img src="logo_estado.png" width="50px" height="45px"></td>
            </tr>
          <tr>
          <td class="centralizar td15">
          <br><br><br>
          <img src="sejus-ro.png" width="50px" height="30px"></td>
          <td colspan="10" class="centralizar td70">
          <p> <strong> INSTITUTO FEDERAL DE EDUCAÇÃO, CIÊNCIA E TECNOLOGIA DE RONDÔNIA </strong> <br><br>
          REDE e-TEC BRASIL/RONDÔNIA <br>
          <br>
          CAMPUS PORTO VELHO ZONA NORTE<br></p> </td>
          <td class="centralizar td15">
          <br><br><br>
          <img src="sejus-ro.png" width="35px" height="30px"> </td>
          </tr>
          </table>';
    }

    function css()
    {
        return '<style>.text-center{text-align: center} 
                .fundoCinza{background-color: #ccc;font-size:12pt}
                .formata{ padding: 10px}
                .table{width:100%;font-size:10pt}
                .td100{width:100%}
                .td90{width:90%}
                .td80{width:80%}
                .td70{width:70%}
                .td60{width:60%}
                .td50{width:50%}
                .td40{width:40%}
                .td30{width:30%}
                .td25{width:25%}
                .td20{width:20%}
                .td15{width:15%}
                .td10{width:10%}
                .td8{width:8%}
                .td7{width:7%}
                .td6{width:6%}
                .td5{width:5%}
                .td3{width:3%}
                .minusculo{text-transform:lowercase}
                .maiusculo{text-transform:uppercase}
                .justificar{text-align:justify}
                .centralizar{text-align:center}
                .borda{border:1px solid #ccc;}
                .bordaBotton{border-bottom:1px #ccc solid}
                .italico{font-style:italic}
                .underline{text-decoration:underline}
                </style>';
    }

    public function gerar_pdf_string($titulo, $conteudo, $orientacao_pagina = 'R') {
        if (!defined('K_PATH_IMAGES')) {
            define('K_PATH_IMAGES', public_path());
        }
        $obj_tcpdf = new \TCPDF();
        $obj_tcpdf->SetAuthor('sejus');
        $obj_tcpdf->SetTitle($titulo);
        $obj_tcpdf->SetSubject($titulo);

        $obj_tcpdf->SetHeaderData('/sejus-ro.jpg', 10,
            'GOVERNO DO ESTADO DE RONDÔNIA',
            'SECRETARIA DE ESTADO DE JUSTIÇA');
        
        $obj_tcpdf->SetMargins(5, 25, 5);
        $obj_tcpdf->SetHeaderMargin(5);
        $obj_tcpdf->SetRightMargin(5);
        $obj_tcpdf->SetFooterMargin(10);

        $obj_tcpdf->SetFont('helvetica', '', 11);
        $obj_tcpdf->setHeaderFont(Array('helvetica', '', 14));

        $obj_tcpdf->AddPage($orientacao_pagina, 'A4');
        $obj_tcpdf->writeHTML($conteudo);
        $obj_tcpdf->lastPage();

        return $obj_tcpdf->output($titulo . '.pdf', 'S');
    }

}