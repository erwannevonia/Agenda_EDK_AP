<?php

    // Connexion à la base de données
    require "./connexion.php";

    // Données du devoir à insérer dans la base (identifiants, mdp et mail du formulaire d'inscription)
    $mail = $_POST['adresse-mail']; // Mail saisi lors de l'inscription, Mayoshi@ElPsyCongroo.com
    $nom = $_POST['identifiant']; // Nom saisi lors de l'inscription, Mayuri par exemple
    $mdp = hash('SHA256', $_POST['password']); // Mot de passe saisi lors de l'inscription qui sera hashé, par exemple Mdp_Tuturu-001 = eaa5f20c4576722347fc740f6bed71adefb9b01ca425cbca274e610bfec24b39
    $classeChoix = $_POST['classe-choix'];

    if($classeChoix == -1){
        $classeChoix = NULL;
    }
    
    try{
        // La requête sql pour insérer les valeurs en base:
        $sql = "INSERT INTO COMPTE (Nom_Compte, Mdp_Compte, Mail_Compte, Id_Classe)
                VALUES (:nom, :mdp, :mail, :classe);";

        // Préparation de la la requête pour raison évidente de d'injection
        $stmt = $pdo->prepare($sql);

        // Parametrage des valeurs saisies dans la base 
        $stmt->bindParam(':nom', $nom );
        $stmt->bindParam(':mdp', $mdp);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':classe', $classeChoix);
            
        $stmt->execute();

        $pdo->commit();
        header('Location: ../index.php');
    }
    catch(Exception $e){
        $pdo->rollBack();
        echo "Il y a eu un problème lors de l'inscription", PHP_EOL;
        echo $e;
    }    
?>