$(document).ready(function () {

    $('#formulario input, #formulario select').blur(function () {
        var tes = $(this).val();
        if($(this).hasClass('chosen-choices') == true)
        {
          //não valida o input
        }
        else
        {
            if ($(this).val() == "") {
                if($(this).attr('type') == 'file' )
                {
                    $(this).closest('.form-group').removeClass('has-error has-feedback'); //.addClass('has-success has-feedback');
                    $(this).closest('.form-group').find('i.fa').remove();
                }
                else{
                $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                  $(this).closest('.form-group').find('i.fa').remove();
                // $(this).closest('.form-group').append('<i class="fa fa-times  form-control-feedback"></i>');
                }
            }
            else {
                $(this).closest('.form-group').removeClass('has-error has-feedback'); //.addClass('has-success has-feedback');
                $(this).closest('.form-group').find('i.fa').remove();
            }
        }
    });


    $("#btnEnviar").click(function () {
        $("#btnEnviar").prop('disabled', true);
        var cont = 0;
        $('#formulario input, #formulario select').each(function (i) {
            var verificar = $(this).prop('disabled');
            if (verificar == false) {
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
                    if ($(this).val() == "" || $(this).val() == null) {
                        cont++;
                        $(this).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                        // $(this).closest('.form-group').find('i.fa').remove();
                        // $(this).closest('.form-group').append('<i class="fa fa-times  form-control-feedback"></i>');
                        $("#btnEnviar").prop('disabled', false);
                    }
                    else {
                        $(this).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
                        // $(this).closest('.form-group').find('i.fa').remove();
                        // $(this).closest('.form-group').append('<i class="fa fa-check  form-control-feedback"></i>');
                        $("#btnEnviar").prop('disabled', false);
                    }

                }

            }
        });

        if (cont == 0) {
            $("#btnEnviar").prop('disabled', true);
            $("#formulario").submit();

        }
        else {
           //  alert('Os campos sinalizados com x devem ser informados verifique se todos eles estão preenchidos.');
            return false;

        }
    });
});


