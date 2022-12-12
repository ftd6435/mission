<?php

abstract class Model{
    private static $bdd = NULL;

    /**
     * Fonction accessible uniquement par les classes qui herite sa classe
     * Elle retourne la connexion a la BDD en cas de succès
     * et NULL dans le cas contraire
     *
     */
    protected function getBdd(){
        if(self::$bdd === NULL){
            self::$bdd = new PDO('mysql:host=localhost;dbname=mission;charset=utf8', 'root', '',
                                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                        );
        }
        return self::$bdd;
    }

    /**
     * Fonction de traitement d'image 
     * Accessible uniquement par les classes qui herite sa classe
     * Elle retourne le nom personaliser de l'image en cas de succès
     * ou "error" dans le cas contraire
     *
     */
    protected function validationProfil($profil){
        $_SESSION['image'] = "";

        $rand = rand(0,999);

        $file_name = $rand."-".$profil['name'];

        $tab_ext = ['jpg','jpeg','png'];
        $extension = strtolower(pathinfo($profil['name'], PATHINFO_EXTENSION));

        if($profil['error'] != 0){
            $_SESSION['image'] = "Erreur d'envoie de l'image !";
        }elseif($profil['size'] > 500000){
            $_SESSION['image'] = "La taille de l'image est grande !";
        }elseif(!in_array($extension, $tab_ext)){
            $_SESSION['image'] = "Seul les extensions jpg, jpeg et png sont autorisés !";
        }elseif(!getimagesize($profil['tmp_name'])){
            $_SESSION['image'] = "Le fichier envoyer n'est pas une image !";
        }else{
            return $file_name;
        }

        return "error";
    }
}

?>