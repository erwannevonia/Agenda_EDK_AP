<?php

    require "./connexion.php";
    require "../inc/glitchtip.php";

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
<<<<<<< Updated upstream:inc/accesSite.php
        echo "Résultats trouvés : <br>";
        header('Refresh: 3; URL=../accueil.php');
        echo 'Vous serez redirigé dans 3 secondes...';
=======
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['ID'] = $result['Id_Compte'];
        $_SESSION['Compte'] = $result['Nom_Compte'];
        $stmt->closeCursor(); // Fermeture du curseur
        echo "Résultats trouvés : <br>";
        header('Location: ../accueil.php');
        echo 'Vous serez redirigé dans 1 seconde...<br>Si vous n\'êtes redirigé après plusieurs secondes, cliquez <a href="../accueil.php">ici</a>';
        \Sentry\captureMessage("[EDK] 🤠 L'utilisateur " . $result['Nom_Compte'] . " s'est connecté");
>>>>>>> Stashed changes:PDO/PDO_accesSitee.php
        exit();
    } 
    
    else {
<<<<<<< Updated upstream:inc/accesSite.php
        echo "Aucun résultat trouvé.";
=======
	    echo "Impossible de se connecter.";
        \Sentry\captureMessage("[EDK] 🤡 Quelqu'un a essayé de se connecter, mais n'a pas réussi.");
        header('Location: ../index.php?error=1');
>>>>>>> Stashed changes:PDO/PDO_accesSitee.php
    }
