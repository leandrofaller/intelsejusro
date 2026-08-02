<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    {{ HTML::style('css/ficha.css') }}
    {{ HTML::style('css/ficha-print.css') }}
</head>
<body>

<div id="alinha"></div>

<h3 class="text-center hide-print">Aperte Ctrl + P para imprimir</h3>

<div class="page">
    <div class="header">

        <img src="{{ asset('/sejus-ro.png') }}" alt="" class="logo">

        <div class="titulo text-center"> FICHA PRISIONAL </div>
        {{--<div class="titulohistorico text-left"> HISTÓRICO PRISIONAL </div>--}}
        <br class="clearfix">

    </div>

    <div class="content">

        <div class="title bold">DADOS PESSOAIS DO APENADO</div>

        <div class="line">
            <img src="{{asset($apenado->foto)}}" alt="" class="logofoto">
            <div class="input no-margin" style="width:10%">
                <label>Código</label><br>
                <input class="grey" type="text" value="{{ $apenado->id }}">
            </div>

            <div class="input" style="width:60.5%">
                <label>Nome do Apenado</label><br>
                <input type="text" class="text bold" value="{{ $apenado->nomeapenado }}">
            </div>
        </div>

        <div class="line">
            <div class="input no-margin" style="width:35%">
                <label>Alcunha</label><br>
                <input type="text" value="{{$apenado->alcunha}}">
            </div>
            <div class="input" style="width:15%">
                <label>Data de Nascimento</label><br>
                <input type="text" value="{{strftime('%d/%m/%Y',strtotime($apenado->datanascimento))}}">
            </div>
            <div class="input" style="width:18%">
                <label>Sexo</label><br>
                <input type="text" value="{{$apenado->sexo}}">
            </div>


        </div>

        <div class="line">
            <div class="input no-margin" style="width:26.4%">
                <label>Cor/Etnia</label><br>
                <input type="text" value="{{$apenado->etnia}}">
            </div>
            <div class="input" style="width:15%">
                <label>CPF</label><br>
                <input type="text" value="{{$apenado->cpf}}">
            </div>
            <div class="input" style="width:26.5%">
                <label>Cédula de Identidade</label><br>
                <input type="text" value="{{$apenado->rg}}">
            </div>
            <div class="input no-margin" style="width:35.1%">
                <label>Naturalidade</label><br>
                <input type="text" value="{{$apenado->naturalidade}}">
            </div>
            <div class="input" style="width:35.1%">
                <label>Escolaridade</label><br>
                <input type="text" value="{{$apenado->escolaridade}}">
            </div>
        </div>
        <div class="line">
            <div class="input no-margin" style="width:35%">
                <label>Nome Mãe</label><br>
                <input type="text" value="{{$apenado->nomemae}}">
            </div>
            <div class="input" style="width:35%">
                <label>Nome Pai</label><br>
                <input type="text" value="{{$apenado->nomepai}}">
            </div>
        </div>


        <br class="clearfix">
        <br>

        <div class="title bold">UNIDADE PRISIONAL ATUAL</div>

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
            <div class="input no-margin" style="width:16%">
                <label>Regime de Pena</label><br>
                <input type="text" value="{{ $movimentacoes->regime}}">
            </div>
            <div class="input" style="width:16.6%">
                <label>Situação</label><br>
                <input type="text" value="{{ $movimentacoes->situacao}}">
            </div>
            <div class="input" style="width:10%">
                <label>Data Entrada</label><br>
                <input type="text" value="{{ $processo->dataentrada == NULL ? '' : strftime('%d/%m/%Y',strtotime($movimentacoes->dataentrada))}}">
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
        <br>
        <div class="title bold">INFORMAÇÕES PROCESSUAIS</div>

        <div class="line">
            <div class="input no-margin" style="width:47.4%">
                <label>Número do Processo</label><br>
                <input type="text" value="{{ $processo->numeroprocesso }}">
            </div>
            <div class="input" style="width:15%">
                <label>Artigos</label><br>
                <input type="text" value="{{ $processo->artigos }}">
            </div>
            <div class="input" style="width:19%">
                <label>Data Condenação</label><br>
                <input type="text" value="{{ $processo->datacondenacao == NULL ? '' :  strftime('%d/%m/%Y',strtotime($processo->datacondenacao)) }}">
            </div>
            <div class="input" style="width:10%">
                <label>Tempo de Pena</label><br>
                <input type="text" value="{{ $processo->tempodepena }}">
            </div>
        </div>



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
                    <p class="text-danger"> Sem Informação de Visitantes!</p>
                </div>
            </div>
        @endforelse


        <div class="title bold">ADVOGADOS CADASTRADOS</div>

        @forelse($advogados as $advogado)

            <div class="line">
                <img src="{{ asset($advogado->foto) }}" alt="" class="logo">
                <div class="input" style="width:81.5%">
                    <label>Nome do Advogado</label><br>
                    <input type="text" value="{{ $advogado->nomeadvogado }}">
                </div>
                <div class="input" style="width:21.9%">
                    <label>OAB</label><br>
                    <input type="text" value="{{ $advogado->oab }}">
                </div>
                <div class="input" style="width:19.1%">
                    <label>CPF</label><br>
                    <input type="text" value="{{ $advogado->cpfadvogado }}">
                </div>
                <div class="input" style="width:19.1%">
                    <label>RG</label><br>
                    <input type="text" value="{{ $advogado->rgadvogado }}">
                </div>
                <div class="input" style="width:14%">
                    <label>Data de Nascimento</label><br>
                    <input type="text" value="{{ strftime('%d/%m/%Y',strtotime($advogado->datacadastroadvogado)) }}">
                </div>
                <div class="input" style="width:27%">
                    <label>Telefone de Contato</label><br>
                    <input type="text" value="{{ $advogado->telefoneadvogado }}">
                </div>

                <div class="input" style="width:15%">
                    <label>Situação</label><br>
                    <input type="text" value="{{$advogado->datacancelamento == '' ? 'Ativo' : 'Cancelado' }}">
                </div>
                <br class="clearfix">
                <br>
            </div>

        @empty
            <div class="line">
                <div class="text-left">
                    <p class="text-danger"> Sem Informação de Advogados!</p>
                </div>
            </div>
        @endforelse

    </div>
</div>


</body>
</html>