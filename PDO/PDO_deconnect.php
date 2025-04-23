<?php
    
    session_start();

    unset($_SESSION["ID"]);
    unset($_SESSION['Compte']);

    header('Location: ../index.php');