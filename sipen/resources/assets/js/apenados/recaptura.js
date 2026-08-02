$(document).ready(function () {

    $("#unidade_id").change(function (event) {
        event.preventDefault();

        var unidade_id = $('#unidade_id').val();
        var unidade_preso = $('#unidade_preso').val();

       // alert(unidade_id);
        if($('#unidade_id').val() == $('#unidade_preso').val())
        {
            $('#novaUnidadeEntrada').hide();
        }
        else
            $('#novaUnidadeEntrada').show();

    });



});