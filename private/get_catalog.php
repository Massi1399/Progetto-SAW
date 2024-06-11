<?php
include_once(dirname(__FILE__)."/../phpinfo.php");

//se viene chiamato get_catalog dalla searchbar
if((isset($_GET["searchBar"]) && isset($_GET["filter"])) && (!empty($_GET["searchBar"]) && !empty($_GET["filter"]))){
    include(DOCUMENT_ROOT."/private/connection.php");
    try{
        $allowed_cols = ['Nome', 'Genere', 'Regista', 'Paese', 'Anno', 'Casa_Produzione'];
        $filter = $_GET["filter"];
        if (!in_array($filter, $allowed_cols)) {
            header("Location: ../public/invalid_input.php");
            exit;
        }

        if($filter == "Anno") {
            $_GET["searchBar"] = intval($_GET["searchBar"]);
            $stmt = mysqli_prepare($con, "SELECT * FROM film WHERE $filter = ?;");
            mysqli_stmt_bind_param($stmt, "i", $_GET["searchBar"]);
        } else {
            $stmt = mysqli_prepare($con, "SELECT * FROM film WHERE $filter LIKE ?;");
            $mySearch = "%".trim($_GET["searchBar"])."%";
            mysqli_stmt_bind_param($stmt, "s", $mySearch);
        }

        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $count = mysqli_num_rows($res);

        if($count > 0){
            while(($row = mysqli_fetch_assoc($res)) != NULL){
                $data[] = [
                    "id" => intval($row["ID"]),
                    "nome"=> htmlspecialchars($row["Nome"]),
                    "genere"=>htmlspecialchars($row["Genere"]),
                    "regista"=>htmlspecialchars($row["Regista"]),
                    "paese"=>htmlspecialchars($row["Paese"]),
                    "anno"=> intval($row["Anno"]),
                    "img"=> $row["Img"],
                    "durata"=>htmlspecialchars($row["Durata"]),
                    "casa_produzione"=>htmlspecialchars($row["Casa_Produzione"])
                ];
            }
            mysqli_stmt_close($stmt);
            echo(json_encode($data));
        }
        else{
            mysqli_stmt_close($stmt);
            echo(json_encode(array()));
        }
    }
    catch(mysqli_sql_exception $e){
        error_log($e->getMessage(), 3, DOCUMENT_ROOT."/private/logs/errors.log");
        header("Location: ../public/unexpected_error.php");
        exit;
    }
}
else{
    try{
        include(DOCUMENT_ROOT."/private/connection.php");
        $query = "SELECT * FROM film;";
        $res = mysqli_query($con, $query);
        $count = mysqli_num_rows($res);
        if($count > 0){
            while(($row = mysqli_fetch_assoc($res)) != NULL){
                $data[] = [
                    "id" => intval($row["ID"]),
                    "nome"=>htmlspecialchars($row["Nome"]),
                    "genere"=>htmlspecialchars($row["Genere"]),
                    "regista"=>htmlspecialchars($row["Regista"]),
                    "paese"=>htmlspecialchars($row["Paese"]),
                    "anno"=> intval($row["Anno"]),
                    "img"=>$row["Img"],
                    "durata"=> intval($row["Durata"]),
                    "casa_produzione"=> htmlspecialchars($row["Casa_Produzione"]),
                ];
            }
            mysqli_free_result($res);
            mysqli_close($con);
            echo json_encode($data);
        }
        else
            echo json_encode(array("Errore" => "Impossibile caricare il catalogo"));

    }
    catch(mysqli_sql_exception $e){
        error_log($e->getMessage(), 3, DOCUMENT_ROOT."/private/logs/errors.log");
        header("Location: public/unexpected_error.php");
        exit;
    }
}
?>