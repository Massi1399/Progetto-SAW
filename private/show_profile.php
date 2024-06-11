<?php
    include_once(dirname(__FILE__)."/../phpinfo.php");

    if(!isset($_SESSION)) { 
        session_start(); 
    }
    if(!isset($_SESSION['login']) || empty($_SESSION['login']))
        header('Location: login.php');
    else{
        include(DOCUMENT_ROOT."/components/head.php");
        include(DOCUMENT_ROOT."/components/navbar/navbar.php");
?>     
        <div class="show-profile-container">
            <div class="table-container">
                <h1>Area Riservata</h1>
                <div class="user-content">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="user-tab" data-bs-toggle="tab" data-bs-target="#user-tab-pane" type="button" role="tab" aria-controls="user-tab-pane" aria-selected="true">Il mio Profilo</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">Le mie Recensioni</button>
                        </li>                       
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="user-tab-pane" role="tabpanel" aria-labelledby="user-tab" tabindex="0">
                        <button id="modify-usr-data-button" onclick="location.href='private/update_profile.php';">Modifica Profilo</button>                 
                            <p><strong>Per modificare i tuoi dati personali clicca sul pulsante "Modifica Profilo"</strong></p>
                            <div class="profile-content row">
                                <div class="col-4">
                                    <img src="assets/img/user_icon.png" alt="User Icon" class="user-icon">
                                </div>
                                <div class="col-8">
                                    <div class="mb-3 row">
                                        <p class="form-label col-6"><strong>Nome</strong></p>
                                        <p id="firstname" class="col-6">
                                        <?php if(isset($_SESSION["firstname"]))echo $_SESSION["firstname"]; else echo "Nessun Dato"?>
                                        </p>
                                    </div>
                                    <div class="mb-3 row">
                                        <p class="form-label col-6"><strong>Cognome</strong></p>
                                        <p id="lastname" class="col-6">
                                        <?php if(isset($_SESSION["lastname"]))echo $_SESSION["lastname"]; else echo "Nessun Dato"?>
                                        </p>
                                    </div>
                                    <div class="mb-3 row">
                                        <p class="form-label col-6"><strong>Email</strong></p>
                                        <p id="email" class="col-6">
                                        <?php if(isset($_SESSION["email"]))echo $_SESSION["email"]; else echo "Nessun Dato"?>
                                        </p>
                                    </div>
                                    <div class="mb-3 row">
                                        <p class="form-label col-6"><strong>Data di Nascita</strong></p>
                                        <p id="birthdate" class="col-6">
                                        <?php if(isset($_SESSION["birthdate"]))echo $_SESSION["birthdate"]; else echo "Nessun Dato"?>
                                        </p>
                                    </div>
                                    <div class="mb-3 row">
                                            <p class="form-label col-6"><strong>Genere</strong></p>
                                            <p id="gender" class="col-6">
                                            <?php if(isset($_SESSION["gender"]))echo $_SESSION["gender"]; else echo "Nessun Dato"?>
                                            </p>
                                    </div>
                                    <div class="mb-3 row">
                                            <p class="form-label col-6"><strong>Nazionalità</strong></p>
                                        <p id="nationality" class="col-6">
                                        <?php if(isset($_SESSION["nationality"]))echo $_SESSION["nationality"]; else echo "Nessun Dato"?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                        <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab" tabindex="0">
                            <p><strong>Per modificare le tue recensioni seleziona le recensioni da modificare scrivi direttamente sulla tabella in nuovi voti e poi clicca sul pulsante "Modifica Recensione"</strong></p>
                            <button id="modify-usr-reviews-button">Modifica Recensione</button>                 
                            <div class="profile-content">
                                    <div id="reviews-table"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
<?php
        include(DOCUMENT_ROOT."/components/footer.php");
    }   
?>