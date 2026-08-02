$(document).ready(function () {



    $('a[name=btnConcluirTriagem]').click(function(){
        $('#id').val($(this).closest('tr').find('td[data-id]').data('id'));
        $('#apenado_id').val($(this).closest('tr').find('td[data-apenado_id]').data('apenado_id'));
        $('#data_inicio').val($(this).closest('tr').find('td[data-data_inicio]').data('data_inicio'));
        $('#data_fim').val($(this).closest('tr').find('td[data-data_fim]').data('data_fim'));

        $("#myModalConcluirTriagem").modal({backdrop: "static"});

    });



});