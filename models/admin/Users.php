<?php

class Users{

    private $id;
    private $firstname;
    private $lastname;
    private $username;
    private $email;
    private $profil;
    private $password;

    public function __construct($id, $firstname, $lastname, $username, $email,$profil, $password)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->email = $email;
        $this->profil = $profil;
        $this->password = $password;
    }

    public function getIdAdmin(){return $this->id;}
    public function setIdAdmin($id){$this->id = $id;}

    public function getFirstnameAdmin(){return $this->firstname;}
    public function setFirstnameAdmin($firstname){$this->firstname = $firstname;}

    public function getLastnameAdmin(){return $this->lastname;}
    public function setLastnameAdmin($lastname){$this->lastname = $lastname;}

    public function getUsernameAdmin(){return $this->username;}
    public function setUsernameAdmin($username){$this->username = $username;}

    public function getEmailAdmin(){return $this->email;}
    public function setEmailAdmin($email){$this->email = $email;}

    public function getProfilAdmin(){return $this->profil;}
    public function setProfilAdmin($profil){$this->profil = $profil;}

    public function getPasswordAdmin(){return $this->password;}
    public function setPasswordAdmin($password){$this->password = $password;}
}

?>