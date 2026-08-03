$(document).ready(function () {

    $("input[type=text]").each(function () {

        if($(this).hasClass('date') == true   )
        {
            $(this).attr('maxLength', '10');

            $(this).datepicker({
                format: "dd/mm/yyyy",
                language: "pt-BR",
                startDate:"01/01/1900",
                endDate:"31/12/2100",
                forceParse:"__-__-____",
                //startDate: '-20d',
                clearBtn:true,
                autoclose:true,
                todayHighlight:true,
            }).mask("99/99/9999");
            $(this).attr('placeholder', 'dd/mm/aaaa');

        }
        if($(this).hasClass('number') == true   )
        {
            $(this).attr('placeholder', '');
            $(this).attr('maxLength', '4');
            $(this).keypress(function (event) {
                var tecla = (window.event) ? event.keyCode : event.which;
                if ((tecla > 47 && tecla < 58))
                {   return true;
                }
                else {
                    if (tecla != 8)
                        return false;
                    else
                        return true;
                }
            });
        }

        if($(this).hasClass('numberValor') == true   )
        {
            //$(this).attr('placeholder', '');
            //$(this).attr('maxLength', '4');
            $(this).keypress(function (event) {
                var tecla = (window.event) ? event.keyCode : event.which;
                if ((tecla > 45 && tecla < 58))
                {   return true;
                }
                else {
                    if (tecla != 8)
                        return false;
                    else
                        return true;
                }
            });
        }

        if($(this).hasClass('cep') == true   )
        {
            $(this).attr('placeholder', 'Digite o CEP');
            $(this).mask('99-999-999');
        }

        if($(this).hasClass('cpf') == true   )
        {
            $(this).attr('placeholder', 'Digite o CPF');
            $(this).mask('999.999.999-99');
        }

        if($(this).hasClass('fone') == true   )
        {
            $(this).attr('placeholder', 'Telefone Fixo');
            $(this).mask('(99)9999-9999');
        }

        if($(this).hasClass('celular') == true   )
        {
            $(this).attr('placeholder', 'Celular');
            $(this).mask('(99)99999-9999');
        }

        if($(this).hasClass('pis') == true   )
        {
            $(this).attr('placeholder', 'Digite o PIS');
            $(this).mask('(999.999.999-99');
        }



    });





});