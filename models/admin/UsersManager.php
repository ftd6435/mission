<?php

require_once "models/Model.php";
require_once "Users.php";

class UsersManager extends Model{

    private $users; // Tableau de tous les users de la BD

    /**
     * Elle permet d'ajouter un user dans le tableau users
     *
     */
    public function addUsers($users){
        $this->users[] = $users;
    }

    // Elle retourne le tableau des users
    public function getUsers(){return $this->users;}

    /**
     * Elle permet de recuperer de selectionner tous les admin de la BDD
     * Et enregistre dans le tableau users
     *
     */
    public function loaderUsers(){
        $search = $_POST['q'] ?? "";

        $bdd = $this->getBdd();
        $req = "SELECT * FROM users";
        $param = [];

        if(!empty($search)){
            $req .= " WHERE firstname LIKE '%' :value '%' OR lastname LIKE '%' :value '%' OR username LIKE '%' :value '%'";
            $param['value'] = $search;
        }
        $reqS = $bdd->prepare($req);
        $reqS->execute($param);
        $userss = $reqS->fetchAll(PDO::FETCH_ASSOC);
        $reqS->closeCursor();

        foreach($userss as $use){
            $user = new Users($use['id'],$use['lastname'],$use['firstname'],$use['username'],$use['email'],$use['profile'],$use['password']);
            $this->addUsers($user);
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $username
     * @param [type] $password
     * @return void
     * 
     * Elle permet de recuperer un user a travers son username et password
     * Elle retourne l'utilisateur s'il existe
     */
    public function getUserByUsernameEtPassword($username, $password){
        $_SESSION['auth'] = "";
        $_SESSION['user_profil'] = "";
        for($i = 0; $i < count($this->users); $i++){
            if($this->users[$i]->getUsernameAdmin() === $username){
                if(password_verify($password, $this->users[$i]->getPasswordAdmin())){
                    $_SESSION['auth'] = $this->users[$i];
                    $_SESSION['user_profil'] = $this->users[$i]->getProfilAdmin();
                }
            }
        }
    }

    // Elle retourne un utilisateur s'il exite a travers son id
    public function getUserByID($id){
        for($i = 0; $i < count($this->users); $i++){
            if($this->users[$i]->getIdAdmin() === $id){
                return $this->users[$i];
            }
        }

        throw new Exception("L'utilisateur que vous chercher n'existe pas !");
    }

    /**
     * Undocumented function
     *
     * @param [type] $name
     * @param [type] $pname
     * @param [type] $username
     * @param [type] $email
     * @param [type] $profil
     * @param [type] $password
     * @return void
     * 
     * Elle permet d'ajouter un utilisateur dans la BDD
     */
    public function addUserBD($name,$pname,$username,$email,$profil,$password){

        /**
        * Check l'image envoyer par le user
        * si elle est valide la fonction nous retourne le nom de l'image personaliser
        * Sinon une de caractere "error"
        */
        $name_profil = $this->validationProfil($profil);
        
        $reqInsert = "
                    INSERT INTO users (firstname,lastname,username,email,profile,password)
                    VALUES (:name,:pname,:username,:email,:profile,:password)
        ";

        $_SESSION['add-user'] = "";

        if(strlen($name) < 3 || strlen($pname) < 3){
            $_SESSION['add-user'] = "Le nom et prénom doit depassé 3 caractères !";
        }elseif(strlen($username) < 5){
            $_SESSION['add-user'] = "Le username doit être au moins 5 caratères !";
        }elseif(strlen($password) < 8){
            $_SESSION['add-user'] = "Le password au moins 8 caractères !";
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['add-user'] = "L'adresse n'est pas correct !";
        }elseif($name_profil === "error"){
            $_SESSION['add-user'] = $_SESSION['image'];
        } else{
            $psw_hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->getBdd()->prepare($reqInsert);

            $result = $stmt->execute([
                "name" => $name, "pname" => $pname, "username" => $username, "email" => $email, "profile" => $name_profil, "password" => $psw_hash
            ]);

            $stmt->closeCursor();
            
            if($result > 0){
                $rep = "public/images/";
                move_uploaded_file($profil['tmp_name'], $rep.$name_profil);
                $newUser = new Users($this->getBdd()->lastInsertId(),$name,$pname,$username,$email,$name_profil,$password);
                $this->addUsers($newUser);
            }else{
                throw new Exception("Insertion du nouveau user dans la BD a echouer !");
            }
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @param [type] $name
     * @param [type] $pname
     * @param [type] $username
     * @param [type] $email
     * @param [type] $profil
     * @param [type] $password
     * @return void
     * 
     * Elle permet de modifier l'utilisateur dans la BDD
     */
    public function updateUserBD($id, $name, $pname, $username, $email, $profil, $password){
        $id = (int)$id;

        // Get the user's picture
        $name_file = $this->getUserByID($id)->getProfilAdmin();
        $odd_profil = "";

        // test si un nouveau profil a été envoyer
        if(!empty($profil['name'])){
            $file_name = $this->validationProfil($profil);
            $odd_profil = $name_file;
            $name_file = $file_name;
        }

        $reqUpdate1 = "
                    UPDATE users SET firstname =:name,lastname =:pname,
                    username =:username,email =:email, profile =:profile,password =:password
                    WHERE id =:id
        ";

        $reqUpdate2 = "
                    UPDATE users SET firstname =:name,lastname =:pname,
                    username =:username,email =:email, profile =:profile
                    WHERE id =:id
        ";
        
        $_SESSION['update-user'] = "";

        if(strlen($name) < 3 || strlen($pname) < 3){
            $_SESSION['update-user'] = "Le nom et prénom doit depassé 3 caractères !";
        }elseif(strlen($username) < 5){
            $_SESSION['update-user'] = "Le username doit être au moins 5 caratères !";
        }elseif(!empty($password) && strlen($password) < 8){
            $_SESSION['update-user'] = "Le password au moins 8 caractères !";
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['update-user'] = "L'adresse n'est pas correct !";
        }elseif(!empty($profil['name']) && $name_file === "error"){
            $_SESSION['update-user'] = $_SESSION['image'];
        }else{
            $psw_hash = password_hash($password, PASSWORD_BCRYPT);
            if(!empty($password)){
                $stmt = $this->getBdd()->prepare($reqUpdate1);
                $result = $stmt->execute([
                    "name" => $name, "pname" => $pname, "username" => $username, "email" => $email, "profile" => $name_file, "password" => $psw_hash, "id" => $id
                ]);
            }else{
                $stmt = $this->getBdd()->prepare($reqUpdate2);
                $result = $stmt->execute([
                    "name" => $name, "pname" => $pname, "username" => $username, "email" => $email, "profile" => $name_file, "id" => $id
                ]);
            }
            

            
            $stmt->closeCursor();

            if($result > 0){
                // s'il y'a un nouveau profil on supprime l'ancien et enregistre le nouveau
                if($odd_profil !== ""){
                    $rep = "public/images/";
                    unlink($rep.$odd_profil);
                    move_uploaded_file($profil['tmp_name'], $rep.$name_file);
                }

                $this->getUserByID($id)->setFirstnameAdmin($pname);
                $this->getUserByID($id)->setLastnameAdmin($name);
                $this->getUserByID($id)->setUsernameAdmin($username);
                $this->getUserByID($id)->setEmailAdmin($email);
                $this->getUserByID($id)->setProfilAdmin($name_file);
                if(!empty($password)){$this->getUserByID($id)->setPasswordAdmin($password);}
            }else{
                throw new Exception("Modification de l'utilisateur a echouer !");
            }
        }
    }

    /**
     * Elle permet de supprimer un user dans la BD et dans le le tableau user
     *
     */
    public function deleteUserBD($id){
        $reqDelete = "DELETE FROM users WHERE id = :id";
        $statement = $this->getBdd()->prepare($reqDelete);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);

        $result = $statement->execute();
        $statement->closeCursor();
        $_SESSION['delete-user'] = "";
        if($result > 0){
            // recuperer le user a supprimer dans le tableau user
            $delUser = $this->getUserByID($id);
            // recuperer le profil du user a supprimer
            $profil_user = $this->getUserByID($id)->getProfilAdmin();
            unlink("public/images/".$profil_user);
            unset($delUser);
        }else{
            $_SESSION['delete-user'] = "Suppression User echouer !";
            throw new Exception("Suppression User echouer !");
        }
    }

}

?>