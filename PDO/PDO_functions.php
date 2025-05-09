<?php
    session_start();
    require 'connexion.php';

function remplirDevoirs() {

    try {
    
        $compte = $_SESSION['ID']; // ID de test
        global $pdo;

        $query = "SELECT DISTINCT de.Id_Devoir, ma.Nom_Matiere, de.Description_Devoir, de.Date_Devoir
                  FROM DEVOIR de
                  JOIN MATIERE ma ON de.Id_Matiere = ma.Id_Matiere
                  WHERE de.Id_Devoir IN (
                      -- Devoirs assignés directement à l'utilisateur
                      SELECT Id_Devoir
                      FROM COMPTE_DEVOIR
                      WHERE Id_Compte = :id
                  )
                  OR de.Id_Classe = (
                      -- Devoirs assignés à la classe de l'utilisateur
                      SELECT Id_Classe
                      FROM COMPTE
                      WHERE Id_Compte = :id
                  )
                  ORDER BY de.Date_Devoir ASC";

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
            if ($_SESSION['Prof'] == 0) {
                echo "Vous n'avez pas de devoirs à faire.";
            }
            else {
                echo "Vous n'avez pas prévu de devoirs pour vos élèves.";
            }
        } else {
            if ($_SESSION['Prof'] == 0) {
                foreach ($arrAll as $row) {
                    $output .= '<form id="formulaire" action="PDO/PDO_read.php" method="POST">';
                    $output .= '<div id="' . htmlspecialchars($row['Id_Devoir']) . '" name="' . htmlspecialchars($row['Id_Devoir']) . '">';
                    $output .= '<h3>' . htmlspecialchars($row['Nom_Matiere']) . '</h3>';
                    $output .= '<p>' . htmlspecialchars($row['Description_Devoir']) . '</p>';
                    $output .= '<button type="submit" class="btn btn-primary">Marquer comme lu</button>';
                    $output .= '</div></form><hr>';
                }
            }
            else {
                foreach ($arrAll as $row) {
                    $output .= '<form id="formulaire" action="PDO/PDO_delete.php" method="POST">';
                    $output .= '<div id="' . htmlspecialchars($row['Id_Devoir']) . '" name="' . htmlspecialchars($row['Id_Devoir']) . '">';
                    $output .= '<h3>' . htmlspecialchars($row['Nom_Matiere']) . '</h3>';
                    $output .= '<p>' . htmlspecialchars($row['Description_Devoir']) . '</p>';
                    $output .= '<button type="submit" class="btn btn-danger">Supprimer le devoir</button>';
                    $output .= '</div></form><hr>';
                }
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

function verifierProf(){
    try {
        $compte = $_SESSION['Compte'];
        global $pdo;

        $query = "SELECT Id_Professeur
                FROM COMPTE
                JOIN PROFESSEUR ON COMPTE.Id_Compte = PROFESSEUR.Id_Compte
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
        if ($result['Id_Professeur'] != null) {
            return 1;
        }
        else {
            return 0;
        }
    }
    catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}