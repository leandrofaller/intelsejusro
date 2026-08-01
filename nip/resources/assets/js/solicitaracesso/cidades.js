
$(document).ready(function(){

    // $("select[name='estado']").chosen({no_results_text: "Nenhum resultado encontrado!",
    //     placeholder_text_single: "Selecione",
    //     allow_single_deselect: false
    // });
    //
    // $("select[name*='cidade_id']").chosen({no_results_text: "Nenhum resultado encontrado!",
    //     placeholder_text_single: " ",
    //     allow_single_deselect: false
    // });

    $('#estado').change(function () {
            var idEstado = $(this).val();
            var estado = $('#estado :selected').text();
            $('#cidade').html('').append('<option value=""> Carregando...  </option>');

            $.ajax({
             //     url: 'http://treina-sipe-admin.syspanda.com.br/public/solicitaracessocidades/'+idEstado,
                url: 'solicitaracessocidades/'+idEstado,
            }).success(function(data) {
                $('#cidade').empty();
                $.each(data, function (key, value) {
                    $('#cidade').append("<option value ='"+value.id+"'> "+value.nome+" </option> ");
                });
                $('#cidade').trigger("chosen:updated");


            }).error(function(error) {
                $('#cidade').empty();
                $('#cidade').append("<option value =''>Error ao carregar cidades</option> ");

            })


        }
    );
});
