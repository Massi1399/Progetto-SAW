$(document).ready(function(){
    $(".dropdown-menu input[type='radio']").click(function(){
        var selected = $(this).val();
        $("#dropdownMenuButton").html('<i class="fas fa-filter"></i> ' + selected);
    });

    // Triggera un click event sul radio button selezionato quando la pagina viene caricata
    $(".dropdown-menu input[type='radio']:checked").click();
});