<?php
    include_once(dirname(__FILE__)."/../phpinfo.php");

    if(!isset($_SESSION)) 
        session_start(); 
    if(!isset($_SESSION["admin"]) && !$_SESSION["admin"] )
        header('Location: login.php');
    else{
        include(DOCUMENT_ROOT."/private/connection.php");
        try{
            // ottiene il contenuto della richiesta (php://input è uno stream), e fa la decode in un array associativo (true)
            $data = json_decode(file_get_contents('php://input'), true);
            $selectedUsers = $data['data'];

            $stmt = mysqli_prepare($con, "UPDATE utenti SET Ban = NOT Ban WHERE Email = ?");

            // Itera tra gli utenti selezionati ed esegue la query per ognuno
            foreach ($selectedUsers as $user) {
                mysqli_stmt_bind_param($stmt, "s", $user['Email']);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }
        catch(mysqli_sql_exception $e){
            error_log($e->getMessage(), 3, DOCUMENT_ROOT."/private/logs/errors.log");
            header("Location: ../public/unexpected_error.php");
            exit;
        }
    }
?>