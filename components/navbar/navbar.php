<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="public/index.php"><img src="assets/img/logo2.png" alt="Logo"></a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto centered-nav">
            <li class="nav-item">
                <a class="nav-link" href="public/index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="public/catalog.php">Catalogo</a>
            </li>
        </ul>
        <?php
                // Ottieni il nome del file corrente
                $currentFile = basename($_SERVER['PHP_SELF']);

                // Se il file corrente è catalog.php, mostra la barra di ricerca
                if ($currentFile == 'catalog.php') {
            ?>
            <form class="d-flex flex-row" action="https://saw21.dibris.unige.it/~S4669238/public/catalog.php" method="POST">
                <input class="form-control mr-sm-2" type="search" name="searchBar" placeholder="Cerca" aria-label="Cerca" style="width:250px">
                <div class="dropdown mx-sm-3">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-filter"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <label class="dropdown-item">
                            <input type="radio" class="mr-1" id="nome" name="filter" value="Nome" checked>
                            Nome
                        </label>
                        <label class="dropdown-item">
                            <input type="radio" class="mr-1" id="genere" name="filter" value="Genere">
                            Genere
                        </label>
                        <label class="dropdown-item">
                            <input type="radio" class="mr-1" id="regista" name="filter" value="Regista">
                            Regista
                        </label>
                        <label class="dropdown-item">
                            <input type="radio" class="mr-1" id="paese" name="filter" value="Paese">
                            Paese
                        </label>
                        <label class="dropdown-item">
                            <input type="radio" class="mr-1" id="anno" name="filter" value="Anno">
                            Anno
                        </label>
                        <label class="dropdown-item">
                            <input type="radio" class="mr-1" id="casa_produzione" name="filter" value="Casa_Produzione">
                            Casa di Produzione
                        </label>
                    </div>
                </div>
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cerca</button>
            </form>
            <?php
                }
            ?>
        <ul class="navbar-nav mr-auto centered-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                    <?php
                        if(isset($_SESSION['login']) && !empty($_SESSION['login'])){
                            if(isset($_SESSION['admin']) && $_SESSION['admin']){
                                echo "<a class='dropdown-item' href='private/show_profile.php'>Area riservata</a>";
                                echo "<a class='dropdown-item' href='private/admin_area.php'>Area amministrativa</a>";
                                echo "<a class='dropdown-item' href='private/logout.php'>Esci</a>";
                            }
                            else{
                                echo "<a class='dropdown-item' href='private/show_profile.php'>Area riservata</a>";
                                echo "<a class='dropdown-item' href='private/logout.php'>Esci</a>";
                            }
                        }
                        else{
                            echo "<a class='dropdown-item' href='private/registration.php'>Registrati</a>";
                            echo "<a class='dropdown-item' href='private/login.php'>Accedi</a>";
                        }
                    ?>    
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="main-container">    