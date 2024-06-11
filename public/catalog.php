<?php
    include_once(dirname(__FILE__)."/../phpinfo.php");

if(isset($_POST["searchBar"]) && isset($_POST["filter"])){
    header("Location: https://saw21.dibris.unige.it/~S4669238/public/catalog.php?searchBar=".$_POST["searchBar"]."&filter=".$_POST["filter"]);
    exit();
}
else{
    include(DOCUMENT_ROOT."/components/head.php");
    include(DOCUMENT_ROOT."/components/navbar/navbar.php");
?>
    <div class="table-container">
    <div id="catalog-table"></div>
    </div>
<?php
    include(DOCUMENT_ROOT."/components/footer.php");
}
?>