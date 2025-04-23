<?php

    session_start();

    use Base32\Base32;
    require "PDO/connexion.php";
    require './vendor/autoload.php';
    \Sentry\init(['dsn' => 'http://805f5ce7f2d34885b8e5a6998f5f859e@172.16.0.100:8000/9' ]);

    //appel des informations de la base de donnée
    global $pdo;




    // Inclusion des dependances
    require_once './vendor/autoload.php';
    use OTPHP\TOTP;

    /***********************
     * Generation d'un secret
    ***********************/
    $otp = TOTP::create();

    // Utilisation d'un secret deja genere
    $secret = Base32::encode('Compte EDK de '.$_SESSION['Compte']);
    $secretOutput = "The OTP secret is: {$secret}\n";


    /***********************
     * Creation du TOTP avec des informations precises
     ***********************/
    $otp = TOTP::create(
        $secret,            // secret utilise (genere plus haut)
        30,                 // periode de validite
        'sha256',           // Algorithme utilise
        6                   // 6 digits
    );
    $otp->setLabel('EDK'); // The label
    $otp->setIssuer('Compte de ' . $_SESSION['Compte']);
    $otp->setParameter('image', 'https://media.discordapp.net/attachments/1048215683462336543/1327815107497033961/f60252c76ad9f10c8507e04c588f2488.jpg?ex=67e20a2f&is=67e0b8af&hm=21c80a96502d6f583a3d5e82c687ec91ffd5178edbc4653d5226108affec39c9&=&format=webp'); // FreeOTP can display image

    $otpOutput = "The current OTP is: {$otp->now()}\n";


    // V�rifie la valeur OTP
    function checkOTP($otp_form): bool
    {
        global $otp;

        return $otp->verify($otp_form);
    }

    
    if (!empty($_POST['otp'])) {
        if (checkOTP($_POST['otp'])) {
            $test = $_SESSION['Compte'];

            // La requête sql du select:
            $sql = "SELECT Id_Compte
                    FROM COMPTE
                    WHERE Nom_Compte = :nom";

            // Préparation de la la requête pour raison évidente de d'injection
            $stmt = $pdo->prepare($sql);

            // Parametrage des valeurs saisies dans la base 
            $stmt->bindParam(':nom', $test);

            $stmt->execute();


            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['ID'] = $result['Id_Compte'];
                header('Location: ./accueil.php');
                echo 'Vous serez redirigé dans 1 seconde...<br>Si vous n\'êtes redirigé après plusieurs secondes, cliquez <a href="./accueil.php">ici</a>';
                \Sentry\captureMessage("[EDK] ✔ L'utilisateur " . $_SESSION['Compte'] . " a réussi l'A2F");
                exit();
            } 
            else {
                echo "Impossible de se connecter.";
                \Sentry\captureMessage("[EDK] ❌ Quelqu'un a essayé de se connecter au compte " . $_SESSION['Compte'] . " mais n'a pas réussi l'A2F");
                header('Location: ../index.php?error=1');
            }
        }
    }
    else if (empty($_POST['otp'])) {
        echo $_POST['otp'];
        echo 'Veuillez réessayer.';
    }


?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vérification A2F</title>
    </head>
    <body>
        <form id="formulaire" action="./a2f.php" method="POST">
            <?php
                echo $_SESSION['Compte'];
            ?>
            <p>Entrez votre code A2F :</p>
            <input id="otp" name="otp">
            <button type="submit">Validez</button>
        </form>
    </body>
</html>