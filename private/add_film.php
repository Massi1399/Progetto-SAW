<?php
    include_once(dirname(__FILE__)."/../phpinfo.php");

    if(!isset($_SESSION))
        session_start();
    if(!isset($_SESSION['admin']) || !$_SESSION['admin'])
        header('Location: private/login.php');

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        include(DOCUMENT_ROOT."/private/connection.php");
        $fields = array('nome', 'genere', 'regista', 'paese', 'anno', 'trama', 'casa_produzione', 'durata');
        foreach ($fields as $field) {
            if (!isset( $_POST[$field]) || empty($_POST[$field])) {
                header("Location: ../public/invalid_input.php");
                exit();
            }
        }
        if(!isset($_FILES['img']) || $_FILES['img']['error'] > 0){
            header("Location: ../public/invalid_input.php");   
            exit();
        }

        $nome = filter_var($_POST['nome'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/")));
        $genere = filter_var($_POST['genere'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")));
        $regista = filter_var($_POST['regista'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")));
        $paese =  filter_var($_POST['paese'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")));   
        $anno = filter_var($_POST['anno'], FILTER_VALIDATE_INT, array("options"=>array("min_range"=>1900, "max_range"=>2024)));
        $trama = filter_var($_POST['trama'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/")));
        $img_name = current(explode('.',$_FILES['img']['name']));
        $casa_produzione = filter_var($_POST['casa_produzione'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/")));
        $durata = filter_var($_POST['durata'], FILTER_VALIDATE_INT, array("options"=>array("min_range"=>0)));

        if(!$nome || !$genere || !$regista || !$paese || !$anno || !$trama  || !$casa_produzione || !$durata){
            header("Location: ../public/invalid_input.php");   
        }   

        try{
            $file_name = $_FILES['img']['name'];
            $file_size =$_FILES['img']['size'];
            $file_tmp =$_FILES['img']['tmp_name'];
            $file_type=$_FILES['img']['type'];
            //ottieni l'estensione in lowercase
            $file_ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));  
            $extensions= array("jpeg","jpg","png");

            if(in_array($file_ext,$extensions) === false || $file_size > 2097152){
                header("Location: ../public/invalid_input.php");
                exit;
            }

            if(!move_uploaded_file($file_tmp, DOCUMENT_ROOT."/assets/img/film/".$file_name)){
                header("Location: ../public/unexpected_error.php");
                exit;
            }

            $sql = "INSERT INTO film (Nome, Genere, Regista, Paese, Anno, Trama, Img, Casa_Produzione, Durata) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssssisssi", $nome, $genere, $regista, $paese, $anno, $trama, $img_name, $casa_produzione, $durata);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("Location: add_film.php");
            exit;
        }
        catch (mysqli_sql_exception $e) {
            error_log($e->getMessage(), 3, DOCUMENT_ROOT."/private/logs/errors.log");
            header("Location: ../public/unexpected_error.php");
            exit;
        }
    }
    else{
        include(DOCUMENT_ROOT."/components/head.php");
        include(DOCUMENT_ROOT."/components/navbar/navbar.php");
?>
        <div class="table-container d-flex justify-content-center">
            <form action="private/add_film.php" method="post" enctype="multipart/form-data" class="w-50">
                <div class="form-group">
                    <label for="nome"><i class="fas fa-film"></i> Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome">
                </div>

                <div class="form-group">
                    <label for="genere"><i class="fas fa-tags"></i> Genere:</label>
                    <input type="text" class="form-control" id="genere" name="genere">
                </div>

                <div class="form-group">
                    <label for="regista"><i class="fas fa-user"></i> Regista:</label>
                    <input type="text" class="form-control" id="regista" name="regista">
                </div>

                <div class="form-group">
                    <label for="paese"><i class="fas fa-globe"></i> Paese:</label>
                    <input type="text" class="form-control" id="paese" name="paese">
                </div>

                <div class="form-group">
                    <label for="anno"><i class="fas fa-globe"></i> Anno:</label>
                    <input type="text" class="form-control" id="anno" name="anno">
                </div>

                <div class="form-group">
                    <label for="trama"><i class="fas fa-book"></i> Trama:</label>
                    <textarea class="form-control" id="trama" name="trama"></textarea>
                </div>

                <div class="form-group">
                    <label for="img"><i class="fas fa-image"></i> Img:</label>
                    <input type="file" class="form-control-file" id="img" name="img">
                </div>

                <div class="form-group">
                    <label for="casa_produzione"><i class="fas fa-industry"></i> Casa Produzione:</label>
                    <input type="text" class="form-control" id="casa_produzione" name="casa_produzione">
                </div>

                <div class="form-group">
                    <label for="durata"><i class="fas fa-clock"></i> Durata:</label>
                    <input type="text" class="form-control" id="durata" name="durata">
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
<?php
        include(DOCUMENT_ROOT."/components/footer.php");
    }
?>