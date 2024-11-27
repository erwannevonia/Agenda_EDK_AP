<?php

    require "./connexion.php";

    //appel des informations de la base de donnée
    global $pdo;

    // Données du devoir à insérer (vu avec chat GPT)
    $nom = $_POST['identifiant']; // Par exemple : "Alexis"
    $mdp = $_POST['password']; // Par exemle : "Bergeraque"

    // La requête sql du select:
    $sql = "SELECT Nom_Compte, Mdp_Compte
            FROM COMPTE
            WHERE Nom_Compte = :nom
            AND Mdp_Compte = :mdp";

    // Préparation de la la requête pour raison évidente de d'injection
    $stmt = $pdo->prepare($sql);

    // Parametrage des valeurs saisies dans la base 
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':mdp', $mdp);
        

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Résultats trouvés : <br>";
        header('Refresh: 3; URL=../accueil.html');
        echo 'Vous serez redirigé dans 3 secondes...';
        exit();
    } 
    
    else {
        echo "Aucun résultat trouvé.";
        header('Location: ../index.php');
    }
