$(document).ready(function () {
    $("#formSalvar .form-control").blur(function () {
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

    $("#btnSalvar").click(function () {
        var cont = 0;
        if($('#Divdias').is( ":visible" ))
        {
            $('#dias').addClass('validar');
        }
        else
        {
            $('#dias').removeClass('validar');
        }
        $('#formSalvar .form-control.validar').each(function (i) {
            var verificar = $(this).prop('disabled');
            if (verificar == false) {
                if ($(this).val() == "") {
                    cont++;
                    $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                    $(this).closest('.form-group').find('i.fa').remove();
                    $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
                }
            }
        });
        if (cont == 0) {
            $("#formSalvar").submit();
        }
        else {
            return false;
        }
    });





    $("#motivosaida").change(function (event) {
        event.preventDefault();
        var motivo = $('#motivosaida').val();

        if(this.value == 1)
        {
            $('#unidadeDestino').show();
            $('#unidadeObservacao').hide();
            $('#ufRecambiamento').hide();

        }
        else if(this.value == 2)
        {
            $('#unidadeDestino').show();
            $('#unidadeObservacao').hide();
            $('#ufRecambiamento').hide();

        }
        else if(this.value == 3)
        {
            $('#unidadeDestino').show();
            $('#unidadeObservacao').hide();
            $('#ufRecambiamento').hide();

        }
        else if(this.value == 15)
        {
            $('#unidadeDestino').hide();
            $('#ufRecambiamento').hide();
            $('#unidadeObservacao').show();

        }

        else if(this.value == 16)
        {
            $('#ufRecambiamento').show();
            $('#unidadeDestino').hide();
            $('#unidadeObservacao').hide();


        }
        else
        {
            $('#unidadeDestino').hide();
            $('#unidadeObservacao').hide();
            $('#ufRecambiamento').hide();

        }
    });


    $("#disciplina").change(function (event) {

        $('select[name=poloAtual]').empty();
        $('select[name=poloDestino]').empty();
        $('#dias').val('');

        $('#poloOrigen').hide();
        $('#poloDestino').hide();
        $('#Divdias').hide();
        $('#tipo').find('option:first-child').prop('selected', true).end().trigger('chosen:updated');

    });





    $('a[name=btnCancelar]').click(function(){
        var id = $(this).closest('tr').find('td[data-id]').data('id');
        var url = "/requerimento/aluno_cancelar/" + id;
        var redirect = "/requerimento/aluno";
        swal({
                title: "DESEJA  CANCELAR?",
                text: "Uma vez cancelado não será possivel recupera-lo",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "SIM",
                closeOnConfirm: false
            },
            function () {
                $.get(url, function (result) {
                    if (result == "false") {
                        swal("Erro", "Houve um erro ao tentar cancelar o requerimento..", "error");
                        location.href = redirect;
                    }
                    else {
                        swal("Sucesso", "requerimento cancelado com sucesso.", "success");
                        location.href = redirect;
                    }
                });

            });
    });

    $("textarea").each(function () {
        $(this).maxlength({
            // alwaysShow: true,
            threshold: 30,
            warningClass: "label label-primary",
            limitReachedClass: "label label-danger",
            separator: ' de ',
            preText: ' ',
            postText: ' ',
            validate: true,
        });
    });




});