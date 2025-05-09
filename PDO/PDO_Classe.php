<?php
    // Connexion à la base de données
    require "./Metier/Classe.php";


    class PDO_Classe {

        public static function getAll():array{
            include "./PDO/connexion.php";
            $resultatFinal = array();
            try {
            $sql= "SELECT * FROM CLASSE";

                // Préparation de la la requête pour raison évidente de d'injection
                $stmt = $pdo->prepare($sql);

                $stmt->execute();

                while($resultatRequete = $stmt->fetch(PDO::FETCH_OBJ))
                {
                    $resultatFinal[] = new Classe(
                        $resultatRequete->Id_Classe,
                        $resultatRequete->Nom_Classe
                    );
                }

                $stmt->closeCursor();
            }
            catch(Exception $e){
                echo "missmatch human is dead", PHP_EOL;
                echo $e;
            }

           return $resultatFinal;

        }
    }


?>
