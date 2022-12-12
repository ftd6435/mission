<?php
session_start();
    /**
     * @var URL
     * est une constante permettant de recupérer l'url racine de toute les pages
     */
    define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http" ).
        "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"
    ));

    define("PAR_PAGE", 2).

    require_once "controllers/MissionaryController.php";
    require_once "controllers/admin/UsersController.php";

    /**
     * @var  {missionController, usersController}
     * sont des instances des deux classes 
     */
    $missionController = new MissionaryController();
    $usersController = new UsersController();

    try{
        /**
         * @var  $_GET['page']
         * est un parametre de l'url
         * sensé intercepter le nom de toutes les pages demander par l'utilisateur
         * 
         * Lors du chargement du site 
         * si le parametre est nul alors on charge la page d'acceuil
         */
        if(empty($_GET['page'])){
            require_once 'views/acceuil.view.php';
        }else{
            /**
             * Quant on recupère la page demander par l'utilisateur a travers le paramètre get['page']
             * On l'explose par les slash pour obtenir un tableau de valeur
             */
            $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
            
            switch($url[0]){
                case 'acceuil': require_once "views/acceuil.view.php"; break;
                case 'auth': $usersController->authentification(); break;
                case 'disconnect': $usersController->disconnect(); break;
                case 'dashboard': 
                    if(empty($url[1])){
                        $usersController->securityAuth();
                        $missionController->showMissionary(); 
                    }elseif($url[1] === "update"){
                        $usersController->securityAuth();
                        $idInt = (int)$url[2];
                        $missionController->updateMissionary($idInt);
                    }elseif($url[1] === "add"){
                        $usersController->securityAuth();
                        $missionController->addMissionary();
                    }elseif($url[1] === "single-page"){
                        $usersController->securityAuth();
                        $idInt = (int)$url[2];
                        $missionController->showSingleMissionary($idInt);
                    }elseif($url[1] === "validation"){
                        $usersController->securityAuth();
                        $missionController->validationAdd();
                    }elseif($url[1] === "delete"){
                        $usersController->securityAuth();
                        $idInt = (int)$url[2];
                        $missionController->deleteMissionary($idInt);
                    }elseif($url[1] === "vupdate"){
                        $usersController->securityAuth();
                        $missionController->saveUpdateMissionary();
                    }else{
                        throw new Exception("FILE NOT FOUND !");
                    }
                    break;
                case 'admin-dashboard':
                    if(empty($url[1])){
                        $usersController->securityAuth();
                        $usersController->showUsers(); 
                    }elseif($url[1] === "a-add"){
                        $usersController->securityAuth();
                        $usersController->creatUser();
                    }elseif($url[1] === "v-addAmin"){
                        $usersController->securityAuth();
                        $usersController->validationUser();
                    }elseif($url[1] === "a-update"){
                        $usersController->securityAuth();
                        $id = (int)$url[2];
                        $usersController->updateUser($id);
                    }elseif($url[1] === "v-updateAmin"){
                        $usersController->securityAuth();
                        $usersController->saveUpdateUser();
                    }elseif($url[1] === "a-delete"){
                        $usersController->securityAuth();
                        $id = (int)$url[2];
                        $usersController->deleteUser($id);
                    }else{
                        throw new Exception("FILE NOT FOUND !");
                    }
                    break;
                default:
                    throw new Exception("FILE NOT FOUND !");
                    break;
            }
        }
    }catch(Exception $e){
        $msg = $e->getMessage();
        /**
         * Au cas où une erreur se presente au niveau de n'importe quelle url
         * On charge une page pour presenter l'erreur
         */
        require_once "views/error.view.php";
    }

?>