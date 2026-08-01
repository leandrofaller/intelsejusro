

$(".abrirModal").click(function() {
    var foto = $(this).closest('tr').find('td[data-foto]').data('foto');
    $("#myModal img").attr("src", foto);
    $("#myModal").modal("show");
});
