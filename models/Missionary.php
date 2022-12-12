<?php

class Missionary{
    private $id;
    private $lastname;
    private $firstname;
    private $email;
    private $tel;
    private $provenance;
    private $destination;
    private $title;
    private $echelle;
    private $types;
    private $cadreMission;
    private $debutMission;
    private $finMission;
    private $composition;
    private $departement;
    private $status;
    private $observation;
    private $profil;
    private $creatAt;

    public function __construct($id,$lastname,$firstname,$email,$tel,$provenance,$destination,$title,
                                $echelle,$types,$cadreMission,$debutMission,$finMission,$composition,$departement,$status,$observation,$profil,$creatAt)
    {
        $this->id = $id;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->email = $email;
        $this->tel = $tel;
        $this->provenance = $provenance;
        $this->destination = $destination;
        $this->title = $title;
        $this->echelle = $echelle;
        $this->types = $types;
        $this->cadreMission = $cadreMission;
        $this->debutMission = $debutMission;
        $this->finMission = $finMission;
        $this->composition = $composition;
        $this->departement = $departement;
        $this->status = $status;
        $this->observation = $observation;
        $this->profil = $profil;
        $this->creatAt = $creatAt;
    }

    public function getId(){return $this->id;}
    public function setId($id){$this->id = $id;}

    public function getLastname(){return $this->lastname;}
    public function setLastname($lastname){$this->lastname = $lastname;}

    public function getFirstname(){return $this->firstname;}
    public function setFirstname($firstname){$this->firstname = $firstname;}

    public function getEmail(){return $this->email;}
    public function setEmail($email){$this->email = $email;}

    public function getTel(){return $this->tel;}
    public function setTel($tel){$this->tel = $tel;}

    public function getTitle(){return $this->title;}
    public function setTitle($title){$this->title = $title;}

    public function getProvenance(){return $this->provenance;}
    public function setProvenance($provenance){$this->provenance = $provenance;}

    public function getDestination(){return $this->destination;}
    public function setDestination($destination){$this->destination = $destination;}

    public function getEchelle(){return $this->echelle;}
    public function setEchelle($echelle){$this->echelle = $echelle;}

    public function getTypes(){return $this->types;}
    public function setTypes($types){$this->types = $types;}

    public function getCadreMission(){return $this->cadreMission;}
    public function setCadreMission($cadreMission){$this->cadreMission = $cadreMission;}

    public function getDebutMission(){return $this->debutMission;}
    public function setDebutMission($debutMission){$this->debutMission = $debutMission;}

    public function getFinMission(){return $this->finMission;}
    public function setFinMission($finMission){$this->finMission = $finMission;}

    public function getCompostion(){return $this->composition;}
    public function setCompostion($composition){$this->composition = $composition;}

    public function getDepartement(){return $this->departement;}
    public function setDepartement($departement){$this->departement = $departement;}

    public function getStatus(){return $this->status;}
    public function setStatus($status){$this->status = $status;}

    public function getObservation(){return $this->observation;}
    public function setObservation($observation){$this->observation = $observation;}

    public function getProfil(){return $this->profil;}
    public function setProfil($profil){$this->profil = $profil;}

    public function getCreatAt(){return $this->creatAt;}
    public function setCreatAt($creatAt){$this->creatAt = $creatAt;}
}

?>