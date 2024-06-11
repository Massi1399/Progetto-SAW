var searchBar = new URLSearchParams(window.location.search).get('searchBar');
var filter = new URLSearchParams(window.location.search).get('filter');

if(searchBar == null) searchBar = "";
if(filter == null) filter = "";

var table = new Tabulator("#catalog-table", {
    placeholder:"Nessun Film Trovato", //imposta il messaggio da mostrare quando non ci sono risultati
    layout:"fitColumns", //imposta la larghezza delle colonne in base al contenuto
    responsiveLayout:"collapse", //schiaccia le colonne che non ci stanno
    maxHeight:"100%", //imposta l'altezza massima della tabella
    ajaxURL:"https://saw21.dibris.unige.it/~S4669238/private/get_catalog.php?searchBar=" + searchBar + "&filter=" + filter,
    columns:[
        {title:"Locandina", field:"img", formatter:"image", headerSort:false, formatterParams:{
            height:"120px",
            width:"80px",
            urlPrefix:"assets/img/film/",
            urlSuffix:".jpg"
        }},
        {title:"Nome", field:"nome"},
        {title:"Genere", field:"genere"},
        {title:"Regista", field:"regista"},
        {title:"Paese", field:"paese"},
        {title:"Anno", field:"anno"},
        {title:"Durata", field:"durata"},
        {title:"Casa di Produzione", field:"casa_produzione"},
        
    ]
});

table.on("rowClick", function(e, row){
    var data = row.getData();
    var url = "https://saw21.dibris.unige.it/~S4669238/public/movie_page.php?NomeFilm=" + data.nome;
    window.location.href = url;
});