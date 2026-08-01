<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    {{ HTML::style('resources/assets/css/visualizarRelatorio.css') }}
    {{--    {{ HTML::style('css/carteira-print.css') }}--}}
</head>
<body>
<div id="botonera">
    <button onClick="javascript:window.print();">Imprimir</button>
</div>



    <div id="page1">

        <div class="sigilo">
            {{ $producao->seguranca}}
        </div>

        <div class="bordeRecibo">
            <header>
                <!-- Lado Izquierdo -->
                <div class="column left">
                    <div class="container">
                        <div class="row text-left img1">
                            <img class="img1" src="{{asset('public/logo_estado.png')}}">
                        </div>
                    </div>
                </div>

                <!-- CENTRO  -->
                <div class="column center">
                    <div class="container">
                        <div class="row text-center">
                            <div class="row text-center negrita h3">GOVERNO DO ESTADO DE RONDÔNIA</div>
                            <div class="row text-center negrita h3">SECRETARIA DE ESTADO DE JUSTIÇA</div>
                            <div class="row text-center negrita h3">GERÊNCIA DE INFORMAÇÃO E INTELIGÊNCIA</div>
                            <div class="row text-center h4">"CHAVE DE AUTENTICAÇÃO: {{ $producao->chave }} "</div>
                        </div>
                    </div>
                </div>

                <!-- Lado Derecho -->
                <div class="column right">
                    <div class="container">
                        <div class="row text-right">
                            <img class="img2" src="{{asset('public/sejus-ro.png')}}" >
                        </div>
                    </div>
                </div>
            </header>


            <section id="sectionClilente1" >
                <table class="formatTabela" border="1" cellpadding="0" >
                    <tbody>
                    <tr style="height: 21px;">
                        <td class="negrita h3Left" style="height: 21px; width: 40%">{{ $producao->descricao }}</td>
                        <td class="negrita h3Left" style="height: 21px; width: 30%">{{ $producao->numero }}</td>
                        <td class="negrita h3Left" style="height: 21px; width: 30%">{{ $producao->origem ? $producao->origem : '**********' }}</td>
                    </tr>
                    </tbody>
                </table>

                <table class="formatTabela" border="1" cellpadding="0">
                    <tbody>
                    <tr class="formatTr">
                        <td class="negrita h3Left" style="height: 21px; width: 30%">DATA:</td>
                        <td class="negrita h3Left" style="height: 21px; width: 60%">{{ $producao->datarelatorio ? dataFormat($producao->datarelatorio) : '**********' }}</td>
                    </tr>
                    <tr class="formatTr">
                        <td class="negrita h3Left" style="height: 21px; width: 30%">ASSUNTO:</td>
                        <td class="negrita h3Left" style="height: 21px; width: 60%">{{ $producao->assunto ? $producao->assunto : '**********' }}</td>
                    </tr>
                    <tr class="formatTr">
                        <td class="negrita h3Left" style="height: 21px; width: 30%">ORIGEM</td>
                        <td class="negrita h3Left" style="height: 21px; width: 60%">{{ $producao->origem ? $producao->origem : '**********' }}</td>
                    </tr>
                    <tr class="formatTr">
                        <td class="negrita h3Left" style="height: 21px; width: 30%">DIFUSÃO: </td>
                        <td class="negrita h3Left" style="height: 21px; width: 60%">{{ $producao->difusao ? $producao->difusao : '**********' }}</td>
                    </tr>
                    <tr class="formatTr">
                        <td class="negrita h3Left" style="height: 21px; width: 30%">DIFUSÃO ANTERIOR: </td>
                        <td class="negrita h3Left" style="height: 21px; width: 60%">{{ $producao->difusaoanterior ? $producao->difusaoanterior : '**********' }}</td>
                    </tr>
                    <tr class="formatTr">
                        <td class="negrita h3Left" style="height: 21px; width: 30%">REFERÊNCIA: </td>
                        <td class="negrita h3Left" style="height: 21px; width: 60%">{{ $producao->referencia ? $producao->referencia : '**********' }}</td>
                    </tr>
                    <tr class="formatTr">
                        <td class="negrita h3Left" style="height: 21px; width: 30%">ANEXO: </td>
                        <td class="negrita h3Left" style="height: 21px; width: 60%">{{ $producao->anexo ? $producao->anexo : '**********' }}</td>
                    </tr>
                    </tbody>
                </table>


            </section>

            <section id="sectionDescricao" class="bordaDiscriminacao">
                    {!! $producao->conteudo !!}
            </section>

            <section id="" class="bordeSeguranca">
                <div class="bordeSegurancaLeft">
                    <img class="img3" src="{{asset('public/logogeii.jpeg')}}">
                </div>
                    <div class="bordeSegurancaCenter text-center" >
                        <p class="negrita h2 center">
                           CHAVE DE AUTENTICAÇÃO <br> {{ $producao->chave }}
                        </p>
                        <div class="sigilo">
                            {{ $producao->seguranca}}
                        </div>
                    </div>
                <div class="bordeSegurancaRight">
                    @if($producao->chave)
                        <?php $chavecode = base64_encode($producao->chave);?>
                        {!!
                         QrCode::size(150)->generate("http://www.sipen.kinghost.net/sipen/code/".$chavecode)
                        !!}
                    @endif
                </div>
                <div class="bordeTermo">
                            <span class="preimpreso h3">"Constituem condutas ilícitas que ensejam responsabilidade do agente público civil
                            ou militar: utilizar indevidamente, bem como subtrair, destruir, inutilizar, desfigurar, alterar ou
                                ocultar, total ou parcialmente, informação que se encontre sob sua guarda ou a que tenha
                                acesso ou conhecimento em razão do exercício das atribuições de cargo, emprego ou função
                                pública (Art. 32, inciso II, da Lei nº 12.527, de 18 Nov 2011), sem prejuízo de outras
                                responsabilidades penais."
                            </span>
                </div>
           </section>


        </div>

    </div><!-- Page1 -->

</body>
</html>