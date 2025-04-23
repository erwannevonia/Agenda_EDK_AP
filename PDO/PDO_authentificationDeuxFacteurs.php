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

    // Préparation de la la requête pour raison évidente de d'injection
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



    
/*
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['ID'] = $result['Id_Compte'];
        $_SESSION['Compte'] = $result['Nom_Compte'];
        $stmt->closeCursor(); // Fermeture du curseur
        echo "Résultats trouvés : <br>";
        header('Location: ../accueil.php');
        echo 'Vous serez redirigé dans 1 seconde...<br>Si vous n\'êtes redirigé après plusieurs secondes, cliquez <a href="../accueil.php">ici</a>';
        \Sentry\captureMessage("[EDK] 🤠 L'utilisateur " . $result['Nom_Compte'] . " s'est connecté");
        exit();
    } 
    
    else {
	    echo "Impossible de se connecter.";
        \Sentry\captureMessage("[EDK] 🤡 Quelqu'un a essayé de se connecter, mais n'a pas réussi.");
        header('Location: ../index.php?error=1');
    }
*/