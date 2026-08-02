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



    $('a[name=btnEditar]').click(function(){

         $('#id').val($(this).closest('tr').find('td[data-id]').data('id'));
         $('#nomeadvogado').val($(this).closest('tr').find('td[data-nomeadvogado]').data('nomeadvogado'));
         $('#rgadvogado').val($(this).closest('tr').find('td[data-rgadvogado]').data('rgadvogado'));
         $('#cpfadvogado').val($(this).closest('tr').find('td[data-cpfadvogado]').data('cpfadvogado'));
         $('#oab').val($(this).closest('tr').find('td[data-oab]').data('oab'));
         $('#enderecoadvogado').val($(this).closest('tr').find('td[data-enderecoadvogado]').data('enderecoadvogado'));
         $('#seccional').val($(this).closest('tr').find('td[data-seccional]').data('seccional'));
         $('#telefoneadvogado').val($(this).closest('tr').find('td[data-telefoneadvogado]').data('telefoneadvogado'));
         $('#datacadastroadvogado').val($(this).closest('tr').find('td[data-datacadastroadvogado]').data('datacadastroadvogado'));

            var foto = $(this).closest('tr').find('td[data-foto]').data('foto');
           // alert(fotovisita);
            $('#foto').attr('src', foto );

        $("#myModalEditar").modal({backdrop: "static"});

    });

    $('a[name=btnCancelar]').click(function(){

        $('#id').val($(this).closest('tr').find('td[data-id]').data('id'));
        $('#nomeadvogado').val($(this).closest('tr').find('td[data-nomeadvogado]').data('nomeadvogado'));
        $('#oab').val($(this).closest('tr').find('td[data-oab]').data('oab'));

        $('#idd').val($(this).closest('tr').find('td[data-idd]').data('idd'));
        $('#apenado_id').val($(this).closest('tr').find('td[data-apenado_id]').data('apenado_id'));

        $("#myModalCancelar").modal({backdrop: "static"});

    });


    //--------------EXCLUIR
    // $('a[name=btnEcluir]').click(function(){
    //     var id = $(this).closest('tr').find('td[data-id]').data('id');
    //     var url = "/diarios/diarioAcademico_conteudo_delete/" + id;
    //     var redirect = "/diarios/"+$('#idPolo').val()+"-"+$('#idDisciplina').val()+"/diarioAcademico_dados";
    //     swal({
    //             title: "DESEJA  EXLUIR?",
    //             text: "Uma vez exluido não será possivel recupera-lo",
    //             type: "warning",
    //             showCancelButton: true,
    //             confirmButtonColor: "#DD6B55",
    //             confirmButtonText: "SIM",
    //             closeOnConfirm: false
    //         },
    //         function () {
    //             $.get(url, function (result) {
    //                 if (result == "false") {
    //                     swal("Erro", "Houve um erro ao tentar excluir..", "error");
    //                 }
    //                 else {
    //                     swal("Sucesso", "Dados deletado com sucesso.", "success");
    //                     location.href = redirect;
    //                 }
    //             });
    //         });
    // });


    $("input[type=text]").each(function () {
        if ($(this).hasClass('date') == true)
        {
            $(this).datepicker({
                format: "dd/mm/yyyy",
                language: "pt-BR",
                startDate: "01/01/1930",
                endDate: "31/12/2100",
                forceParse: "__-__-____",
                //startDate: '-20d',
                clearBtn: true,
                todayHighlight: true

            }).mask("99/99/9999");
    }

    if($(this).hasClass('mascaraDate') == true)
    {
        $(this).mask("99/99/9999");
    }

    });



    $("#btnSalvar").click(function () {
        var cont = 0;

        $('#formSalvar input').each(function (i) {
            var verificar = $(this).prop('disabled');

                    if ($(this).val() == "") {
                        cont++;
                        $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                        $(this).closest('.form-group').find('i.fa').remove();
                        $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
                    }

        });


        if (cont == 0) {
            $("#formSalvar").submit();
        }
        else {
            return false;

        }
    });


    $("#btnModalsalvar").click(function () {
        var cont = 0;

        $('#formModalSalvar .form-control').each(function (i) {
            var verificar = $(this).prop('disabled');

            if($(this).hasClass('naoValidar') == true)
            {
                //não valida o input
            }

            else if($(this).is(":hidden"))
            {
                //se estiver invisivel nao valida o input.
            }

            else
            {
                if ($(this).val() == "") {
                    cont++;
                    $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                    $(this).closest('.form-group').find('i.fa').remove();
                    $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
                }
            }

        });


        if (cont == 0) {
            $("#formModalSalvar").submit();
        }
        else {
            return false;

        }
    });

    $("#btnModalVincular").click(function () {
        var cont = 0;

        $('#formModalVincular .form-control').each(function (i) {
            var verificar = $(this).prop('disabled');

            if($(this).hasClass('naoValidar') == true)
            {
                //não valida o input
            }

            else if($(this).is(":hidden"))
            {
                //se estiver invisivel nao valida o input.
            }

            else
            {
                if ($(this).val() == "") {
                    cont++;
                    $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                    $(this).closest('.form-group').find('i.fa').remove();
                    $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
                }
            }

        });


        if (cont == 0) {
            $("#formModalVincular").submit();
        }
        else {
            return false;

        }
    });


    $("#btnModalAtualizar").click(function () {
        var cont = 0;
        $("#btnModalAtualizar").prop('disabled', true);

        $('#formModalAtualizar .form-control').each(function (i) {
            var verificar = $(this).prop('disabled');
            if($(this).hasClass('naoValidar') == true)
            {

                //não valida o input
            }

            else if($(this).is(":hidden"))
            {
                //se estiver invisivel nao valida o input.
            }

            else
            {
                if ($(this).val() == "") {
                    cont++;
                    $("#btnModalAtualizar").prop('disabled', false);

                    $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                    $(this).closest('.form-group').find('i.fa').remove();
                    $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
                }
            }

        });


        if (cont == 0) {
            $("#btnModalAtualizar").prop('disabled', true);
            $("#formModalAtualizar").submit();
        }
        else {
            return false;

        }
    });




    $("#btnSalvarDados").click(function () {
        var cont = 0;

        $('#formModalDados .form-control').each(function (i) {
            var verificar = $(this).prop('disabled');

            //console.log($(this).attr('class'));
            //alert('else');
            if ($(this).val() == "") {
                cont++;
                $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                $(this).closest('.form-group').find('i.fa').remove();
                $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
            }

        });


        if (cont == 0) {
            $("#formModalDados").submit();
        }
        else {
            return false;

        }
    });




    $("#btnModalCancelar").click(function () {
        var cont = 0;

        $('#formModalCancelar .form-control').each(function (i) {
            var verificar = $(this).prop('disabled');


            if($(this).hasClass('naoValidar') == true)
            {
                //não valida o input
            }

            else if($(this).is(":hidden"))
            {
                //se estiver invisivel nao valida o input.
            }

            else
            {
                if ($(this).val() == "") {
                    cont++;
                    $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                    $(this).closest('.form-group').find('i.fa').remove();
                    $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
                }
            }

        });


        if (cont == 0) {
            $("#formModalCancelar").submit();
        }
        else {
            return false;

        }
    });





});



