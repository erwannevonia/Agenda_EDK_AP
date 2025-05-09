<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require "./connexion.php";
header('Content-Type: application/json');

// Sécurité : vérifier que l'utilisateur est connecté
if (!isset($_SESSION['ID'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Non connecté']);
    exit;
}

$id = $_SESSION['ID'];

if (!isset($_SESSION['ID'])) {
    echo json_encode(['error' => 'Non connecté']);
    exit;
}

if (!isset($_GET['start']) || !isset($_GET['end'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Paramètres start et end manquants']);
    exit;
}

$start = (new DateTime($_GET['start']))->format('Y-m-d');
$end = (new DateTime($_GET['end']))->format('Y-m-d');


/*$start = new DateTime('2005-12-31')->format('Y-m-d');
//echo $start->format('Y-m-d');

$end = new DateTime('2029-12-31')->format('Y-m-d');
//echo $date->format('d/m/Y'); // Affiche 31/12/2029*/

// Vérifie que les dates sont bien reçues
if (!$start || !$end) {
    http_response_code(400);
    echo json_encode(['error' => 'Dates manquantes']);
    exit;
}

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT dev.Id_Devoir AS id,
                   dev.Description_Devoir AS title,
                   dev.Date_Devoir AS start
            FROM DEVOIR dev
            JOIN COMPTE_DEVOIR cdev ON dev.Id_Devoir = cdev.Id_Devoir
            WHERE cdev.Id_Compte = :id
              AND dev.Date_Devoir BETWEEN :start AND :end";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);

    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($events);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur base de données', 'details' => $e->getMessage()]);
}
?>