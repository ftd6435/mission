<?php

require_once "Model.php";
require_once "Missionary.php";
 
class MissionaryManager extends Model{
    private $missioner; // Tableau de tous les missionaire de la BD

    /**
     * @param [type] $missionary
     * @return void
     * 
     * Elle permet d'ajouter un nouveau missionaire dans le tableau @var $missioner
     */
    public function addMissionary($missionary){
        $this->missioner[] = $missionary;
    }

    /**
     * Elle permet de retourner la liste de tous les missionaire
     * @return void
     */
    public function getMissionary(){return $this->missioner;}

    /**
     * Elle permet de selectionner tous les missionaire enrégistrer dans la BD
     * Et mettre dans le tableau des missionaire @var $missioner
     * @return void
     */
    public function loaderMissioner(){
        $search = $_POST['q'] ?? "";

        $bdd = $this->getBdd();
        $req = "SELECT * FROM missionary";
        $param = [];

        if(!empty($search)){
            $req .= " WHERE status LIKE '%' :value '%' OR echelle LIKE '%' :value '%' OR types LIKE '%' :value '%'";
            $param['value'] = $search;
        }

        $reqS = $bdd->prepare($req);
        $reqS->execute($param);
        $missioners = $reqS->fetchAll(PDO::FETCH_ASSOC);

        $reqS->closeCursor();

        foreach($missioners as $mission){
            $missionaire = new Missionary($mission['id'],$mission['lastname'],$mission['firstname'],$mission['email'],$mission['tel'],$mission['provenance'],$mission['destination'],$mission['title'],$mission['echelle'],$mission['types'],$mission['cadre_mission'],$mission['debut_mission'],$mission['fin_mission'],$mission['composition'],$mission['departement'],$mission['status'],$mission['observation'],$mission['profile'],$mission['createAt']);
            $this->addMissionary($missionaire);
        }
    }

    // Elle permet de retourner un missionaire a travers son id
    public function getMissionaryById($id){
        for($i = 0; $i < count($this->missioner); $i++){
            if($this->missioner[$i]->getId() === $id){
                return $this->missioner[$i];
            }
        }

        throw new Exception("Missionary n'existe pas !");
    }

