<?php
try{
    session_start();

    require "./connexion.php";
    require "../inc/glitchtip.php";
    require './PDO_functions.php';

    //appel des informations de la base de donnée
    global $pdo;

    // Données du devoir à insérer (vu avec chat GPT)
    $nom = $_POST['identifiant']; // Par exemple : "Alexis"
    $mdp = hash('SHA256', $_POST['password']); // Par exemple : "Bergeraque"


    // La requête sql du select:
    $sql = "SELECT Id_Compte, Nom_Compte
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
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['Compte'] = $result['Nom_Compte'];
        $stmt->closeCursor(); // Fermeture du curseur
        echo "Résultats trouvés : <br>";
        \Sentry\captureMessage("[EDK] 🤠 L'utilisateur " . $result['Nom_Compte'] . " s'est connecté");
        $verifA2F = verifierA2f();
        $_SESSION['Prof'] = verifierProf();
        // $prof = verifierProf();
        // if ($prof == 1) {
        //     $_SESSION['Prof'] = 1;
        // }
        // else {
        //     $_SESSION['Prof'] = 0;
        // }
        if($verifA2F==1){
            header('Location: ../a2f.php');
            echo 'Vous serez redirigé dans 1 seconde...<br>Si vous n\'êtes redirigé après plusieurs secondes, cliquez <a href="../accueil.php">ici</a>';
            exit();
        }
        else{
            $_SESSION['ID'] = $result['Id_Compte'];
            echo $verifA2F;
            header('Location: ../accueil.php');
            echo 'Vous serez redirigé dans 1 seconde...<br>Si vous n\'êtes redirigé après plusieurs secondes, cliquez <a href="../accueil.php">ici</a>';
            exit();
        }
        
    } 
    
    else {
	    echo "Impossible de se connecter.";
        \Sentry\captureMessage("[EDK] 🤡 Quelqu'un a essayé de se connecter, mais n'a pas réussi.");
        header('Location: ../index.php?error=1');
    }
}
catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}