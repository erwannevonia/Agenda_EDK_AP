<?php
    require 'connexion.php';

function remplirDevoirs() {

    try {
    
        $test = $_SESSION['ID']; // ID de test
        global $pdo;

        $query = "SELECT ma.Nom_Matiere, de.Description_Devoir, de.Date_Devoir
                  FROM DEVOIR de
                  JOIN COMPTE_DEVOIR co_do ON de.Id_Devoir = co_do.Id_Devoir
                  JOIN COMPTE co ON co_do.Id_Compte = co.Id_Compte
                  JOIN MATIERE ma ON de.Id_Matiere = ma.Id_Matiere
                  WHERE co.Id_Compte = :id";

        // Préparer la requête
        $stmt = $pdo->prepare($query);

        // Lier les paramètres
        $stmt->bindParam(":id", $test);

        // Exécuter la requête
        $stmt->execute();

        // Récupérer les résultats
        $arrAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output = '';

        if (!$arrAll) {
            echo "Vous n'avez pas de devoirs à faire.";
        } else {
            foreach ($arrAll as $row) {
                $output .= '<h3>' . htmlspecialchars($row['Nom_Matiere']) . '</h3>';
                $output .= '<p>' . htmlspecialchars($row['Description_Devoir']) . '</p><hr>';
            }
        }

        echo $output;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}