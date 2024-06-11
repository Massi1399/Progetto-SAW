<?php

    if(!isset($_SESSION)) { 
        session_start(); 
    }
    $_SESSION = [];
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-86400, '/');
    }
    session_destroy();
    header('Location: ../private/login.php');
    exit;
?>