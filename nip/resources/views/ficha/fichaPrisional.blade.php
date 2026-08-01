<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    {{ HTML::style('resources/assets/css/ficha.css') }}
    {{ HTML::style('resources/assets/css/ficha-print.css') }}
</head>
<body>

<div id="alinha"></div>

<h3 class="text-center hide-print">Aperte Ctrl + P para imprimir</h3>

<div class="page">
    <div class="header">
        {{--<img src="{{ asset('/sejus-ro.png') }}" alt="" class="logo">--}}
        {{--<div class="titulohistorico text-left"> FICHA PRISIONAL </div>--}}
        <h2>  FICHA PRISIONAL  </h2>
        <br class="clearfix">
    </div>

    <div class="content">

        @if(in_array("DP", $check))

            <div class="title bold">DADOS PESSOAIS DO APENADO</div>
            <div class="line">

                @if(count($fotoprincipal) > 0)
                    @foreach($fotoprincipal as $f)
                    <img src="{{ asset('public/'.$f->arquivo_foto) }}" alt="" class="logofoto">
                    @endforeach
                @else
                    <img src="{{ asset('fotosPresos/semfoto.png') }}" alt="" class="logofoto">
                @endif

                <div class="input no-margin" style="width:72.8%">
                    <label>Código</label><br>
                    <input class="grey" type="text" value="{{ $apenado->id }}">
                </div>

                <div class="input no-margin" style="width:72.8%">
                    <label>Nome</label><br>
                    <input type="text" class="text bold" value="{{ $apenado->nomeapenado }}">
                </div>

                {{--<div class="input " style="width:28%">--}}
                    {{--<label>Alcunha</label><br>--}}
                    {{--<input type="text" value="{{$apenado->alcunha}}">--}}
                {{--</div>--}}

                <div class="input no-margin" style="width:13%">
                    <label>Data de Nascimento</label><br>
                    <input type="text" value="{{strftime('%d/%m/%Y',strtotime($apenado->datanascimento))}}">
                </div>
                <div class="input" style="width:10%">
                    <label>Sexo</label><br>
                    <input type="text" value="{{$apenado->sexo}}">
                </div>
                <div class="input " style="width:15%">
                    <label>CPF</label><br>
                    <input type="text" value="{{$apenado->cpf}}">
                </div>
                <div class="input" style="width:27.5%">
                    <label>RG</label><br>
                    <input type="text" value="{{$apenado->rg}}">
                </div>


                <div class="input no-margin" style="width:24.5%">
                    <label>Cor/Etnia</label><br>
                    <input type="text" value="{{$apenado->etnia}}">
                </div>
                <div class="input " style="width:21%">
                    <label>Naturalidade</label><br>
                    <input type="text" value="{{$apenado->naturalidade}}">
                </div>
                <div class="input" style="width:22.5%">
                    <label>Escolaridade</label><br>
                    <input type="text" value="{{$apenado->escolaridade}}">
                </div>
            </div>
            <div class="line">
                <div class="input no-margin" style="width:35%">
                    <label>Nome Mãe</label><br>
                    <input type="text" value="{{$apenado->nomemae}}">
                </div>
                <div class="input" style="width:35.4%">
                    <label>Nome Pai</label><br>
                    <input type="text" value="{{$apenado->nomepai}}">
                </div>
            </div>
            <br class="clearfix">
            <br>
        @endif


            @if(in_array("ER", $check))
                <div class="title bold">ENDEREÇOS CADASTRADOS</div>
                <div class="line">
                    @if(count($enderecos) > 0)

                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:350px; font-size: 12px; text-align: left">Rua</th>
                                <th style="width:250px; font-size: 12px; text-align: left ">Número</th>
                                <td style="width:300px; font-size: 12px; ">Bairro</td>
                                <td style="width:150px; font-size: 12px; ">Cidade</td>
                                <td style="width:100px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($enderecos as $endereco)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $endereco->rua_endereco !!}</th>
                                    <th style="font-size: 9px; text-align: left">{!! $endereco->numero_endereco !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $endereco->bairro_endereco !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $endereco->cidade_endereco !!} / {!! $endereco->uf_endereco !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! dataFormat($endereco->created_at) !!} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>

                <br class="clearfix">
            @endif


                <div class="title bold">ALCUNHAS</div>
                <div class="line">
                    @if(count($alcunhas) > 0)

                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:450px; font-size: 12px; text-align: left">Nome Alcunha</th>
                                <th style="width:250px; font-size: 12px; text-align: left ">Atual</th>
                                <td style="width:100px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($alcunhas as $alcunha)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $alcunha->nome_alcunha !!}</th>
                                    <th style="font-size: 9px; text-align: left">{!! $alcunha->atual_alcunha !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! dataFormat($alcunha->created_at) !!} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>

                <br class="clearfix">


            @if(in_array("MF", $check))
                <div class="title bold">FOTOS</div>
                <div class="line">
                    @if(count($fotos) > 0)

                            @foreach($fotos as $foto)
                                @if($foto->arquivo_foto != 'fotosPresos/semfoto.png')
                                    <div class="input no-margin" style="width:25%;">
                                        <img  src="{{asset('public/'.$foto->arquivo_foto)}}" alt="" class="logofoto">
                                        <small class="center"> {!! $foto->atual_foto ? 'PRINCIPAL' : '' !!} {!! dataFormat($foto->created_at) !!} </small>
                                    </div>
                                @endif
                            @endforeach
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>

                <br class="clearfix">
            @endif





        @if(in_array("IP", $check))

            <div class="title bold">INFORMAÇÃO PRISIONAL</div>
            <div class="line">
                <div class="input no-margin" style="width:50%">
                    <label>Nome da Unidade</label><br>
                    <input class="text bold" type="text" value="{{ $unidade->nomeunidade }}">

                </div>
                <div class="input " style="width:10%">
                    <label>Cela</label><br>
                    <input class="text" type="text" value=" {{ $cela != null ? $cela->nomecela : ''  }}">

                </div>
                <div class="input" style="width:13%">
                    <label>Sigla</label><br>
                    <input type="text" value="{{ $unidade->siglaunidade }}">
                </div>
                <div class="input" style="width:18.5%">
                    <label>Cidade/Comarca</label><br>
                    <input type="text" value="{{ $unidade->cidadeunidade }}">
                </div>
            </div>

            <div class="line">
                <div class="input no-margin" style="width:35.1%">
                    <label>Tipo Estabelecimento</label><br>
                    <input class="text" type="text" value="{{ $unidade->tipoestabelecimento }}">
                </div>
                <div class="input" style="width:33%">
                    <label>Diretor Geral</label><br>
                    <input class="text" type="text" value="{{ $unidade->nomediretorgeral }}">
                </div>
                <div class="input" style="width:25.7%">
                    <label>Contato Unidade</label><br>
                    <input class="text" type="text" value="{{ $unidade->telefoneunidade }}">
                </div>
            </div>

            <div class="line">
                <div class="input no-margin" style="width:16.2%">
                    <label>Regime de Pena</label><br>
                    <input type="text" value="{{ $movimentacoes->regime}}">
                </div>
                <div class="input" style="width:16.3%">
                    <label>Situação</label><br>
                    <input class="text" type="text" value="{{ $movimentacoes->situacao }}">
                </div>
                <div class="input" style="width:10%">
                    <label>Data Entrada</label><br>
                    <input type="text" value="{{ strftime('%d/%m/%Y',strtotime($movimentacoes->dataentrada))}}">
                </div>
                <div class="input" style="width:30%">
                    <label>Ofício de Entrada</label><br>
                    <input type="text" value="{{ $movimentacoes->oficioentrada}}">
                </div>
                <div class="input" style="width:16.3%">
                    <label>Preso Oriundo da Justiça</label><br>
                    <input type="text" value="{{ $movimentacoes->presooriundo}}">
                </div>
            </div>
            <br class="clearfix">

        @endif







        @if(in_array("P", $check))
            <br>
            <div class="title bold">INFORMAÇÕES PROCESSUAIS</div>
            <div class="line">
                @if(count($processos) > 0)

                    <table>
                        <thead>
                        <tr style="background-color: #000000; color: #ffffff;">
                            <th style="width:350px; font-size: 12px; text-align: left " >Número do Processo / Execução</th>
                            <th style="width:200px; font-size: 12px; text-align: left " >Artigos</th>
                            <td style="width:180px; font-size: 12px; ">Vara</td>
                            <td style="width:70px; font-size: 12px; ">Principal </td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($processos as $processo)
                            <tr style="background-color: #fff">
                                <th style="font-size: 9px; text-align: left">{!! $processo->numeroprocesso !!}</th>
                                <th style="font-size: 9px; text-align: left">{!! $processo->artigos !!}</th>
                                <td style="font-size: 9px; text-align: left">{!! $processo->vara !!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $processo->principal !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-left">
                        <p class="text-danger"> Sem Informação!</p>
                    </div>
                @endif
            </div>

            <br class="clearfix">
        @endif





        @if(in_array("M", $check))
            <div class="title bold">HISTÓRICO DE MOVIMENTAÇÕES</div>
            <div class="line">
                @if(count($prisoes) > 0)

                    <table>
                        <thead>
                        <tr style="background-color: #000000; color: #ffffff;">
                            <th style="width:500px; font-size: 12px; text-align: left " >Unidade Prisional Origem</th>
                            <th style="width:500px; font-size: 12px; text-align: left " >Unidade Prisional Destino</th>
                            <th style="width:20px; font-size: 12px; text-align: left">Regime</th>
                            <td style="width:120px; font-size: 12px; ">Data Entrada</td>
                            <td style="width:120px; font-size: 12px; ">Data Saída</td>
                            <td style="width:200px; font-size: 12px; ">Motivo </td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($prisoes as $prisao)
                            <tr style="background-color: #fff">
                                <th style="font-size: 9px; text-align: left">{!! \App\Model\Unidade::mostraNomeUnidade($prisao->unidade_id) !!}</th>
                                <th style="font-size: 9px; text-align: left">{!! \App\Model\Unidade::mostraNomeUnidade($prisao->unidadedestino) !!}</th>
                                <th style="font-size: 9px; text-align: left">{!! $prisao->regime !!}</th>
                                <td style="font-size: 9px; text-align: left">{!! strftime('%d/%m/%Y',strtotime($prisao->dataentrada)) !!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $prisao->datasaida == NULL ? ''  : strftime('%d/%m/%Y',strtotime($prisao->datasaida)) !!}</td>
                                <td style="font-size: 9px; text-align: left">{!! tiposaida($prisao->motivosaida) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-left">
                        <p class="text-danger"> Sem Informação!</p>
                    </div>
                @endif
            </div>

            <br class="clearfix">
        @endif




        @if(in_array("MC", $check))
            <div class="title bold">HISTÓRICO MUDANÇA DE CELAS</div>
            <div class="line">
                @if(count($logmudancacelas) > 0)
                    <table>
                        <thead>
                        <tr style="background-color: #000000; color: #ffffff;">
                            <th style="width:500px; font-size: 12px; text-align: left " >Unidade Prisional</th>
                            <td style="width:120px; font-size: 12px; ">Data Mudança</td>
                            <td style="width:60px; font-size: 12px; ">Cela De</td>
                            <td style="width:60px; font-size: 12px; ">Cela Para</td>
                            <td style="width:220px; font-size: 12px; ">Motivo</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logmudancacelas as $log)
                            <tr style="background-color: #fff">
                                <th style="font-size: 9px; text-align: left">{!! \App\Model\Unidade::mostraNomeUnidade($log->unidade_id) !!}</th>
                                <td style="font-size: 9px; text-align: left">{!! $log->datamudanca == NULL ? ''  : strftime('%d/%m/%Y',strtotime($log->datamudanca)) !!}</td>
                                <td style="font-size: 9px; text-align: left">{!! \App\Model\Apenado::nomecela($log->celaDE) !!}</td>
                                <td style="font-size: 9px; text-align: left">{!! \App\Model\Apenado::nomecela($log->celaPARA) !!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $log->motivomudanca !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-left">
                        <p class="text-danger"> Sem Informação!</p>
                    </div>
                @endif
            </div>
        @endif





        @if(in_array("MD", $check))
            <br class="clearfix">
            <div class="title bold">MEDIDA DISCIPLINAR APLICADA</div>
            <div class="line">

                @if(count($disciplinas) > 0)

                    <table>
                        <thead>
                        <tr style="background-color: #000000; color: #ffffff;">
                            <th style="width:500px; font-size: 12px; text-align: left">Unidade Prisional</th>
                            <td style="width:120px; font-size: 12px; ">Ocorrência</td>
                            <td style="width:60px; font-size: 12px; ">Data</td>
                            <td style="width:50px; font-size: 12px; ">Tempo</td>
                            <td style="width:220px; font-size: 12px; ">Tipo</td>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($disciplinas as $medida)
                            <tr style="background-color: #fff">
                                <th style="font-size: 9px; text-align: left">{!! \App\Model\Unidade::mostraNomeUnidade($medida->unidade_id) !!}</th>
                                <td style="font-size: 9px; text-align: left">{!! $medida->ocorrencia_md !!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $medida->datainicio_md == NULL ? ''  : strftime('%d/%m/%Y',strtotime($medida->datainicio_md)) !!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $medida->tempo_md!!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $medida->tipomedida_md!!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-left">
                        <p class="text-danger"> Sem Informação!</p>
                    </div>

                @endif
            </div>
        @endif





        @if(in_array("IA", $check))
            <br class="clearfix">
            <div class="title bold">INFORMAÇÕES ADICIONAIS</div>
            <div class="line">

                @if(count($informacoes) > 0)

                    <table>
                        <thead>
                        <tr style="background-color: #000000; color: #ffffff;">
                            <td style="width:60px; font-size: 12px; ">Data</td>
                            {{--<td style="width:200px; font-size: 12px; ">Unidade</td>--}}
                            <td style="width:50px; font-size: 12px; ">Tipo</td>
                            <td style="width:520px; font-size: 12px; ">Observação</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($informacoes as $i)
                            <tr style="background-color: #fff">
                                <td style="font-size: 9px; text-align: left">{!! dataFormat($i->datacadastro) !!}</td>
                                {{--<td style="font-size: 9px; text-align: left">{!! \App\Model\Unidade::mostraNomeUnidade($i->unidade_id) !!}</td>--}}
                                <td style="font-size: 9px; text-align: left">{!! $i->tipo!!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $i->descricaoinfo!!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-left">
                        <p class="text-danger"> Sem Informação!</p>
                    </div>

                @endif
            </div>
        @endif






        @if(in_array("PA", $check))
            <br class="clearfix">
            <div class="title bold">PAD - PROCESSO ADMINISTRATIVO DISCIPLINAR</div>
            <div class="line">
                @if(count($pads) > 0)

                    <table>
                        <thead>
                        <tr style="background-color: #000000; color: #ffffff;">
                            <th style="width:500px; font-size: 12px; text-align: left">Unidade Prisional</th>
                            <td style="width:100px; font-size: 12px; ">Número</td>
                            <td style="width:100px; font-size: 12px; ">Rel. Segurança</td>
                            <td style="width:60px; font-size: 12px; ">Data</td>
                            <td style="width:60px; font-size: 12px; ">Tipo</td>
                            <td style="width:60px; font-size: 12px; ">Falta</td>
                            <td style="width:60px; font-size: 12px; ">Situação</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pads as $pad)
                            <tr style="background-color: #fff">
                                <th style="font-size: 9px; text-align: left">{!! \App\Model\Unidade::mostraNomeUnidade($pad->unidade_id) !!}</th>
                                <td style="font-size: 9px; text-align: left">{!! $pad->numeropad !!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $pad->numerorelatorioseguranca !!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $pad->datainiciopad == NULL ? ''  : strftime('%d/%m/%Y',strtotime($pad->datainiciopad)) !!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $pad->tipofato!!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $pad->tipofalta!!}</td>
                                <td style="font-size: 9px; text-align: left">{!! $pad->situacaopad!!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-left">
                        <p class="text-danger"> Sem Informação!</p>
                    </div>

                @endif
            </div>
        @endif






        @if(in_array("V", $check))

            <br class="clearfix">
            <br>
            <div class="title bold">VISITANTES CADASTRADAS</div>
            @forelse($visitas as $visita)

                <div class="line">
                    <img src="{{ asset($visita->fotovisita) }}" alt="" class="logo">
                    <div class="input" style="width:60%">
                        <label>Nome da Visitante</label><br>
                        <input type="text" value="{{ $visita->nomevisita }}">
                    </div>
                    <div class="input" style="width:19.1%">
                        <label>CPF</label><br>
                        <input type="text" value="{{ $visita->cpfvisita }}">
                    </div>
                    <div class="input" style="width:19.1%">
                        <label>RG</label><br>
                        <input type="text" value="{{ $visita->rgvisita }}">
                    </div>
                    <div class="input" style="width:14%">
                        <label>Data de Nascimento</label><br>
                        <input type="text" value="{{ strftime('%d/%m/%Y',strtotime($visita->datanascimentovisita)) }}">
                    </div>
                    <div class="input" style="width:27%">
                        <label>Telefone de Contato</label><br>
                        <input type="text" value="{{ $visita->telefonecontato }}">
                    </div>
                    <div class="input" style="width:14%">
                        <label>Grau Parentesco</label><br>
                        <input type="text" value="{{ $visita->parentescovisita }}">
                    </div>
                    <div class="input" style="width:14%">
                        <label>Data da Carteirinha</label><br>
                        <input type="text" value="{{ strftime('%d/%m/%Y',strtotime($visita->dataemicaocarteirinha)) }}">
                    </div>
                    <div class="input" style="width:47.5%">
                        <label>Endereço</label><br>
                        <input type="text" value="{{ $visita->enderecovisita }}">
                    </div>
                    <div class="input" style="width:15%">
                        <label>Situação</label><br>
                        <input type="text" value="{{$visita->datacancelamento == '' ? 'Ativo' : 'Cancelado' }}">
                    </div>
                    <br class="clearfix">
                    <br>
                </div>

            @empty
                <div class="line">
                    <div class="text-left">
                        <p class="text-danger"> Sem Informação!</p>
                    </div>
                </div>
            @endforelse


        @endif











        @if(in_array("T", $check))

            <div class="title bold">TEMPORÁRIAS</div>
            @forelse($temporarias as $temporaria)
                <div class="line">
                    <div class="input no-margin" style="width:45%">
                        <label>Nome da Unidade</label><br>
                        <input class="text bold" type="text" value="{!! \App\Model\Unidade::mostraNomeUnidade($temporaria->unidade_id) !!}">

                    </div>
                    <div class="input " style="width:5%">
                        <label>Cela</label><br>
                        <input class="text" type="text" value=" {{ $temporaria->movimentacoes->celas->nomecela }}">

                    </div>
                    <div class="input" style="width:17%">
                        <label>Tipo</label><br>
                        <input type="text" value="{{ TipoTemporarias($temporaria->tipo) }}">
                    </div>
                    <div class="input" style="width:24.5%">
                        <label>Motivo</label><br>
                        <input type="text" value="{{ MotivoTemporarias($temporaria->motivo) }}">
                    </div>
                </div>
                <div class="line">
                    <div class="input no-margin" style="width:14%">
                        <label>Data Saída </label><br>
                        <input class="text" type="text" value="{{ dataFormat($temporaria->datasaida) }} {{ $temporaria->horasaida }}">
                    </div>
                    <div class="input" style="width:14%">
                        <label>Data Retorno</label><br>
                        <input class="text" type="text" value="{{ $temporaria->dataretorno ? dataFormat($temporaria->dataretorno) : '' }} {{ $temporaria->horaretorno ? $temporaria->horaretorno : '' }}">
                    </div>
                    <div class="input" style="width:30%">
                        <label>Escolta</label><br>
                        <input class="text" type="text" value=" {{ $temporaria->escolta }} ">
                    </div>
                    <div class="input" style="width:33.5%">
                        <label>Documento</label><br>
                        <input class="text" type="text" value="{{ $temporaria->documento }}">
                    </div>
                </div>
                <div class="line">
                    <div class="input no-margin" style="width:88%">
                        <label>Descrição Saída</label><br>
                        <div class="text-left"> {!! $temporaria->descricao !!} </div>

                    </div>
                    <div class="input no-margin" style="width:88%">
                        <label>Descrição Retorno</label><br>
                        <div class="text-left"> {!! $temporaria->descricaoretorno !!} </div>
                    </div>

                </div>

                <br class="clearfix">
                <br>
            @empty
                <div class="line">
                    <div class="text-left">
                        <p class="text-danger"> Sem Informação!</p>
                    </div>
                </div>
            @endforelse

            <br class="clearfix">

        @endif

            @if(in_array("DF", $check))
                <div class="title bold">FACCÃO</div>
                <div class="line">
                    <div class="input no-margin" style="width:60%">
                        <label>Nome da Facção</label><br>
                        <input class="text bold" type="text" value="{{ $faccaoatual->nomefaccao }}">
                    </div>
                    <div class="input " style="width:15%">
                        <label>Sigla</label><br>
                        <input class="text" type="text" value=" {{ $faccaoatual->sigla  }}">
                    </div>
                    <div class="input" style="width:18.5%">
                        <label>Data Batismo</label><br>
                        <input type="text" value="{{ $faccaoatual->databatismo ? dataFormat($faccaoatual->databatismo) : '' }}">
                    </div>
                </div>
                <br class="clearfix">
            @endif





            @if(in_array("HDF", $check))




                <br class="clearfix">
                <div class="title bold">CARGOS NA FACCÃO</div>
                <div class="line">
                    @if(count($cargos) > 0)
                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:500px; font-size: 12px; text-align: left">NOME CARGO</th>
                                <th style="width:500px; font-size: 12px; text-align: left">DESCRIÇÃO</th>
                                <td style="width:100px; font-size: 12px; ">Atual</td>
                                <td style="width:170px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cargos as $dado)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $dado->nomecargo !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->descricao_cargo !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->atual_cargo !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->created_at ? dataFormat($dado->created_at)  : '' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>



                <br class="clearfix">
                <div class="title bold">TELEFONES DE CONTATOS</div>
                <div class="line">
                    @if(count($telefones) > 0)
                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:500px; font-size: 12px; text-align: left">DDD</th>
                                <td style="width:100px; font-size: 12px; ">Número Telefone</td>
                                <td style="width:100px; font-size: 12px; ">Atual</td>
                                <td style="width:100px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($telefones as $dado)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $dado->ddd !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->numero_telefone !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->atual_telefone !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->created_at ? dataFormat($dado->created_at)  : '' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>


                <br class="clearfix">
                <div class="title bold">PLACA / CHAPA / NÚMERO BATISMO / MATRICULA</div>
                <div class="line">
                    @if(count($matriculas) > 0)
                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:500px; font-size: 12px; text-align: left">DESCRIÇÃO</th>
                                <td style="width:170px; font-size: 12px; ">Atual</td>
                                <td style="width:100px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($matriculas as $dado)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $dado->nome_matricula !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->atual_matricula !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->created_at ? dataFormat($dado->created_at)  : '' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>



                <br class="clearfix">
                <div class="title bold">NOME BATISMO</div>
                <div class="line">
                    @if(count($nomebatismos) > 0)
                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:500px; font-size: 12px; text-align: left">DESCRIÇÃO</th>
                                <td style="width:170px; font-size: 12px; ">Atual</td>
                                <td style="width:100px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($nomebatismos as $dado)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $dado->nome_batismo !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->atual_batismo !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->created_at ? dataFormat($dado->created_at)  : '' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>




                <br class="clearfix">
                <div class="title bold">LOCAL DE BATISMO</div>
                <div class="line">
                    @if(count($localbatismos) > 0)
                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:500px; font-size: 12px; text-align: left">DESCRIÇÃO</th>
                                <td style="width:170px; font-size: 12px; ">Atual</td>
                                <td style="width:100px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($localbatismos as $dado)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $dado->nome_localbatismo !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->atual_localbatismo !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->created_at ? dataFormat($dado->created_at)  : '' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>





                <br class="clearfix">
                <div class="title bold">QUEBRADA ORIGEM</div>
                <div class="line">
                    @if(count($quebradaorigens) > 0)
                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:500px; font-size: 12px; text-align: left">DESCRIÇÃO</th>
                                <td style="width:170px; font-size: 12px; ">Atual</td>
                                <td style="width:100px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($quebradaorigens as $dado)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $dado->nome_origem !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->atual_origem !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->created_at ? dataFormat($dado->created_at)  : '' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>




                <br class="clearfix">
                <div class="title bold">QUEBRADA ATUAL</div>
                <div class="line">
                    @if(count($quebradaatuais) > 0)
                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:500px; font-size: 12px; text-align: left">DESCRIÇÃO</th>
                                <td style="width:170px; font-size: 12px; ">Atual</td>
                                <td style="width:100px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($quebradaatuais as $dado)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $dado->nome_atual !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->atual_atual !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->created_at ? dataFormat($dado->created_at)  : '' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>













                <br class="clearfix">
                <div class="title bold">REFERÊNCIAS</div>
                <div class="line">
                    @if(count($referencias) > 0)
                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:500px; font-size: 12px; text-align: left">NOME</th>
                                <th style="width:500px; font-size: 12px; text-align: left">DESCRIÇÃO</th>
                                <td style="width:100px; font-size: 12px; ">Atual</td>
                                <td style="width:170px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($referencias as $dado)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $dado->nome_referencia !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->descricao_referencia !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->atual_referencia !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->created_at ? dataFormat($dado->created_at)  : '' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>




                <br class="clearfix">
                <div class="title bold">PADRINHOS INDICAÇÃO INTERNA</div>
                <div class="line">
                    @if(count($padrinhosinternos) > 0)
                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:500px; font-size: 12px; text-align: left">NOME</th>
                                <th style="width:500px; font-size: 12px; text-align: left">DESCRIÇÃO</th>
                                <td style="width:100px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($padrinhosinternos as $dado)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $dado->nomeapenado !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->descricao_padrinhointerno !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->created_at ? dataFormat($dado->created_at)  : '' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>





                <br class="clearfix">
                <div class="title bold">PADRINHOS INDICAÇÃO EXTERNA</div>
                <div class="line">
                    @if(count($padrinhosexternos) > 0)
                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:500px; font-size: 12px; text-align: left">NOME</th>
                                <th style="width:500px; font-size: 12px; text-align: left">DESCRIÇÃO</th>
                                <td style="width:100px; font-size: 12px; ">Data Cadastro</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($padrinhosexternos as $dado)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $dado->nome_padrinhoexterno !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->descricao_padrinhoexterno !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->created_at ? dataFormat($dado->created_at)  : '' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>




                <br class="clearfix">
                <div class="title bold">CLASSIFICAÇÃO</div>
                <div class="line">
                    @if(count($locClassificacoes) > 0)
                        <table>
                            <thead>
                            <tr style="background-color: #000000; color: #ffffff;">
                                <th style="width:500px; font-size: 12px; text-align: left">CLASSIFICAÇÃO</th>
                                <th style="width:300px; font-size: 12px; text-align: left">ATUAL</th>
                                <td style="width:100px; font-size: 12px; ">Data Atualização</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($locClassificacoes as $dado)
                                <tr style="background-color: #fff">
                                    <th style="font-size: 9px; text-align: left">{!! $dado->tipo_poss !!} - {!! $dado->tipo_class !!}</th>
                                    <td style="font-size: 9px; text-align: left">{!! $i == 1 ? 'Atual' : '' !!}</td>
                                    <td style="font-size: 9px; text-align: left">{!! $dado->created_at ? dataFormat($dado->created_at)  : '' !!}</td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-left">
                            <p class="text-danger"> Sem Informação!</p>
                        </div>
                    @endif
                </div>

            @endif





            {{--@if(in_array("AF", $check))--}}
                {{--<div class="title bold">DOCUMENTOS ANEXOS FACCIONADO</div>--}}
                {{--<div class="line">--}}
                    {{--@if(count($anexos) > 0)--}}

                            {{--@foreach($anexos as $anexo)--}}

                            {{--<embed src="{{asset($anexo->nomearquivo)}}" width="760" height="500" type='application/pdf'>--}}
                            {{--@endforeach--}}
                    {{--@else--}}
                            {{--<div class="text-left">--}}
                                  {{--<p class="text-danger"> Sem Informação de Endereços!</p>--}}
                            {{--</div>--}}
                    {{--@endif--}}
                {{--</div>--}}

                {{--<br class="clearfix">--}}
            {{--@endif--}}



            {{--@if(in_array("A", $check))--}}

            {{--<div class="title bold">ADVOGADOS CADASTRADOS</div>--}}
            {{--@forelse($advogados as $advogado)--}}
            {{--<div class="line">--}}
            {{--<img src="{{ asset($advogado->foto) }}" alt="" class="logo">--}}
            {{--<div class="input" style="width:81.5%">--}}
            {{--<label>Nome do Advogado</label><br>--}}
            {{--<input type="text" value="{{ $advogado->nomeadvogado }}">--}}
            {{--</div>--}}
            {{--<div class="input" style="width:21.9%">--}}
            {{--<label>OAB</label><br>--}}
            {{--<input type="text" value="{{ $advogado->oab }}">--}}
            {{--</div>--}}
            {{--<div class="input" style="width:19.1%">--}}
            {{--<label>CPF</label><br>--}}
            {{--<input type="text" value="{{ $advogado->cpfadvogado }}">--}}
            {{--</div>--}}
            {{--<div class="input" style="width:19.1%">--}}
            {{--<label>RG</label><br>--}}
            {{--<input type="text" value="{{ $advogado->rgadvogado }}">--}}
            {{--</div>--}}
            {{--<div class="input" style="width:14%">--}}
            {{--<label>Data de Cadastro</label><br>--}}
            {{--<input type="text" value="{{ strftime('%d/%m/%Y',strtotime($advogado->datacadastroadvogado)) }}">--}}
            {{--</div>--}}
            {{--<div class="input" style="width:27%">--}}
            {{--<label>Telefone de Contato</label><br>--}}
            {{--<input type="text" value="{{ $advogado->telefoneadvogado }}">--}}
            {{--</div>--}}

            {{--<div class="input" style="width:15%">--}}
            {{--<label>Situação</label><br>--}}
            {{--<input type="text" value="{{$advogado->datacancelamento == '' ? 'Ativo' : 'Cancelado' }}">--}}
            {{--</div>--}}
            {{--<br class="clearfix">--}}
            {{--<br>--}}
            {{--</div>--}}

            {{--@empty--}}
            {{--<div class="line">--}}
            {{--<div class="text-left">--}}
            {{--<p class="text-danger"> Sem Informação de Advogados!</p>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--@endforelse--}}

            {{--@endif--}}










    </div>
</div>


</body>
</html>