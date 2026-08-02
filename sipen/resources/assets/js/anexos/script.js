$(document).ready(function () {

    $("input").blur(function () {
        if($(this).hasClass('naoValidar') == true   )
        {
            //não valida o input
        }
        else {
            if ($(this).val() == "") {
                $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                $(this).closest('.form-group').find('i.fa').remove();
                $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
            }
            else {
                $(this).closest('.form-group').removeClass('has-error has-feedback'); //.addClass('has-success has-feedback');
                $(this).closest('.form-group').find('i.fa').remove();
            }
        }
    });

    $("textarea").blur(function () {
        if ($(this).val() == "") {
            $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
            $(this).closest('.form-group').find('i.fa').remove();
            $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
        }
        else {
            $(this).closest('.form-group').removeClass('has-error has-feedback'); //.addClass('has-success has-feedback');
            $(this).closest('.form-group').find('i.fa').remove();
        }
    });



    $('a[name=btnAnexar]').click(function(){
        $("#myModalAnexar").modal({backdrop: "static"});
    });


    $("#btnAnexarDados").click(function () {
        var cont = 0;
        $("#btnAnexarDados").prop('disabled', true);

        $('#formModalAnexar .form-control').each(function (i) {
            var verificar = $(this).prop('disabled');
            if ($(this).val() == "") {
                $("#btnAnexarDados").prop('disabled', false);
                cont++;
                $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                $(this).closest('.form-group').find('i.fa').remove();
                $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
            }
        });
        if (cont == 0) {
            $("#btnAnexarDados").prop('disabled', true);
            $("#formModalAnexar").submit();
        }
        else {
            return false;
        }
    });





});