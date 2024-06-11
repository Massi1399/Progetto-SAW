<?php
    include_once(dirname(__FILE__)."/../phpinfo.php");

    if(!isset($_SESSION))
        session_start();
    if(!isset($_SESSION['login']) || empty($_SESSION['login']))
        header('Location: login.php');
    else{
        header('Content-Type: application/json');

        $body = file_get_contents('php://input');
        $data = json_decode($body,true);
        $selectedReviews = $data['selectedReviews'];

        include(DOCUMENT_ROOT."/private/connection.php");

        try{
            $query = "UPDATE recensioni SET Regia = ?, Sceneggiatura = ?, Colonna_Sonora = ?, Recitazione = ?, Fotografia = ? WHERE ID_Utente = ? AND ID_Film = ?;";
            $stmt = mysqli_prepare($con, $query);
            $ID_Utente = $_SESSION['ID'];
            foreach($selectedReviews as $review){
                $regia = intval($review["Regia"]);
                $sceneggiatura = intval($review['Sceneggiatura']);
                $colonna_sonora = intval($review['Colonna_Sonora']);
                $recitazione = intval($review['Recitazione']);
                $fotografia = intval($review['Fotografia']);
                $ID_Film = $review['ID'];
                mysqli_stmt_bind_param($stmt, 'iiiiiii', $regia, $sceneggiatura, $colonna_sonora, $recitazione, $fotografia, $ID_Utente, $ID_Film);
                mysqli_stmt_execute($stmt);
                $res = mysqli_stmt_get_result($stmt);
                
                    
            }
            if(mysqli_affected_rows($con) == 0)
                echo json_encode(array("Errore" => "Impossibile modificare la recensione"));
        }
        catch(mysqli_sql_exception $e){
            error_log($e->getMessage(), 3, DOCUMENT_ROOT."/private/logs/errors.log");
            header('Location: ../public/unexpected_error.php');
            exit;
        }    
    }    
?>