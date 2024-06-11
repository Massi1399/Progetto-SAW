<?php
    include(dirname(__FILE__)."/../phpinfo.php");

include(DOCUMENT_ROOT."/components/head.php");
include(DOCUMENT_ROOT."/components/navbar/navbar.php");
?>

<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: auto; border: 2px solid #000; margin: 10px; padding: 20px; background-color: white; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0,0,0,0.5);">
        <h1 style="margin-bottom: 20px;">Account non disponibile</h1>
        <p style="font-size: 20px; font-weight: bold;">Attenzione! L'account che hai provato a creare esiste già!</p>
    </div>
</div>

<?php
include(DOCUMENT_ROOT."/components/footer.php");
?>