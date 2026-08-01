<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    {{ HTML::style('resources/assets/css/ficha.css') }}
    {{ HTML::style('resources/assets/css/ficha-print.css') }}
</head>
<body>

<script>
    javascript:window.print();
</script>

<div class="page">

    <div class="content">

        <div class="title bold">POSSUEM {!! count($presos) !!} APENADOS NA CELA</div>
        <div class="line">

            <table border="1px" cellpadding="1px" cellspacing="0">
                <thead>
                <tr style="">
                    <th style="width:10px;" >ORDEM</th>
                    <th style="width:100px;" >FOTO</th>
                    <td style="width:600px;">NOME DO APENADO</td>
                    <td style="width:120px;">CELA</td>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;?>
                @forelse($presos as $preso)
                    <tr style="background-color: #fff">
                        <th style="font-size: 9px; text-align: left">{!! $i++ !!}</th>
                        <td> <img style=" width: 70px; height: 80px; " src="{!! asset($preso->foto) !!}"/></td>
                        <td style="font-size: 14px; text-align: left">{!! $preso->nomeapenado !!}</td>
                        <td style="font-size: 14px; text-align: left">{!! $preso->nomecela !!}</td>
                    </tr>
                @empty
                    <div class="line">
                        <div class="text-left">
                            <p class="text-danger"> Sem Apenados!</p>
                        </div>
                    </div>
                @endforelse
                </tbody>
            </table>
        </div>
        <br class="clearfix">
        <br>


    </div>
</div>


</body>
</html>