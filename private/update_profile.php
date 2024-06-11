<?php
    include_once(dirname(__FILE__)."/../phpinfo.php");

    if(!isset($_SESSION))
        session_start();
    if(!isset($_SESSION['login']) || empty($_SESSION['login']))
        header('Location: login.php');
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        include(DOCUMENT_ROOT."/private/connection.php");
        $fields = array('firstname', 'lastname', 'email');
        foreach ($fields as $field) {
			if (!isset( $_POST[$field]) || empty($_POST[$field])) {
                header("Location: ../public/invalid_input.php");
                exit;
            }
		}

        $firstname = filter_var(trim($_POST['firstname']) , FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")));
        $lastname = filter_var(trim($_POST['lastname']) , FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")));
        $newEmail = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);

        if(!$firstname || !$lastname || !$newEmail ){
            header("Location: ../public/invalid_input.php");   
            exit;
        }

        if(isset($_POST['birthdate']) && isset($_POST['gender']) && isset($_POST['nationality']) ){
            $birthdate = filter_var(trim($_POST['birthdate']), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{2}-\d{2}$/")));
            $gender = filter_var(trim($_POST['gender']));
            $nationality = filter_var(trim($_POST['nationality']), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")));
            if(!$birthdate || !$gender  || !$nationality){
                header("Location: ../public/invalid_input.php");  
                exit; 
            }
        }

        $oldEmail = $_SESSION['email'];

        try{
            $sql = "UPDATE utenti SET Nome=?, Cognome=?, Email=?, Data_Nascita=?, Genere=?, Nazionalità=? WHERE Email=?;";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $firstname, $lastname,  $newEmail, $birthdate, $gender, $nationality, $oldEmail);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt) == 1) {
                $_SESSION['firstname'] = htmlspecialchars(trim($_POST['firstname']));
                $_SESSION['lastname'] = htmlspecialchars(trim($_POST['lastname']));;
                $_SESSION['email'] = htmlspecialchars(trim($_POST['email']));
                $_SESSION['birthdate'] = htmlspecialchars(trim($_POST['birthdate']));
                $_SESSION['gender'] = htmlspecialchars(trim($_POST['gender']));
                $_SESSION['nationality'] = htmlspecialchars(trim($_POST['nationality']));

                mysqli_stmt_close($stmt);

                header('Location: show_profile.php');
                exit;
            }
            else {
                header("Location: ../public/invalid_input.php");
                exit;
            }
        }
        catch(mysqli_sql_exception $e){
            error_log($e->getMessage(), 3, DOCUMENT_ROOT."/private/logs/errors.log");
            header('Location: ../public/unexpected_error.php');
            exit();
        }
    }
    else{
        include(DOCUMENT_ROOT."/components/head.php");
        include(DOCUMENT_ROOT."/components/navbar/navbar.php");
?>
        <div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
            <div class="form-container">
                <h1 class="text-center">Modifica Profilo</h1>
                <form action="private/update_profile.php" method="POST" class='row g-3 needs-validation' novalidate>
                    <div class="col-md-5">
                        <label for="validationCustom01" class="form-label">Nome</label>
                        <input type="text" name="firstname" class="form-control" id="validationCustom01" value="<?php echo $_SESSION["firstname"]?>" required pattern="[A-Za-z ]+"  >
                        <div class="valid-feedback">
                            Ottimo!
                        </div>
                        <div class="invalid-feedback">
                            Per favore inserisci un nome valido.
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label for="validationCustom02" class="form-label">Cognome</label>
                        <input type="text" name="lastname" class="form-control" id="validationCustom02" value="<?php echo $_SESSION["lastname"]?>" required pattern="[A-Za-z ]+">
                        <div class="valid-feedback">
                            Ottimo!
                        </div>
                        <div class="invalid-feedback">
                            Per favore inserisci un cognome valido.
                        </div>
                    </div>

                    <div class="col-md-7">
                        <label for="validationCustomEmail" class="form-label">Email</label>
                        <div class="input-group has-validation">
                            <input type="email" name="email" class="form-control" id="validationCustomEmail" value="<?php echo $_SESSION["email"]?>" required>
                            <div class="invalid-feedback">
                                Per favore inserisci una mail valida.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="birthdate">Data di nascita</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php if(isset($_SESSION["birthdate"])) echo $_SESSION["birthdate"]; else echo ""?>" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Genere</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="" label="Seleziona un genere"></option>
                            <option value="maschio">Maschio</option>
                            <option value="femmina">Femmina</option>
                            <option value="altro">Altro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nationality">Nazionalità</label>
                        <input type="text" class="form-control" id="nationality" name="nationality" value="<?php if(isset($_SESSION["nationality"])) echo $_SESSION["nationality"]; else echo "";?>" required>
                    </div>

                    <div class="col-12">
                    <button class="btn btn-primary" name="submit" type="submit">Modifica</button>
                    </div>
                </form>
            </div>
        </div>
<?php
        include(DOCUMENT_ROOT."/components/footer.php");
    }
?>