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



     // $('#btnNovo').click(function(){
     //     alert('oi');
     //     //$('#myModal').modal('show')
     //     $("#myModalNovo").modal({backdrop: "static"});
     // });
     //
     // $('#btnEditarDados').click(function(){
     //     $("#myModalDados").modal({backdrop: "static"});
     // });

    $('a[name=btnVincular]').click(function(){
      // alert('oi');
        //$('#myModal').modal('show')
        $("#myModalVincular").modal({backdrop: "static"});
    });



    $('a[name=btnNovo]').click(function(){
        //alert('oi');
        $('#myModalVincular').modal('hide')
        $("#myModalNovo").modal({backdrop: "static"});
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

    $('a[name=btnConcluir]').click(function(){
        $('#id').val($(this).closest('tr').find('td[data-id]').data('id'));
        $('#apenado_id').val($(this).closest('tr').find('td[data-apenado_id]').data('apenado_id'));
        $('#ocorrencia_md').val($(this).closest('tr').find('td[data-ocorrencia_md]').data('ocorrencia_md'));
        $('#tipomedida_md').val($(this).closest('tr').find('td[data-tipomedida_md]').data('tipomedida_md'));
        $('#tempo_md').val($(this).closest('tr').find('td[data-tempo_md]').data('tempo_md'));

        $('#datainicio_md').val($(this).closest('tr').find('td[data-datainicio_md]').data('datainicio_md'));
        $('#plantao_md').val($(this).closest('tr').find('td[data-plantao_md]').data('plantao_md'));
        $('#datafim_md').val($(this).closest('tr').find('td[data-datafim_md]').data('datafim_md'));
        $('#unidades_md').val($(this).closest('tr').find('td[data-unidades_md]').data('unidades_md'));
        $('#descricao_md').val($(this).closest('tr').find('td[data-descricao_md]').data('descricao_md'));

        $("#myModalConcluir").modal({backdrop: "static"});

    });


    $('select[name=tempo_md1]').change(function (event){
        event.preventDefault();
            var datainicio = $('#datainicio_md1').val();
            var tempo = $('#tempo_md1').val();
            var dtfim = moment(datainicio, "DD/MM/YYYY").add(tempo, 'd').format("DD/MM/YYYY");
            $("#datafim_md1").val(dtfim);
    });


    // $('select[name=tipomedida_md]').change(function (event){
    //     event.preventDefault();
    //
    //     var motivo = $('#tipomedida_md').val();
    //     if(this.value == 'Outras Unidades')
    //     {
    //         $('#unidadeDiv').show();
    //     }
    //     else
    //     {
    //         $('#unidadeDiv').hide();
    //         $('#unidades_md').empty();
    //     }
    // });








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
        $("#btnModalsalvar").prop('disabled', true);

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
                    $("#btnModalsalvar").prop('disabled', false);

                    cont++;
                    $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                    $(this).closest('.form-group').find('i.fa').remove();
                    $(this).closest('.form-group').append('<i class="fa fa-times form-control-feedback"></i>');
                }
            }

        });


        if (cont == 0) {
            $("#btnModalsalvar").prop('disabled', true);
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




    $("#btnModalConcluir").click(function () {
        var cont = 0;

        $('#btnModalConcluir .form-control').each(function (i) {
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
            $("#btnModalConcluir").submit();
        }
        else {
            return false;

        }
    });



});