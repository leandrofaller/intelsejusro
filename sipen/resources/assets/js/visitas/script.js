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





    $('a[name=btnTipo]').click(function(){
        //$('#myModal').modal('show')
        $("#myModalTipo").modal({backdrop: "static"});
    });





    $('a[name=btnEditar]').click(function(){

         $('#id').val($(this).closest('tr').find('td[data-id]').data('id'));
         $('#nomevisita').val($(this).closest('tr').find('td[data-nomevisita]').data('nomevisita'));
         $('#cpfvisita').val($(this).closest('tr').find('td[data-cpfvisita]').data('cpfvisita'));
         $('#rgvisita').val($(this).closest('tr').find('td[data-rgvisita]').data('rgvisita'));
         $('#datanascimentovisita').val($(this).closest('tr').find('td[data-datanascimentovisita]').data('datanascimentovisita'));
         $('#enderecovisita').val($(this).closest('tr').find('td[data-enderecovisita]').data('enderecovisita'));
         $('#ufvisita').val($(this).closest('tr').find('td[data-ufvisita]').data('ufvisita'));
         $('#cidadevisita').val($(this).closest('tr').find('td[data-cidadevisita]').data('cidadevisita'));
         $('#telefonecontato').val($(this).closest('tr').find('td[data-telefonecontato]').data('telefonecontato'));
         $('#dataemicaocarteirinha').val($(this).closest('tr').find('td[data-dataemicaocarteirinha]').data('dataemicaocarteirinha'));

            var fotovisita = $(this).closest('tr').find('td[data-fotovisita]').data('fotovisita');
           // alert(fotovisita);
            $('#fotovisita').attr('src', fotovisita );

        $("#myModalEditar").modal({backdrop: "static"});

    });

    $('a[name=btnCancelar]').click(function(){

        $('#id').val($(this).closest('tr').find('td[data-id]').data('id'));
        $('#nomevisita').val($(this).closest('tr').find('td[data-nomevisita]').data('nomevisita'));
        $('#parentescovisita').val($(this).closest('tr').find('td[data-parentescovisita]').data('parentescovisita'));

        $('#visitaapen').val($(this).closest('tr').find('td[data-visitaapen]').data('visitaapen'));
        $('#dataemicaocarteirinha').val($(this).closest('tr').find('td[data-dataemicaocarteirinha]').data('dataemicaocarteirinha'));
        $('#apenado_id').val($(this).closest('tr').find('td[data-apenado_id]').data('apenado_id'));
        $('#cpfvisita').val($(this).closest('tr').find('td[data-cpfvisita]').data('cpfvisita'));

        // var fotovisita = $(this).closest('tr').find('td[data-fotovisita]').data('fotovisita');
        // $('#fotovisita').attr('src', fotovisita );

        $("#myModalCancelar").modal({backdrop: "static"});

    });



    $('#datanascimentovisita').change(function () {

        var nasc = $('#datanascimentovisita').val();

        $('#idade').val();

    });




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