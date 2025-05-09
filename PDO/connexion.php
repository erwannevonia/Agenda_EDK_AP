<?php

    try {
        // Pour GlitchTip
        // require '../vendor/autoload.php';
        // \Sentry\init(['dsn' => 'http://805f5ce7f2d34885b8e5a6998f5f859e@172.16.0.100:8000/9' ]);

        // Pour la base de données
        // chaine de connexion à la base de données
        $dsn='mysql:host=localhost;dbname=EDK';

        // option de connexion encodage UTF8 pour MySQL + annuler l'auto commit
        $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_AUTOCOMMIT=>false];
        // création d'une instance de connexion à la base de données et ouverture de
        // la connexion
        $pdo = new PDO($dsn, 'edk-selector', 't', $options);

        // choix de la méthode d'information en cas d'erreur levée d'exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo 'connexion effectuée avec le driver ' . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) . '<br>';
    }
    catch (PDOException $e) {
        $msg = 'ERREUR PDO dans ' . $e->getFile() . ' : ' . $e->getLine() . ' : ' . $e->getMessage();
        die($msg);
    }
    
?>