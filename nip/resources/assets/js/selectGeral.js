
$(document).ready(function(){

   $('#unidade_id').on('change', function(e){
        console.log(e);
        var unid_id = e.target.value;
        $.get('http://localhost/sipen/public/carceragem-sub?unid_id=' + unid_id, function(data) {
            $('#carceragem_id').empty();
            $('#cela_id').empty();
            $.each(data, function(index,subCarObj){
                $('#carceragem_id').append('<option value="'+subCarObj.id+'">'+subCarObj.nomecarceragem+'</option>');
            });
        });
    });

    $('#carceragem_id').on('change', function(e){
        console.log(e);
        var carc_id = e.target.value;
        $.get('http://localhost/sipen/public/celas-sub?carc_id=' + carc_id, function(data) {
            $('#cela_id').empty();
            $.each(data, function(index,subCelaObj){
                $('#cela_id').append('<option value="'+subCelaObj.id+'">'+subCelaObj.nomecela+'</option>');
            });
        });
    });

    $('#possivel').on('change', function(e){
        console.log(e);
        var id = e.target.value;
        $.get('http://localhost/sipen/public/classificacao?class_id=' + id, function(data) {
            $('#classificacao').empty();
            $.each(data, function(index,subCelaObj){
                $('#classificacao').append('<option value="'+subCelaObj.id+'">'+subCelaObj.tipo_class+'</option>');
            });
        });
    });


    // $('#possivel').change(function () {
    //     var id = $(this).val();
    //     $('#classificacao').html('').append('<option value=""> Carregando...  </option>');
    //     $.ajax({
    //         url: 'http://localhost/sipen/public/classificacao/'+id,
    //         //  url: '/classificacao/'+id,
    //     }).success(function(data) {
    //         $('#classificacao').empty();
    //         $.each(data, function (key, value) {
    //             $('#classificacao').append("<option value ='"+value.id+"'> "+value.tipo_class+" </option> ");
    //         });
    //     }).error(function(error) {
    //         $('#classificacao').empty();
    //         $('#classificacao').append("<option value =''>Error ao carregar</option> ");
    //     })
    // });




    // $('#unidade_id').change(function () {
    //         var unid_id = $(this).val();
    //         $('#carceragem_id').html('').append('<option value=""> Carregando...  </option>');
    //         $.ajax({
    //             url: 'http://localhost/sipen/public/carceragem-sub/'+unid_id,
    //          //   url: '/carceragem-sub/'+unid_id,
    //         }).success(function(data) {
    //             $('#carceragem_id').empty();
    //             $('#carceragem_id').append('<option value="">Selecione uma Carceragem</option>');
    //             $.each(data, function (key, value) {
    //                 $('#carceragem_id').append("<option value ='"+value.id+"'> "+value.nomecarceragem+" </option> ");
    //             });
    //              $('#carceragem_id').trigger("chosen:updated");
    //         }).error(function(error) {
    //             $('#carceragem_id').empty();
    //             $('#carceragem_id').append("<option value =''>Error ao carregar</option> ");
    //         })
    // });
    //
    // $('#carceragem_id').change(function () {
    //     var carc_id = $(this).val();
    //     $('#cela_id').html('').append('<option value=""> Carregando...  </option>');
    //     $.ajax({
    //             url: 'http://localhost/sipen/public/celas-sub/'+carc_id,
    //          //   url: '/celas-sub/'+carc_id,
    //     }).success(function(data) {
    //         $('#cela_id').empty();
    //         $('#cela_id').append('<option value="">Selecione uma Cela</option>');
    //         $.each(data, function (key, value) {
    //             $('#cela_id').append("<option value ='"+value.id+"'> "+value.nomecela+" </option> ");
    //         });
    //         $('#cela_id').trigger("chosen:updated");
    //     }).error(function(error) {
    //         $('#cela_id').empty();
    //         $('#cela_id').append("<option value =''>Error ao carregar</option> ");
    //     })
    // });


    /////////////////xxxxx//////////////////

    $('#faccao_id').change(function () {
        var fac_id = $(this).val();
        $('#cargo_faccao_id').html('').append('<option value=""> Carregando...  </option>');
        $.ajax({
              url: 'http://localhost/sipen/public/cargo-sub/'+fac_id,
             //  url: '/cargo-sub/'+fac_id,
        }).success(function(data) {
            $('#cargo_faccao_id').empty();
            $.each(data, function (key, value) {
                $('#cargo_faccao_id').append("<option value ='"+value.id+"'> "+value.nomecargo+" </option> ");
            });
            $('#cargo_faccao_id').trigger("chosen:updated");
        }).error(function(error) {
            $('#cargo_faccao_id').empty();
            $('#cargo_faccao_id').append("<option value =''>Error ao carregar</option> ");
        })
    });

    $('#faccao_id').change(function () {
        var fac_id = $(this).val();
        $('#padrinhointerna').html('').append('<option value=""> Carregando...  </option>');
        $.ajax({
              url: 'http://localhost/sipen/public/padrinhos-sub/'+fac_id,
             //   url: '/padrinhos-sub/'+fac_id,
        }).success(function(data) {
            $('#padrinhointerna').empty();
            $('#padrinhointerna').append('<option value=""></option>');
            $.each(data, function (key, value) {
                $('#padrinhointerna').append("<option value ='"+value.id+"'> "+value.nomeapenado+" </option> ");
            });
            $('#padrinhointerna').trigger("chosen:updated");
        }).error(function(error) {
            $('#padrinhointerna').empty();
            $('#padrinhointerna').append("<option value =''>Error ao carregar</option> ");
        })
    });



    $('#regime').change(function () {
        var regime = $(this).val();

        if(regime == 'Fechado'){
            $('#situacao').html('').append(' ' +
                '<option value=""></option> ' +
                '<option value="Condenado"> Condenado </option> ' +
                '<option value="Provisório"> Provisório </option>');
        }else{
            $('#situacao').html('').append('<option value="Condenado"> Condenado </option>');
        }

    });


    //TEMPORÁRIAS - PERMISSAO DE SAÍDA OU SAÍDA TEMPORÁRIA
    $('#tipo').change(function () {
        var tipo = $(this).val();
       if(tipo == '1'){
            $('#motivo').html('').append(' ' +
                '<option value=""></option> ' +
                '<option value="1"> Falecimento de Familiar </option> ' +
                '<option value="2"> Atendimento Médico / Hospitalar </option> ' +
                '<option value="3"> Delegacia </option> ' +
                '<option value="4"> Forum </option> ' +
                '<option value="5"> Cartório </option> ' +
                '<option value="6"> Banco </option> ' +
                '<option value="7"> Inss </option>');
        }else{
            $('#motivo').html('').append(' ' +
                '<option value=""></option> ' +
                '<option value="8"> Visita de Familiar (07 dias) </option> ' +
                '<option value="9"> Frequência a Curso </option> ' +
                '<option value="10"> Projeto de Ressocialização </option> ' +
                '<option value="11"> Ordem Judicial </option>');
        }
    });


    // $('#possivel').change(function () {
    //     var id = $(this).val();
    //     $('#classificacao').html('').append('<option value=""> Carregando...  </option>');
    //     $.ajax({
    //         url: 'http://localhost/sipen/public/classificacao/'+id,
    //         //  url: '/classificacao/'+id,
    //     }).success(function(data) {
    //         $('#classificacao').empty();
    //         $.each(data, function (key, value) {
    //             $('#classificacao').append("<option value ='"+value.id+"'> "+value.tipo_class+" </option> ");
    //         });
    //     }).error(function(error) {
    //         $('#classificacao').empty();
    //         $('#classificacao').append("<option value =''>Error ao carregar</option> ");
    //     })
    // });



});
