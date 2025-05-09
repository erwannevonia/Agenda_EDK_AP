<?php

    session_start();

    require "./connexion.php";
    //require './PDO_functions.php';

    //require "../inc/glitchtip.php";

    //appel des informations de la base de donnée
    global $pdo;

    $etatA2F = null;
    
    // Données du devoir à insérer (vu avec chat GPT)
    if(isset($_POST['idA2F-activation'])) {
        $etatA2F = $_POST['idA2F-activation'];
    }
    
    if(isset($_POST['idA2F-desactivation'])) {
        $etatA2F = $_POST['idA2F-desactivation'];
    }

    $compte = $_SESSION['ID'];
    
    // La requête sql du select:
    $sql = "UPDATE COMPTE
            SET A2F = :a2f
            WHERE Id_Compte = :id;";

    // Préparation de la la requête pour raison évidente d'injection
    $stmt = $pdo->prepare($sql);

    // Parametrage des valeurs saisies dans la base 
    $stmt->bindParam(':a2f', $etatA2F);
    $stmt->bindParam(':id', $compte);

    if ($stmt->execute()) {
        $pdo->commit();
        header('Location: ../accueil.php');
    } 
    else {
        $pdo->rollBack();
        echo "Erreur lors de la mise à jour.";
    }
    