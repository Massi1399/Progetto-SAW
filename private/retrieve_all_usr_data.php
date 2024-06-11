<?php
    include_once(dirname(__FILE__)."/../phpinfo.php");

    if(!isset($_SESSION))
        session_start();
    header('Content-Type: application/json');    
    //se l'utente è admin, carica tutti gli utenti    
    if( isset($_SESSION['admin']) && $_SESSION['admin'] ){
        include(DOCUMENT_ROOT."/private/connection.php");
        try{
            $query = "SELECT * FROM utenti";
            $res = mysqli_query($con, $query);
            $data = array();
            while($row = mysqli_fetch_assoc($res)){
                if($row["Admin"] == 0)
                    $data[] = array("Nome"=>htmlspecialchars($row["Nome"]), 
                                    "Cognome"=> htmlspecialchars($row["Cognome"]),
                                    "Email"=> htmlspecialchars($row["Email"]),
                                    "Data_Nascita"=>htmlspecialchars($row["Data_Nascita"]), 
                                    "Genere"=> htmlspecialchars($row["Genere"]),
                                    "Nazionalità"=>htmlspecialchars($row["Nazionalità"]), 
                                    "Ban"=>intval($row["Ban"]));
            }
            echo(json_encode($data));
            exit;
        }
        catch(mysqli_sql_exception $e){
            error_log($e->getMessage(), 3, DOCUMENT_ROOT."/private/logs/errors.log");
            header('Location: ../public/unexpected_error.php'); 
            exit(); 
        }    
    }
    else
        header('Location: login.php');
?>