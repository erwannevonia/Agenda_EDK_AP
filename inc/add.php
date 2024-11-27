<?php

    require "./connexion.php";

    // Assignement temporaire du compte
    
    global $pdo;
    
    // Données du devoir à insérer (vu avec chat GPT)
    $compte = 1;
    $description = $_POST['nom']; // Par exemple : "Exercice sur les fractions"
    $date = $_POST['date'];
    $idMatiere = 1; // Remplace par l'ID réel de la matière
    $idClasse = 1;  // Remplace par l'ID réel de la classe

    // La requête sql d'insertion:
    $sql = "INSERT INTO DEVOIR (Description_Devoir, Date_Devoir, Id_Matiere, Id_Classe)
            VALUES (:description, :date, :idMatiere, :idClasse);
            INSERT INTO POSSEDER (id_Compte, id_Matiere)
            VALUES ($compte, :idMatiere);";

    // Préparation de la requête t'sais avec les bindParam pour définir ce que c'est les trucs de ta requête
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date', $idClasse);
    $stmt->bindParam(':idMatiere', $idMatiere, PDO::PARAM_INT);
    $stmt->bindParam(':idClasse', $idClasse, PDO::PARAM_INT);

    $stmt->execute();

        