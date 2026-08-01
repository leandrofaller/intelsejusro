/**
 * Created by MARCOSM.COSTA on 06/11/2017.
 */
$(document).ready(function () {
    $('.delete').click(function(e) {
        e.preventDefault();
        var Url = $(this).attr("href");
        Confirmacao(Url);
    });

    function Confirmacao(Url) {
        swal({
            title: "DESEJA EXCLUIR?",
            text: "Se você excluir não será possivel recuperá-lo",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "SIM",
            closeOnConfirm: false
        }, function() {
            //Redireciona
            window.location.href = Url;
        });
    }

    $('.situacao').click(function(e) {
        e.preventDefault();
        var Url = $(this).attr("href");
        Situacao(Url);
    });

    function Situacao(Url) {
        swal({
            title: "Confirmação!",
            text: "Deseja realmente executar está ação?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "SIM",
            closeOnConfirm: false
        }, function() {
            //Redireciona
            window.location.href = Url;
        });
    }
});