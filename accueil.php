<?php
    require './PDO/PDO_functions.php';
    include "./PDO/PDO_Classe.php";
    $listeAllClasses = PDO_Classe::getAll();
    use Base32\Base32;
    session_start();
    if (isset($_SESSION["ID"])) {
    }
    else {
        header('Location: index.php');
        exit();
    }
    // Inclusion des dependances
    require_once dirname(__FILE__).'/vendor/autoload.php';
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

    /***********************
     * Affichage du temps pour information
     ***********************/
    // D�finition de la zone de temps
    date_default_timezone_set('Europe/Paris');
    $maintenant = time() ;

    // Affichage de maintenant
    $dateOutput = date('Y-m-d H:i:s',$maintenant);

    /***********************
     * G�n�ration du QrCode
     ***********************/
    // Note: You must set label before generating the QR code
    $grCodeUri = $otp->getQrCodeUri(
        'https://api.qrserver.com/v1/create-qr-code/?data=[DATA]&size=300x300&ecc=M',
        '[DATA]'
    );
    $qrCodeOutput = "<img src='{$grCodeUri}' style='height=250px; width:250px' alt='Image d'un QR Code'>";
    
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda-EDK</title>

    <link href="./bootstrap-5.0.2-dist/css/bootstrap.min.css" media="all" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet" />
    <script src="./fullcalendar-6.1.15/dist/index.global.js"></script>
</head>

<body>
    <!-- Header -->
    <header class="custom-header py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h5 mb-0">
                Prototype Agenda
            </h1>
            <nav>
                <p>
                    <?php
                        echo "Bienvenue ";
                        echo $_SESSION['Compte'];
                        echo " ! ";
                        echo $_SESSION['ID'];
                    ?>
                </p>
                <a href="#services" class="text-white">Services</a>
                <a href="#contact" class="text-white">Contact</a>
                <a href="#OTP" class="text-white" data-bs-toggle="modal" data-bs-target="#modalOTP">OTP</a>
                <a href="PDO/PDO_deconnect.php" class="text-white">Se déconnecter</a>
            </nav>
        </div>
    </header>
    
    <main>

        <table class="center">
            <tr>
                <td scope="col">
                    <div id='calendar'></div>
                </td>
                <td scope="col" style="width: 75vh; max-width: 75vh;">
                    <div id="affichage-devoirs" class="border border-5 rounded border-primary">
                        <?php
                            remplirDevoirs();
                        ?> 
                    </div>
                    <!-- Bouton pour ouvrir la modal -->
                    <!-- Si tu clique sur ce bouton, t'affiche la modal, 
                    "data-bs-target" c'est comme l'id que l'on prendrait dans un getElementById pour le js,
                    mais celui-ci figure dans la modal directement avec "id='modalDevoir'" -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDevoir" style="float: right;">
                        Créer un Devoir
                    </button>
                </td>
            </tr>
        </table>
        



        <!-- Modal OTP affiche un QR code -->
        <div class="modal fade" id="modalOTP" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
            <!-- La modal est au milieu, modal-lg pour modal large, taille automatique "large" -->
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <!-- Header de la modale -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="customModalLabel">Authentification OTP</h5>
                        <!-- Ce bouton, c'est la croix qui ferme la modal dans le header -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Body de la Modal -->
                     <?php
                        $verifA2F = verifierA2f();

                        // Si l'authentification OTP n'est pas active
                        if($verifA2F==0){ ?>
                            <!--// Body de la modal avec le QR Code Visible-->
                            <div class="modal-body" style="margin: auto;">
                                <?php
                                    echo $qrCodeOutput;
                                ?>
                            </div>
                            <!--// Footer de la modal, formulaire qui va vers PDO_authentificationDeuxFacteurs.php pour activer l'A2F si on clique sur le Bouton-->
                            <div class="modal-footer">
                                <form id="formulaire-a2f-activation" action="PDO/PDO_authentificationDeuxFacteurs.php" method="POST">
                                    <input type="hidden" id="idA2F-activation" name="idA2F-activation" value="1">
                                    <button type="submit" class="btn btn-success">J'ai validé l'A2F !</button>
                                </form>
                            </div><?php
                        }
                        // Si l'authentification OTP est active
                        if($verifA2F==1){
                            // Body de la modale sans le QR Code Visible
                            echo "<div class=\"modal-body\" style=\"margin: auto;\">";
                                echo "<img src=\"./img/qrcode.png\" style=\"height=250px; width:250px\" alt=\"Image d'un QR Code\">";
                                echo "L'authentification à 2 Facteurs est Activée !";
                            echo "</div>";
                            // Footer de la modal, formulaire qui va vers PDO_authentificationDeuxFacteurs.php pour desactiver l'A2F si on clique sur le Bouton
                            echo "<div class='modal-footer'>";
                                echo "<form id=\"formulaire-a2f-desactivation\" action=\"PDO/PDO_authentificationDeuxFacteurs.php\" method=\"POST\">";
                                    echo "<input type=\"hidden\" id=\"idA2F-desactivation\" name=\"idA2F-desactivation\" value=\"0\">";
                                    echo "<button type=\"submit\" class=\"btn btn-danger\">Je ne veux plus de l'A2F</button>";
                                echo "</form>";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>

        <!-- Modal d'ajout des devoirs (quand le bouton dans le tableau est pressé, c'est ce code qui apparait) -->
        <div class="modal fade" id="modalDevoir" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
            <!-- La modal est au milieu, modal-lg pour modal large, taille automatique "large" -->
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <!-- Header de la modale -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="customModalLabel">Devoirs Personels</h5>
                        <!-- Ce bouton, c'est la croix qui ferme la modal dans le header -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?php
                    if ($_SESSION['Prof'] == 0) { ?>
                        <form id="formulaire" action="PDO/PDO_add.php" method="POST">
                            <!-- Body de la Modal -->
                            <div class="modal-body">
                                <p>Description du devoir :</p>
                                <textarea id="nom" name="nom" rows="5" cols="100" required></textarea>
                                <br><br><br>
                                <p>Date à rendre</p>
                                <input type="date" id="date" name="date" required>
                            </div>
                            <!-- Footer, la partie du bas de la modal -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    <?php
                    }
                    else { ?>
                        <form id="formulaire" action="PDO/PDO_addProf.php" method="POST">
                            <!-- Body de la Modal -->
                            <div class="modal-body">
                                <p>Classe :</p>
                                <select name="classe-choix" class="form-select" aria-label="Default select example">
                                <option value="-1">Choisissez la Classe</option>
                                <?php
                                foreach ($listeAllClasses as $classe){

                                    echo '<option value="'.$classe->getIdClasse().'">'.$classe->getNomClasse().'</option>';

                                }
                                ?>
                                </select>
                                <br><br><br>
                                <p>Description du devoir :</p>
                                <textarea id="nom" name="nom" rows="5" cols="100" required></textarea>
                                <br><br><br>
                                <p>Date à rendre</p>
                                <input type="date" id="date" name="date" required>
                            </div>
                            <!-- Footer, la partie du bas de la modal -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    <?php
                    } ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="custom-footer py-3">
        <div class="container text-center">
            <p>&copy; 2024 Mon Site. Tous droits réservés.</p>
            <p><a href="#privacy">Politique de confidentialité</a></p>
        </div>
    </footer>

    <!-- Lien pour intégrer le JavaScript du site -->
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="./js/accueil.js"></script> <!-- Calendrier sur la gauche -->
</body>

</html>