    /**
     * Elle permet d'ajouter un missionaire dans la base de donner
     * @return void
     */
    public function addMissionaryBD($lastname,$firstname,$email,$tel,$provenance,$destination,$title,
                                    $echelle,$types,$cadreMission,$debutMission,$finMission,$composition,$departement,$status,
                                    $observation,$profil,$creatAt){
                /**
                 * Check l'image envoyer par le user
                 * si elle est valide la fonction nous retourne le nom de l'image personaliser
                 * Sinon une de caractere "error"
                 */
                $profil_mis = $this->validationProfil($profil);
                    
                $reqInsert = "
                              INSERT INTO 
                                missionary (firstname,lastname,email,tel,title,provenance,destination,echelle,types,cadre_mission,debut_mission,fin_mission,composition,departement,status,observation,profile,createAt)
                                values (:firstname,:lastname,:email,:tel,:title,:provenance,:destination,:echelle,:types,:cadre_mission,:debut_mission,:fin_mission,:composition,:departement,:status,:observation,:profil,:createAt)
                            ";

                $_SESSION['add_missionaire'] = "";

                if(strlen($firstname) < 3 || strlen($lastname) < 3){
                    $_SESSION['add_missionaire'] = "Le nom et prénom doit depassé 3 caractères !";
                }elseif(strlen($title) < 5 || strlen($provenance) < 5 || strlen($destination) < 5 || strlen($cadreMission) < 5 || strlen($composition) < 5 || strlen($departement) < 5){
                    $_SESSION['add_missionaire'] = "Les champs texte doivent contenir au moins 5 caratères !";
                }elseif(empty($debutMission) || empty($finMission) || empty($creatAt)){
                    $_SESSION['add_missionaire'] = "Renseignez les champs de type date !";
                }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $_SESSION['add_missionaire'] = "L'adresse n'est pas correct !";
                }elseif($profil_mis === "error"){
                    $_SESSION['add_missionaire'] = $_SESSION['image'];
                }else{
                    $statement = $this->getBdd()->prepare($reqInsert);

                    $statement->bindValue(":firstname", $firstname, PDO::PARAM_STR);
                    $statement->bindValue(":lastname", $lastname, PDO::PARAM_STR);
                    $statement->bindValue(":email", $email, PDO::PARAM_STR);
                    $statement->bindValue(":tel", $tel, PDO::PARAM_INT);
                    $statement->bindValue(":title", $title, PDO::PARAM_STR);
                    $statement->bindValue(":provenance", $provenance, PDO::PARAM_STR);
                    $statement->bindValue(":destination", $destination, PDO::PARAM_STR);
                    $statement->bindValue(":echelle", $echelle, PDO::PARAM_STR);
                    $statement->bindValue(":types", $types, PDO::PARAM_STR);
                    $statement->bindValue(":cadre_mission", $cadreMission, PDO::PARAM_STR);
                    $statement->bindValue(":debut_mission", $debutMission);
                    $statement->bindValue(":fin_mission", $finMission);
                    $statement->bindValue(":composition", $composition, PDO::PARAM_STR);
                    $statement->bindValue(":departement", $departement, PDO::PARAM_STR);
                    $statement->bindValue(":status", $status, PDO::PARAM_STR);
                    $statement->bindValue(":observation", $observation, PDO::PARAM_STR);
                    $statement->bindValue(":profil",$profil_mis);
                    $statement->bindValue(":createAt", $creatAt);
    
                    $result = $statement->execute();
                    $statement->closeCursor();
    
                    if($result > 0){
                        $rep = "public/images/";
                        move_uploaded_file($profil['tmp_name'], $rep.$profil_mis);
                        $newMissionner = new Missionary($this->getBdd()->lastInsertId(),$lastname,$firstname,$email,$tel,$provenance,$destination,$title,
                                                                                        $echelle,$types,$cadreMission,$debutMission,$finMission,$composition,$departement,$status,
                                                                                        $observation,$profil_mis,$creatAt);
                        $this->addMissionary($newMissionner);
                    }else{
                        throw new Exception("Insertion echouer !");
                    }
                }
    }

    /**
     * Elle permet de modifier un missionaire dans la BD
     *
     */
    public function updateMissionaryBD($id,$lastname,$firstname,$email,$tel,$provenance,$destination,$title,
                                        $echelle,$types,$cadreMission,$debutMission,$finMission,$composition,$departement,$status,
                                        $observation,$profil,$creatAt){
                $reqUp = "
                        UPDATE missionary
                        SET firstname =:firstname, lastname =:lastname, email =:email, tel =:tel, provenance =:provenance, destination =:destination,
                            title =:title, echelle =:echelle, types =:types, cadre_mission =:cmission, debut_mission =:dmission, fin_mission =:fmission,
                            composition =:composition, departement =:departement, status =:status, observation =:observation,profile =:profil, createAt =:createAt
                        WHERE id =:id
                ";
                $id = (int)$id;
                
                // Get the user's picture
                $name_profil = $this->getMissionaryById($id)->getProfil();
                $odd_profil = "";

                // test si un nouveau profil a été envoyer
                if(!empty($profil['name'])){
                    $file_name = $this->validationProfil($profil);
                    $odd_profil = $name_profil;
                    $name_profil = $file_name;
                }

                $_SESSION['update-mis'] = "";

                if(strlen($firstname) < 3 || strlen($lastname) < 3){
                    $_SESSION['update-mis'] = "Le nom et prénom doit depassé 3 caractères !";
                }elseif(strlen($title) < 5 || strlen($provenance) < 5 || strlen($destination) < 5 || strlen($cadreMission) < 5 || strlen($composition) < 5 || strlen($departement) < 5){
                    $_SESSION['update-mis'] = "Les champs texte doivent contenir au moins 5 caratères !";
                }elseif(empty($debutMission) || empty($finMission) || empty($creatAt)){
                    $_SESSION['update-mis'] = "Renseignez les champs de type date !";
                }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $_SESSION['update-mis'] = "L'adresse n'est pas correct !";
                }elseif(!empty($profil['name']) && $name_profil === "error"){
                    $_SESSION['update-mis'] = $_SESSION['image'];
                }else{
                    $stmt = $this->getBdd()->prepare($reqUp);

                    $resultat = $stmt->execute([
                        "id" => $id, "lastname" => $lastname, "firstname" => $firstname, "email" => $email, "tel" => $tel,
                        "provenance" => $provenance, "destination" => $destination, "title" => $title, "echelle" => $echelle,
                        "types" => $types, "cmission" => $cadreMission, "dmission" => $debutMission, "fmission" => $finMission,
                        "composition" => $composition, "departement" => $departement, "status" => $status, "observation" => $observation,
                        "profil" => $name_profil, "createAt" => $creatAt
                    ]);
                    $stmt->closeCursor();

                    if($resultat > 0){
                        // s'il y'a un nouveau profil on supprime l'ancien et enregistre le nouveau
                        if($odd_profil !== ""){
                            $rep = "public/images/";
                            unlink($rep.$odd_profil);
                            move_uploaded_file($profil['tmp_name'], $rep.$name_profil);
                        }

                        $this->getMissionaryById($id)->setLastname($lastname);
                        $this->getMissionaryById($id)->setFirstname($firstname);
                        $this->getMissionaryById($id)->setEmail($email);
                        $this->getMissionaryById($id)->setTel($tel);
                        $this->getMissionaryById($id)->setProvenance($provenance);
                        $this->getMissionaryById($id)->setDestination($destination);
                        $this->getMissionaryById($id)->setTitle($title);
                        $this->getMissionaryById($id)->setEchelle($echelle);
                        $this->getMissionaryById($id)->setTypes($types);
                        $this->getMissionaryById($id)->setCadreMission($cadreMission);
                        $this->getMissionaryById($id)->setDebutMission($debutMission);
                        $this->getMissionaryById($id)->setFinMission($finMission);
                        $this->getMissionaryById($id)->setCompostion($composition);
                        $this->getMissionaryById($id)->setDepartement($departement);
                        $this->getMissionaryById($id)->setStatus($status);
                        $this->getMissionaryById($id)->setObservation($observation);
                        $this->getMissionaryById($id)->setProfil($name_profil);
                        $this->getMissionaryById($id)->setCreatAt($creatAt);
                    }else{
                        throw new Exception("Modification echouer !");
                    }
                }

    }

    /**
     * Elle permet de supprimer un missionaire dans la BD et dans le le tableau missioner
     *
     */
    public function deleteMissionaryBD($id){
        $reqDelete = "DELETE FROM missionary WHERE id = :idM";
        $statement = $this->getBdd()->prepare($reqDelete);
        $statement->bindValue(":idM", $id, PDO::PARAM_INT);

        $result = $statement->execute();
        $statement->closeCursor();

        $_SESSION['delete_mis'] = "";
        if($result > 0){
            // recuperer le missionair a supprimer dans le tableau missioner
            $delMiss = $this->getMissionaryById($id);
            // recuperer le profil du missionaire a supprimer
            $profil_missionaire = $this->getMissionaryById($id)->getProfil();
            unlink("public/images/".$profil_missionaire);
            unset($delMiss);
        }else{
            $_SESSION['delete_mis'] = "Suppression du missionaire echouer !";
            throw new Exception("Suppression du missionaire echouer !");
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     * 
     * cette fonction permet de retourner le nombre de missionaire total enrégistrer dans la base de donner
     */
    public function reqTotalMissioner(){
        $bdd = $this->getBdd();
        $req = "SELECT COUNT(*) as count FROM missionary";
        $stmt = $bdd->prepare($req);
        $stmt->execute();
        $result = $stmt->fetch()['count'];
        $stmt->closeCursor();
        return $result;
    }

    /**
     * Undocumented function
     *
     * @param [type] $champ
     * @param [type] $value
     * @return void
     * 
     * Est une fonction dynamique permetant d'executer et retourne un valeur a propos de n'importe quel cas de recherche
     * Baser sur la table Missionayr
     */
    public function reqMissioner($champ, $value){
        $bdd = $this->getBdd();
        $req = "SELECT COUNT(*) as count FROM missionary";
        $req .= ' WHERE ' . $champ . ' =:value';
        $param['value'] = $value;
        $stmt = $bdd->prepare($req);
        $stmt->execute($param);
        $result = $stmt->fetch()['count'];
        $stmt->closeCursor();
        return $result;
    }
}

?>