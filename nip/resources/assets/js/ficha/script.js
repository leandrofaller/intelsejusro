$(document).ready(function () {

    $('a[id=btnFicha]').click(function(){
         $('#apenado_id').val($(this).closest('tr').find('td[data-apenado_id]').data('apenado_id'));
         $("#myModalFicha").modal({backdrop: "static"});
        });

    $('a[id=btnFichaFaccionado]').click(function(){
        $('#apenado_id').val($(this).closest('tr').find('td[data-apenado_id]').data('apenado_id'));
        $("#myModalFichaFaccionado").modal({backdrop: "static"});
    });

});