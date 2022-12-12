<?php
require_once 'models/MissonaryManager.php';

class MissionaryController{

    private $missionManager;

    public function __construct()
    {
        $this->missionManager = new MissionaryManager;
        $this->missionManager->loaderMissioner();
    }

    /**
     * Undocumented function
     *
     * @return void
     * Elle permet de recuperer tous les missionaire 
     * les charger dans la page dashboard avant de l'afficher
     */
    public function showMissionary(){
        $missionaires = $this->missionManager->getMissionary();
        $reqTotal = $this->missionManager->reqTotalMissioner();
        $reqEncours = $this->missionManager->reqMissioner('status', "encours");
        $reqRealiser = $this->missionManager->reqMissioner("status", "realiser");
        $reqReporter = $this->missionManager->reqMissioner("status", "reporter");
        $reqEntrant = $this->missionManager->reqMissioner("types", "entrant");
        $reqSortant = $this->missionManager->reqMissioner("types", "sortant");
        require_once "views/dashboard.view.php";
    }


    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     * Elle permet de recuperer un missionaire avec toute ses information 
     * Puis l'afficher dans le single page
     */
    public function showSingleMissionary($id){
        $mission = $this->missionManager->getMissionaryById($id);
        require_once "views/single.view.php";
    }
    
    /**
     * Undocumented function
     *
     * @return void
     * 
     * Elle permet d'afficher le formulaire d'ajout d'un missionaire
     */
    public function addMissionary(){
        require_once "views/add_missionary.php";
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     * Elle permet de recuperer les information d'un missionaire
     * puis les afficher dans un formulaire de modification
     */
    public function updateMissionary($id){
        $missionUpdate = $this->missionManager->getMissionaryById($id);
        require_once "views/edit_missionary.php";
    } 

    /**
     * Undocumented function
     *
     * @return void
     * Elle permet de recuperer les information du formulaire de modification
     * Puis les traiter
     */
    public function saveUpdateMissionary(){ 
        $profil = $_FILES['image']; 
        $id = (int)$_POST['id'];
        
        $this->missionManager->updateMissionaryBD($_POST['id'], $_POST['lastname'],$_POST['firstname'],$_POST['email'],$_POST['tel'],$_POST['provenance'],
                                                $_POST['destination'],$_POST['titre'],$_POST['echelle'],$_POST['types'],$_POST['cadre-mission'],
                                                $_POST['debut-mission'],$_POST['fin-mission'],$_POST['composition'],$_POST['departement'],$_POST['status'],
                                                $_POST['observation'],$profil,$_POST['creatAt']);
        
        if($_SESSION['update-mis'] === ""){
            $_SESSION['update-mis-success'] = "Un missionaire a été modifié avec success !";
            header('Location: '. URL ."dashboard");
        }else{
            header('Location:'. URL ."dashboard/update/".$_POST['id']);
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     * Elle permet de recuperer les information d'un missionaire a ajouter
     * Puis les traiter avant de les ajouter
     */
    public function validationAdd(){
        $profil = $_FILES['image'];
        $this->missionManager->addMissionaryBD($_POST['lastname'],$_POST['firstname'],$_POST['email'],$_POST['tel'],$_POST['provenance'],
                                                $_POST['destination'],$_POST['titre'],$_POST['echelle'],$_POST['types'],$_POST['cadre-mission'],
                                                $_POST['debut-mission'],$_POST['fin-mission'],$_POST['composition'],$_POST['departement'],$_POST['status'],
                                                $_POST['observation'],$profil,$_POST['creatAt']);

        if($_SESSION['add_missionaire'] === ""){
            $_SESSION['add_mis_success'] = "Un missionaire ajouter avec succès !";
            header('Location: '. URL ."dashboard");
        }else{
            header('Location: '. URL ."dashboard/add");
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     * 
     * Recupere l'id du missionaire a supprimer
     * Puis lui supprime
     */
    public function deleteMissionary($id){
        $this->missionManager->deleteMissionaryBD($id);

        if($_SESSION['delete_mis'] == ""){
            $_SESSION['delete_m_success'] = "Un missionaire a été supprimer avec success !";
            header('Location: '. URL ."dashboard");
        }else{
            header('Location: '. URL ."dashboard/delete");
        }
    }
}

?>