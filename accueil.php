<?php
    require 'inc/functions.php';
    session_start();
    if (isset($_SESSION["ID"])) {
    }
    else {
        header('Location: index.php');
        exit();
    }
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
                        echo " !";
                    ?>
                </p>
                <a href="#services" class="text-white">Services</a>
                <a href="#contact" class="text-white">Contact</a>
                <a href="inc/deconnect.php" class="text-white">Se déconnecter</a>
            </nav>
        </div>
    </header>

    <table class="center">
        <tr>
            <th scope="col">
                <div id='calendar'></div>
            </th>
            <th scope="col" style="max-width: 75vh">
                <div class="border border-5 rounded border-primary">
                    <?php
                        remplirDevoirs();
                    ?> 
                </div>
            </th>
            <th scope="col">
                <!-- Bouton pour ouvrir la modal -->
                <td>
                    <!-- Si tu clique sur ce bouton, t'affiche la modal, 
                    "data-bs-target" c'est comme l'id que l'on prendrait dans un getElementById pour le js,
                    mais celui-ci figure dans la modal directement avec "id='modalDevoir'" -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDevoir">
                        Créer un Devoir
                    </button>
                </td>
            </th>
    </table>

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
                <form id="formulaire" action="inc/add.php" method="POST">
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
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="custom-footer py-3">
        <div class="container text-center">
            <p>&copy; 2024 Mon Site. Tous droits réservés.</p>
            <p><a href="#privacy">Politique de confidentialité</a></p>
        </div>
    </footer>

    <!-- Lien pour intégrer le JavaScript du site -->
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>
