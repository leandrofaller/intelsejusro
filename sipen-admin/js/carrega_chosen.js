/**
 * Created by jodeilson on 11/03/17.
 */

$(document).ready(function(){
    $(".chosen-select").each(function(i){
        $(this).chosen({no_results_text: "Nenhum resultado encontrado!",
            allow_single_deselect: true
        });
    });
});
