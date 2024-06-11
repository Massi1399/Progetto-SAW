<?php
    include_once(dirname(__FILE__)."/../phpinfo.php");

    if(!isset($_SESSION))
        session_start();
    header('Content-Type: application/json');    
    if( isset($_SESSION['ID']) && !empty($_SESSION['ID']) ){
        $ID = $_SESSION['ID'];
        include(DOCUMENT_ROOT."/private/connection.php");
        try{
            $query = "SELECT * FROM recensioni INNER JOIN film ON recensioni.ID_Film = film.ID WHERE ID_Utente = ? ;";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'i', $ID);
            mysqli_stmt_execute($stmt);
            $res=mysqli_stmt_get_result($stmt);
            
            $count = mysqli_num_rows($res);
        }
        catch(mysqli_sql_exception $e){
            error_log($e->getMessage(), 3, DOCUMENT_ROOT."/private/logs/errors.log");
            header('Location: ../public/unexpected_error.php');
            exit; 
        }
        if($count != 0){
            while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                $data[] = [
                "Titolo"=> htmlspecialchars($row["Nome"]),
                "ID"=> intval($row["ID_Film"]),
                "Regia"=> intval($row["Regia"]),
                "Sceneggiatura"=> intval($row["Sceneggiatura"]),
                "Colonna_Sonora"=> intval($row["Colonna_Sonora"]),
                "Recitazione"=> intval($row["Recitazione"]),
                "Fotografia"=> intval($row["Fotografia"])
                ];
            }    
            echo json_encode($data);
        }
        else
            echo json_encode(array("Errore"=>"Impossibile caricare le tue recensioni"));
    }  
    else
        header('Location: login.php');
?>