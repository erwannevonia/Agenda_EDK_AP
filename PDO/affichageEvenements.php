<?php 
    
    session_start();

    // Connexion à la base de données
    require "./connexion.php";
    
    $dsn='mysql:host=localhost;dbname=EDK';

    header(header: 'Content-Type: application/json');

    // option de connexion encodage UTF8 pour MySQL + annuler l'auto commit
    $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_AUTOCOMMIT=>false];

    $id = $_SESSION['ID'];

    // création d'une instance de connexion à la base de données et ouverture de
    // la connexion
   global $pdo;



    // choix de la méthode d'information en cas d'erreur levée d'exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $pdo->query("SELECT dev.Id_Devoir, dev.Description_Devoir, dev.Date_Devoir 
                          FROM DEVOIR dev
                          JOIN COMPTE_DEVOIR cdev ON dev.Id_Compte = cdev.Id_Compte
                          WHERE cdev.Id_Compte = :id");

    $stmt->bindParam(':id', $id);
    $stmt = $pdo->prepare($query);



    $stmt->execute();

    $events = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($events);

?>