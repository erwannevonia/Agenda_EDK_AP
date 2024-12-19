<?php

    session_start();
    require "./connexion.php";

    // Assignement temporaire du compte
    
    global $pdo;

    // Données du devoir à insérer (vu avec chat GPT)
    $compte = 1;
    $description = $_POST['nom']; // Par exemple : "Exercice sur les fractions"
    $date = $_POST['date'];
    $idMatiere = 1; // Remplace par l'ID réel de la matière
    $idClasse = 1;  // Remplace par l'ID réel de la classe
    try {
        // La requête sql d'insertion:
        $sql = "INSERT INTO DEVOIR (Description_Devoir, Date_Devoir, Id_Matiere, Id_Classe)
        VALUES (:description, :date, :idMatiere, :idClasse);";
        
        // Préparation de la requête t'sais avec les bindParam pour définir ce que c'est les trucs de ta requête
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':idMatiere', $idMatiere, PDO::PARAM_INT);
        $stmt->bindParam(':idClasse', $idClasse, PDO::PARAM_INT);
        
        $stmt->execute();
        
        $last_id = $pdo->lastInsertId();
        
        $query = "INSERT INTO COMPTE_DEVOIR (Id_Compte, Id_Devoir)
        VALUES (:Compte, :Devoir);";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":Compte", $_SESSION['ID']);
        $stmt->bindParam(":Devoir", $last_id);
        $stmt->execute();
        
        echo 'Exécution passée';
        header('Location: ../accueil.php');
    }

    catch (PDOException $e) {
        echo ''. $e->getMessage();
    }