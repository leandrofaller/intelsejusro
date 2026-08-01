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



    $('a[name=btnCancelar]').click(function(){

        $('#id').val($(this).closest('tr').find('td[data-id]').data('id'));
        $('#nomeapenado').val($(this).closest('tr').find('td[data-nomeapenado]').data('nomeapenado'));
        $('#sigla').val($(this).closest('tr').find('td[data-sigla]').data('sigla'));

        $('#apenado_id').val($(this).closest('tr').find('td[data-apenado_id]').data('apenado_id'));

        $("#myModalCancelar").modal({backdrop: "static"});

    });






    $('a[name=btnNovo]').click(function(){
        $("#myModalNovo").modal({backdrop: "static"});
    });

    $('a[name=btnAnexar]').click(function(){
        $("#myModalAnexar").modal({backdrop: "static"});
    });

    $('a[name=btnInformacoes]').click(function(){
        $("#myModalInformacoes").modal({backdrop: "static"});
    });


    $('a[name=btnEditar]').click(function(){

         $('#idApen').val($(this).closest('tr').find('td[data-idApen]').data('idApen'));
         $('#nomeapenado').val($(this).closest('tr').find('td[data-nomeapenado]').data('nomeapenado'));
         $('#nomedebatismo').val($(this).closest('tr').find('td[data-nomedebatismo]').data('nomedebatismo'));
         $('#idIntegrante').val($(this).closest('tr').find('td[data-idIntegrante]').data('idIntegrante'));
         $('#matricula').val($(this).closest('tr').find('td[data-matricula]').data('matricula'));
         $('#localbatismo').val($(this).closest('tr').find('td[data-localbatismo]').data('localbatismo'));
         $('#databatismo').val($(this).closest('tr').find('td[data-databatismo]').data('databatismo'));
         $('#referencia').val($(this).closest('tr').find('td[data-referencia]').data('referencia'));
         $('#descricaorelevante').val($(this).closest('tr').find('td[data-descricaorelevante]').data('descricaorelevante'));
         $('#padrinho').val($(this).closest('tr').find('td[data-padrinho]').data('padrinho'));
         $('#faccao_id').val($(this).closest('tr').find('td[data-faccao_id]').data('faccao_id'));
         $('#cargo_faccao_id').val($(this).closest('tr').find('td[data-cargo_faccao_id]').data('cargo_faccao_id'));

        $("#myModalEditar").modal({backdrop: "static"});

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


    $("#btnAnexarDados").click(function () {
        var cont = 0;
        $("#btnAnexarDados").prop('disabled', true);

        $('#formModalAnexar .form-control').each(function (i) {
            var verificar = $(this).prop('disabled');
            if ($(this).val() == "") {
                cont++;
                $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                $(this).closest('.form-group').find('i.fa').remove();
                $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
                $("#btnAnexarDados").prop('disabled', false);
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


    $("#btnInformaDados").click(function () {
        var cont = 0;
         $("#btnInformaDados").prop('disabled', true);

        $('#formModalInformacoes .form-control').each(function (i) {
            var verificar = $(this).prop('disabled');
            if ($(this).val() == "") {
                cont++;
                $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                $(this).closest('.form-group').find('i.fa').remove();
                $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
                $("#btnInformaDados").prop('disabled', false);

            }
        });
        if (cont == 0) {
            $("#btnInformaDados").prop('disabled', true);
            $("#formModalInformacoes").submit();
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


    $("#btnModalAtualizar").click(function () {
        var cont = 0;

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
                    $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                    $(this).closest('.form-group').find('i.fa').remove();
                    $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
                }
            }

        });


        if (cont == 0) {
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