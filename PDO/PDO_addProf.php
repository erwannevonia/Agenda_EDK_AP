<?php

session_start();
require "./connexion.php";
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

global $pdo;

try {
    // Vérification que les données POST existent
    if (!isset($_POST['nom']) || !isset($_POST['date']) || !isset($_POST['classe-choix'])) {
        die("Erreur : Données manquantes !");
    }

    $compte = $_SESSION['ID'];
    $description = $_POST['nom'];
    $date = $_POST['date'];
    $classe = $_POST['classe-choix'];

    // Première requête : Insérer le devoir
    $sql = "INSERT INTO DEVOIR (Description_Devoir, Date_Devoir, Id_Matiere, Id_Classe)
            VALUES (
                :description,
                :date,
                (
                    SELECT Id_Matiere
                    FROM COMPTE_MATIERE
                    WHERE Id_Compte = :id_prof
                    LIMIT 1
                ),
                :classe
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':id_prof', $compte);
    $stmt->bindParam(':classe', $classe);

    if (!$stmt->execute()) {
        echo "Erreur lors de l'insertion du devoir : " . print_r($stmt->errorInfo(), true);
        $last_id= -1;
    }
    else{    
        $last_id = $pdo->lastInsertId(); // Récupérer l'ID du dernier devoir inséré
    }

    // Si $last_id est négatif (possible uniquement dans la condition précédente)
    if ($last_id == -1) {
        echo "Erreur : Aucun ID de devoir récupéré après l'insertion !";
        $pdo->rollback();
    }
    else{
        $pdo->commit();
        
        // Deuxième requête : Associer le devoir à l'utilisateur
        $query = "INSERT INTO COMPTE_DEVOIR (Id_Compte, Id_Devoir)
                VALUES (:Compte, :Devoir)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":Compte", $compte);
        $stmt->bindParam(":Devoir", $last_id);

        if($stmt->execute()){
            $pdo->commit();
            echo "Requête exécutée avec succès !";
        }
        else{
            echo "Erreur lors de l'association du devoir au compte.";
            $pdo->rollback();
        }

    }

} catch (PDOException $e) {
    echo "Erreur PDO : " . $e->getMessage();
    $pdo->rollback();

}
header('Location: ../accueil.php'); 
?>
