<?php
    include_once(dirname(__FILE__)."/../phpinfo.php");

  if(!isset($_SESSION)){
    session_start();
  }
  //rimosso controllo $_SESSION["login"] === false
  if(!isset($_SESSION['login'])){
    header("Location: login.php");
  }
  //rimosso controllo su $_SESSION["ID_Film"] vuoto
  if(!isset($_SESSION["ID_Film"])){
    //aggiunto controllo su $_SESSION["NomeFilm"]
    if(isset($_SESSION["NomeFilm"]))
      header("Location: ../public/movie_page.php?NomeFilm=".$_SESSION["NomeFilm"]);
    //aggiunta redirezione ad errore in caso di $_SESSION["NomeFilm"] vuoto
    else
      header("Location: ../public/unexpected_error.php");
  }
  else{
    if($_SERVER["REQUEST_METHOD"] == "POST" ){
      include(DOCUMENT_ROOT."/private/connection.php");
      try{
        $Regia = intval($_POST["Regia"]);
        $Sceneggiatura = intval($_POST["Sceneggiatura"]);
        $Colonna_Sonora = intval($_POST["Colonna_Sonora"]);
        $Recitazione = intval($_POST["Recitazione"]);
        $Fotografia = intval($_POST["Fotografia"]);
        //rimosso controllo intaval su ID_Utente e ID_Film
        $ID_Utente = $_SESSION["ID"];
        $ID_Film = $_SESSION["ID_Film"];
        $query = "INSERT INTO recensioni (ID_Utente, ID_Film, Regia, Sceneggiatura, Colonna_Sonora, Recitazione, Fotografia) VALUES (?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "iiiiiii", $ID_Utente, $ID_Film, $Regia, $Sceneggiatura, $Colonna_Sonora, $Recitazione, $Fotografia);
        mysqli_stmt_execute($stmt);
        header("Location: ../public/movie_page.php?NomeFilm=".$_SESSION["NomeFilm"]);
        exit;
      }
        catch(mysqli_sql_exception $e)
        {
            if($e->getCode() == 1062)
            {
                header("Location: ../public/movie_page.php?NomeFilm=".$_SESSION["NomeFilm"]."&reviewError=reviewed");
                exit;
            }
            error_log($e->getMessage(), 3, DOCUMENT_ROOT."/private/logs/errors.log");
            header("Location: ../public/unexpected_error.php");
            exit;
        }
    }
  else
    include(DOCUMENT_ROOT."/private/review_form.php");
  }
?>