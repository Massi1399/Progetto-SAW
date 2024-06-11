<?php
    include_once(dirname(__FILE__)."/../phpinfo.php");

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
		include (DOCUMENT_ROOT."/components/head.php");
		include (DOCUMENT_ROOT."/components/navbar/navbar.php");
		include (DOCUMENT_ROOT."/components/main/log-form.php");
		include (DOCUMENT_ROOT."/components/footer.php");
	}
    else{
        if(!isset($_SESSION)) { 
            session_start(); 
        } 

        $arr_fields = array('email', 'pass');
		foreach ($arr_fields as $field) {
			if (!isset( $_POST[$field]) || empty($_POST[$field])) {
				header('Location: ../public/invalid_input.php');
                exit;
			}
		}

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $pwd = filter_var($_POST['pass'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^.{8,}$/")));

        if(!$email || !$pwd){
            header("Location: ../public/invalid_input.php");
            exit;
        }

        include(DOCUMENT_ROOT."/private/connection.php");

        try{
            $query = "SELECT * FROM utenti WHERE Email = ?;";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            $res=mysqli_stmt_get_result($stmt);  
            $row = mysqli_fetch_assoc($res);  
            $count = mysqli_num_rows($res);
        
            if($count == 1){
                if(password_verify($pwd, $row["Password"])){
                    $_SESSION['login'] = true;
                    $_SESSION['ID'] = htmlspecialchars($row["ID"]);
                    $_SESSION['banned'] = htmlspecialchars($row["Ban"]);
                    $_SESSION['firstname'] = htmlspecialchars($row["Nome"]);
                    $_SESSION['lastname'] = htmlspecialchars($row["Cognome"]);
                    $_SESSION['email'] = htmlspecialchars($row["Email"]);
                    $_SESSION['birthdate'] = htmlspecialchars($row["Data_Nascita"]);
                    $_SESSION['gender'] = htmlspecialchars($row["Genere"]);
                    $_SESSION['nationality'] = htmlspecialchars($row["Nazionalità"]);
                    $_SESSION['admin'] = htmlspecialchars($row["Admin"]);
                    header('Location: ../public/index.php');
                    exit;
                }
                header('Location: ../public/invalid_input.php');
                exit;
            }  
            else{
                header('Location: ../public/unexpected_error.php');
                exit;
            }
        }
        catch(mysqli_sql_exception $e){
            error_log($e->getMessage(), 3, DOCUMENT_ROOT."/private/logs/errors.log");
            header("Location: ../public/unexpected_error.php");
            exit;
        }
    }
?>   