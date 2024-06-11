<?php
    include_once(dirname(__FILE__)."/../phpinfo.php");

	include(DOCUMENT_ROOT."/private/db_credentials.php");
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$con = mysqli_connect(DB_HOST, DB_USER , DB_PASS, DB_NAME);
	if (mysqli_connect_errno()) {
		error_log("Failed to connect to MySQL: " . mysqli_connect_error(),3, DOCUMENT_ROOT."/private/logs/errors.log");		//OJO: gestione errori
		header("Location: ../public/unexpected_error.php");
		exit();
	}
?>