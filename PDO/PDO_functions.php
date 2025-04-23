<?php
    session_start();
    require 'connexion.php';

function remplirDevoirs() {

    try {
    
        $compte = $_SESSION['ID']; // ID de test
        global $pdo;

        $query = "SELECT de.Id_Devoir, ma.Nom_Matiere, de.Description_Devoir, de.Date_Devoir
                  FROM DEVOIR de
                  JOIN COMPTE_DEVOIR co_do ON de.Id_Devoir = co_do.Id_Devoir
                  JOIN COMPTE co ON co_do.Id_Compte = co.Id_Compte
                  JOIN MATIERE ma ON de.Id_Matiere = ma.Id_Matiere
                  WHERE co.Id_Compte = :id";

        // Préparer la requête
        $stmt = $pdo->prepare($query);

        // Lier les paramètres
        $stmt->bindParam(":id", $compte);

        // Exécuter la requête
        $stmt->execute();

        // Récupérer les résultats
        $arrAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output = '';

        if (!$arrAll) {
            echo "Vous n'avez pas de devoirs à faire.";
        } else {
            foreach ($arrAll as $row) {
                $output .= '<form id="formulaire" action="PDO/PDO_read.php" method="POST">';
                $output .= '<div id="' . htmlspecialchars($row['Id_Devoir']) . '" name="' . htmlspecialchars($row['Id_Devoir']) . '">';
                $output .= '<h3>' . htmlspecialchars($row['Nom_Matiere']) . '</h3>';
                $output .= '<p>' . htmlspecialchars($row['Description_Devoir']) . '</p>';
                $output .= '<button type="submit" class="btn btn-primary">Marquer comme lu</button>';
                $output .= '</div></form><hr>';
            }
        }

        echo $output;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
    
}

function verifierA2f(){

    try {
        $compte = $_SESSION['Compte']; // ID de test
        global $pdo;

        $query = "SELECT A2F
                  FROM COMPTE
                  WHERE Nom_Compte = :compte";

         // Préparer la requête
         $stmt = $pdo->prepare($query);

         // Lier les paramètres
         $stmt->bindParam(":compte", $compte);
 
         // Exécuter la requête
         $stmt->execute();
 
         // Récupérer les résultats
        //$stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['A2F'];
    }
    catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}