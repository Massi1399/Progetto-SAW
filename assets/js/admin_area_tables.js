var all_movies_table = new Tabulator("#all-movies-table", {
    placeholder:"Nessun Film Trovato", //imposta il messaggio da mostrare quando non ci sono risultati
    columnDefaults:{
        minWidth: 130,  
    }, //imposta la larghezza minima delle colonne
    layout:"fitColumns", //adatta la tabella alla grandezza del contenitore
    responsiveLayout:"collapse", //schiaccia le colonne che non ci stanno
    maxHeight:"100%", //imposta l'altezza massima della tabella
    ajaxURL:"https://saw21.dibris.unige.it/~S4669238/private/get_catalog.php",
    columns:[
        {formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"right", minWidth:false,headerSort:false, cellClick:function(e, cell){
            cell.getRow().toggleSelect();
        }},
        {title:"Locandina", field:"img", formatter:"image", headerSort:false, formatterParams:{
            height:"120px",
            width:"80px",
            urlPrefix:"assets/img/film/",
            urlSuffix:".jpg"
        }},
        {title:"Nome", field:"nome", width:150},
        {title:"Genere", field:"genere"},
        {title:"Regista", field:"regista"},
        {title:"Paese", field:"paese"},
        {title:"Anno", field:"anno", width:50},
        {title:"Durata", field:"durata", width:50},
        {title:"Casa di Produzione", field:"casa_produzione", width: 200},
    ]
});

document.getElementById("del-films-btn").addEventListener("click", function(){
    var selectedRows = all_movies_table.getSelectedRows();
    var selectedFilms = selectedRows.map(function(row) {
        return row.getData();
    });
    fetch('https://saw21.dibris.unige.it/~S4669238/private/delete_films.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 'data': selectedFilms }),
    })
    .then(response => {
        if (!response.ok)
            throw new Error();
    })
    .catch((error) => {
        window.location.href = "https://saw21.dibris.unige.it/~S4669238/public/unexpected_error.php";
    });
    window.location.reload();
});

var all_users_table = new Tabulator("#all-users-table", {
    placeholder:"Nessun Utente Trovato", //imposta il messaggio da mostrare quando non ci sono risultati
    layout:"fitColumns",
    maxHeight:"100%",
    ajaxURL:"https://saw21.dibris.unige.it/~S4669238/private/retrieve_all_usr_data.php",
    columns:[
        {formatter:"rowSelection", titleFormatter:"rowSelection" ,hozAlign:"left", minWidth:false, headerSort:false, cellClick:function(e, cell){
            cell.getRow().toggleSelect();
        }},
        {title:"Nome", field:"Nome"},
        {title:"Cognome", field:"Cognome"},
        {title:"Email", field:"Email"},
        {title:"Data di Nascita", field:"Data_Nascita", width:250 },
        {title:"Genere", field:"Genere"},   
        {title:"Nazionalità", field:"Nazionalità"},  
        {title:"Ban", field:"Ban", formatter:"tickCross" }           
    ]
});

document.getElementById("del-users-btn").addEventListener("click", function(){
    var selectedRows = all_users_table.getSelectedRows();
    var selectedUsers = selectedRows.map(function(row) {
        return row.getData();
    });
    fetch('https://saw21.dibris.unige.it/~S4669238/private/delete_users.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 'data': selectedUsers }),
    })
    .then(response => {
        if (!response.ok)
            throw new Error();
    })
    .catch((error) => {
        window.location.href = "https://saw21.dibris.unige.it/~S4669238/public/unexpected_error.php";
    });
    window.location.reload();
});

document.getElementById("ban-users-btn").addEventListener("click", function() {
    var selectedRows = all_users_table.getSelectedRows();
    var selectedUsers = selectedRows.map(function(row) {
        return row.getData();
    });
    fetch('https://saw21.dibris.unige.it/~S4669238/private/ban_users.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 'data': selectedUsers }),
    })
    .then(response => {
        if (!response.ok)
            throw new Error();
    })
    .catch((error) => {
        window.location.href = "https://saw21.dibris.unige.it/~S4669238/public/unexpected_error.php";
    });
    window.location.reload();
});