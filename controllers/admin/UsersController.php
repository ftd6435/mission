<?php

require_once "models/admin/UsersManager.php";

class UsersController{
    private $usersManager;

    public function __construct()
    {
        $this->usersManager = new UsersManager;
        $this->usersManager->loaderUsers();
    }

    /**
     * Undocumented function
     *
     * @return void
     * 
     * Elle permet traiter les coordonner d'un utilisateur pour valider son authentification
     */
    public function authentification(){
         $this->usersManager->getUserByUsernameEtPassword($_POST['username'], $_POST['password']);
         $_SESSION['username'] = "";
        if(!empty($_SESSION['auth'])){  
            $_SESSION['username'] = $_POST['username'];
            header("Location: ". URL ."dashboard");
        }else{
            $_SESSION['auth_error'] = "Authentification echouer !";
            header("Location: ". URL);
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     * Elle permet de deconnecter l'utilisateur connecter
     */
    public function disconnect(){
        unset($_SESSION['auth']);
        unset($_SESSION['username']);
        unset($_SESSION['user_profil']);
        header("Location:". URL);
    }

    /**
     * Undocumented function
     *
     * @return void
     * Elle permet d'empêcher l'accès au autres pages sans etre authentifié before
     */
    public function securityAuth(){
        if(empty($_SESSION['auth'])){
            header("Location: ". URL);
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     * Elle recupere tous les admin avant de les afficher dans la page 
     * dashboard or tableau de bord admin
     */
    public function showUsers(){
        $userss = $this->usersManager->getUsers();
        require_once "views/admin/admin_dashboard.php";
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     * Elle recupere les information d'un admin avant de les afficher dans le formulaire de modification
     */
    public function updateUser($id){
        $updateUser = $this->usersManager->getUserByID($id);
        require_once "views/admin/update_admin.php";
    }

    // Elle permet d'afficher le formulaire d'ajout d'un admin
    public function creatUser(){
        require_once "views/admin/add_admin.php";
    }

    /**
     * Undocumented function
     *
     * @return void
     * Elle permet de recuperer les informations d'un nouveau utilisateur a ajouter
     * Les traiter avant d'ajouter
     */
    public function validationUser(){
        $profil = $_FILES['image'];
        $this->usersManager->addUserBD($_POST['lastname'],$_POST['firstname'], $_POST['username'], $_POST['email'], $profil, $_POST['password']);
        
       if($_SESSION['add-user'] === ""){
            $_SESSION['add-u-success'] = "Un utilisateur ajouter avec success !";
            header('Location:'. URL ."admin-dashboard");
       }else{
            header('Location:'. URL ."admin-dashboard/a-add");
       }
    }

    /**
     * Undocumented function
     *
     * @return void
     * Elle permet de recuperer les information d'un utilisateur a modifier
     * Les traiter avant de modifier
     */
    public function saveUpdateUser(){
        $profil = $_FILES['image'];
        $id = (int)$_POST['id'];
 
        $this->usersManager->updateUserBD($_POST['id'],$_POST['lastname'],$_POST['firstname'], $_POST['username'], $_POST['email'], $profil, $_POST['password']);
        
        if($_SESSION['update-user'] === ""){
            $_SESSION['update-u-success'] = "Un utilisateur a été modifié avec success !";
            header('Location:'. URL ."admin-dashboard");
       }else{
            header('Location:'. URL ."admin-dashboard/a-update/".$_POST['id']);
       }
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     * 
     * Elle permet de supprimer un admin a travers son id
     */
    public function deleteUser($id){
        $this->usersManager->deleteUserBD($id);
        if($_SESSION['delete-user'] === ""){
            $_SESSION['delete-u-success'] = "Un utilisateur a été supprimer avec success !";
            header('Location:'. URL ."admin-dashboard");
       }else{
            header('Location:'. URL ."admin-dashboard/a-delete");
       }
    }
}

?>