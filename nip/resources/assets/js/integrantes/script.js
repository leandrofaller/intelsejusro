
function EditarMatricula(idMatricula,matricula, descricao_matricula) {
    $("#formCadMatricula").show();
    $('#idMatricula').val(idMatricula);
    $('#matricula').val(matricula);
    $('#descricao_matricula').val(descricao_matricula);
    $('#matricula').focus();
}


function EditarNomeBatismo(idNomeBatismo,nome_batismo, descricao_batismo) {
    $("#formCadNomeBatismo").show();
    $('#idNomeBatismo').val(idNomeBatismo);
    $('#nome_batismo').val(nome_batismo);
    $('#descricao_batismo').val(descricao_batismo);
    $('#nome_batismo').focus();
}

function EditarLocalBatismo(idLocalBatismo,nome_localbatismo, descricao_localbatismo) {
    $("#formCadLocalBatismo").show();
    $('#idLocalBatismo').val(idLocalBatismo);
    $('#nome_localbatismo').val(nome_localbatismo);
    $('#descricao_localbatismo').val(descricao_localbatismo);
    $('#nome_localbatismo').focus();
}

function EditarQuebradaOrigem(idQuebradaOrigem,nome_origem, descricao_origem) {
    $("#formCadQuebradaOrigem").show();
    $('#idQuebradaOrigem').val(idQuebradaOrigem);
    $('#nome_origem').val(nome_origem);
    $('#descricao_origem').val(descricao_origem);
    $('#nome_origem').focus();
}

function EditarQuebradaAtual(idQuebradaAtual,nome_atual, descricao_atual) {
    $("#formCadQuebradaAtual").show();
    $('#idQuebradaAtual').val(idQuebradaAtual);
    $('#nome_atual').val(nome_atual);
    $('#descricao_atual').val(descricao_atual);
    $('#nome_atual').focus();
}

function EditarCargo(idCargo,cargo_faccao_id, descricao_cargo) {
    $("#formCadCargo").show();
    $('#idCargo').val(idCargo);
    $('#cargo_faccao_id').val(cargo_faccao_id);
    $('#descricao_cargo').val(descricao_cargo);
    $('#cargo_faccao_id').focus();
}

function EditarReferencia(idReferencia,nome_referencia, descricao_referencia) {
    $("#formCadReferencia").show();
    $('#idReferencia').val(idReferencia);
    $('#nome_referencia').val(nome_referencia);
    $('#descricao_referencia').val(descricao_referencia);
    $('#nome_referencia').focus();
}

function EditarTelefone(idTelefone, ddd, numero_telefone, descricao_telefone) {
    $("#formCadTelefone").show();
    $('#idTelefone').val(idTelefone);
    $('#ddd').val(ddd);
    $('#numero_telefone').val(numero_telefone);
    $('#descricao_telefone').val(descricao_telefone);
    $('#ddd').focus();
}

function EditarPadrinhoInterno(idPadrinhoInterno, padrinho_id, descricao_padrinhointerno) {
    $("#formCadPadrinhoInterno").show();
    $('#idPadrinhoInterno').val(idPadrinhoInterno);
    $('#padrinho_id').val(padrinho_id);
    $('#descricao_padrinhointerno').val(descricao_padrinhointerno);
    $('#padrinho_id').focus();
}

function EditarPadrinhoExterno(idPadrinhoExterno, nome_padrinhoexterno, descricao_padrinhoexterno) {
    $("#formCadPadrinhoExterno").show();
    $('#idPadrinhoExterno').val(idPadrinhoExterno);
    $('#nome_padrinhoexterno').val(nome_padrinhoexterno);
    $('#descricao_padrinhoexterno').val(descricao_padrinhoexterno);
    $('#nome_padrinhoexterno').focus();
}

$(document).ready(function(){
    //limpa formulário
    $('#btnNovoMatricula').click(function(){
        $("#formCadMatricula").show();
        $("#formulario")[0].reset();
        $('#idMatricula').val('0');
        $('#matricula').focus();
        return false;
    });

    $('#btnNovoNomeBatismo').click(function(){
        $("#formCadNomeBatismo").show();
        $("#formulario")[0].reset();
        $('#idNomeBatismo').val('0');
        $('#nome_batismo').focus();
        return false;
    });

    $('#btnNovoLocalBatismo').click(function(){
        $("#formCadLocalBatismo").show();
        $("#formulario")[0].reset();
        $('#idLocalBatismo').val('0');
        $('#nome_localbatismo').focus();
        return false;
    });

    $('#btnNovoQuebradaOrigem').click(function(){
        $("#formCadQuebradaOrigem").show();
        $("#formulario")[0].reset();
        $('#idQuebradaOrigem').val('0');
        $('#nome_origem').focus();
        return false;
    });

    $('#btnNovoQuebradaAtual').click(function(){
        $("#formCadQuebradaAtual").show();
        $("#formulario")[0].reset();
        $('#idQuebradaAtual').val('0');
        $('#nome_atual').focus();
        return false;
    });

    $('#btnNovoCargo').click(function(){
        $("#formCadCargo").show();
        $("#formulario")[0].reset();
        $('#idCargo').val('0');
        $('#nome_cargo').focus();
        return false;
    });

    $('#btnNovoReferencia').click(function(){
        $("#formCadReferencia").show();
        $("#formulario")[0].reset();
        $('#idReferencia').val('0');
        $('#nome_referencia').focus();
        return false;
    });

    $('#btnNovoTelefone').click(function(){
        $("#formCadTelefone").show();
        $("#formulario")[0].reset();
        $('#idTelefone').val('0');
        $('#ddd').focus();
        return false;
    });

    $('#btnNovoPadrinhoInterno').click(function(){
        $("#formCadPadrinhoInterno").show();
        $("#formulario")[0].reset();
        $('#idPadrinhoInterno').val();
        $('#descricao_padrinhointerno').val('0');
        $('#padrinho_id').focus();
        return false;
    });

    $('#btnNovoPadrinhoExterno').click(function(){
        $("#formCadPadrinhoExterno").show();
        $("#formulario")[0].reset();
        $('#idPadrinhoExterno').val();
        $('#descricao_padrinhoexterno').val();
        $('#nome_padrinhoexterno').focus();
        return false;
    });

    $('#btnNovaClassificacao').click(function(){
        $("#formNovaClassificacao").show();
        $("#formulario")[0].reset();
        // $('#idPadrinhoExterno').val();
        // $('#descricao_padrinhoexterno').val();
        // $('#nome_padrinhoexterno').focus();
        return false;
    });

    $(".abrirModalEditarFaccionado").click(function() {
        $("#myModalEditarDadosIntegrante").modal("show");
    });



});