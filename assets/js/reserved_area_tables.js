var reviews_table = new Tabulator("#reviews-table", {
    placeholder:"Non hai ancora effettuato nessuna recensione", //imposta il messaggio da mostrare quando non ci sono risultati
    /*columnDefaults:{
        minWidth: 100,
    }, //imposta la larghezza minima delle colonne*/
    layout:"fitData", //adatta la tabella alla grandezza del contenitore
    //responsiveLayout:"collapse", //schiaccia le colonne che non ci stanno
    ajaxURL:"https://saw21.dibris.unige.it/~S4669238/private/retrieve_usr_reviews.php",
    maxHeight:"100%", //imposta l'altezza massima della tabella
    validationMode:"blocking", //blocca l'invio dei dati se non validi
    columns:[
        {formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"right", headerSort:false, cellClick:function(e, cell){
            cell.getRow().toggleSelect();
        }},
        {title:"Titolo", field:"Titolo"},
        {title:"Regia", field:"Regia", editor:"number",validator:["min:0", "max:5", "required"], editorParams:{
            min:0,
            max:5,
        }},
        {title:"Sceneggiatura", field:"Sceneggiatura", editor:"number", validator:["min:0", "max:5", "required"], editorParams:{
            min:0,
            max:5,
        }},
        {title:"ColonnaSonora", field:"Colonna_Sonora", editor:"number", validator:["min:0", "max:5","required"],editorParams:{
            min:0,
            max:5,
        }},
        {title:"Recitazione", field:"Recitazione", editor:"number", validator:["min:0", "max:5","required"], editorParams:{
            min:0,
            max:5,
        }},
        {title:"Fotografia", field:"Fotografia", editor:"number", validator:["min:0", "max:5","required"], editorParams:{
            min:0,
            max:5,
        }}
    ],
});

document.getElementById('modify-usr-reviews-button').addEventListener('click', function() {
    // ottieni le righe selezionate
    var selectedRows = reviews_table.getSelectedRows();
    // ottieni i dati delle righe selezionate come array
    var selectedReviews = selectedRows.map(function(row) {
        return row.getData();
    });
    
    fetch('https://saw21.dibris.unige.it/~S4669238/private/update_reviews.php',{
        method : 'post',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({selectedReviews})
    })
    .then(function (response){
        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
    })
    .catch(function (error){
        window.location.href = "https://saw21.dibris.unige.it/~S4669238/public/unexpected_error.php";
    });
    window.location.reload();

});