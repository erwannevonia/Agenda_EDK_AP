
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion à Agenda-EDK</title>
        <link href="./bootstrap-5.0.2-dist/css/bootstrap.min.css" media="all" rel="stylesheet">
    </head>

    <body>
        <?php
            session_start();
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
                echo '
                <div class="alert alert-danger" role="alert">
                    La combinaison d\'identifiant et de mot de passe est incorrect.
                </div>';
            }
            if(isset($_SESSION["ID"])) {
                header('Location: accueil.php');
            }
        ?>
        <div class="d-flex justify-content-center align-items-center min-vh-100">
            <!-- Modal statique toujours visible -->
            <div class="modal d-block position-static" tabindex="-1" aria-labelledby="staticModalLabel" aria-hidden="true" style="z-index: 0;">
                <!-- La taille de la modal est large -->
                <div class="modal-dialog modal-dialog-centered modal-m">
                    <div class="modal-content">
                        <!-- Titre de la modal -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticModalLabel">Connexion à EDK</h5>
                        </div>
                        <!-- Formulaire -->
                        <form id="formulaire" action="inc/accesSite.php" method="POST">
                            <!-- Contenu du corps de la modal -->
                            <div class="modal-body">
                                <h6>Identifiant</h6>
                                <!-- Champs du formulaire -->
                                <input type="text" class="form-control mb-3" id="identifiant" name="identifiant" placeholder="Entrez votre identifiant" required>
                                <h6>Mot de passee</h6>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                            </div>
                            <!-- Footer / Boutons de validation du formulaire -->
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#insriptionEdk">S'inscrire</button>
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour qu'un utilisateur puisse s'inscrire à EDK -->
        <div class="modal fade" id="insriptionEdk" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
            <!-- La modal est au milieu, modal-lg pour modal large, taille automatique "large" -->
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Header de la modale -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="customModalLabel">Inscrivez-vous à EDK</h5>
                        <!-- Ce bouton, c'est la croix qui ferme la modal dans le header -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Formulaire -->
                    <form id="formulaire" action="???" method="POST">
                        <!-- Contenu du corps de la modal -->
                        <div class="modal-body">
                            <h6>Identifiant</h6>
                            <!-- Champs du formulaire -->
                            <input type="text" class="form-control mb-3" id="identifiant" name="identifiant" placeholder="Créez votre identifiant" required>
                            <h6>Mot de passee</h6>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Créez votre mot de passe" required>
                        </div>
                        <!-- Footer / Boutons de validation du formulaire -->
                         <div class="modal-footer">
                             <button type="submit" class="btn btn-success">Inscription</button>
                         </div>
                    </form>
                </div>
            </div>
        </div>

    
    
    
    <!-- Lien pour intégrer le JavaScript du site -->
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>

    </body>
    
</html>
