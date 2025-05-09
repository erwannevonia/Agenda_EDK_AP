<?php 
    class Classe
    {
        // Définition des attributs
        private int $idClasse;
        private string $nomClasse;

        // Création des constructeurs
        public function __construct(int $id, string $nom){

            $this->idClasse = $id;
            $this->nomClasse = $nom;

        }

        // Création du getter pour l'id de la classe (école) elle ne retourne pas du null et force le type int
        public function getIdClasse():int{

            return $this->idClasse;

        }

        public function setIdClasse(int $nouvelIdentifiant):void{

            $this->idClasse = $nouvelIdentifiant;

        }

        public function getNomClasse():string{

            return $this->nomClasse;

        }
     
        public function setNomClasse(string $nouveauNom):void{

            $this->nomClasse = $nouveauNom;

        }
    }
    
?>