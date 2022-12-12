<?php 
    /**
     * Page affichage d'un missionaire
     * Elle permet d'afficher toute les information d'un missionaire
     */
    ob_start();
?>

<a class="btn btn-primary mt-5 px-4 py-3 pk-btn-add" href="<?= URL ?>dashboard">Retour</a>

<div class="row mt-5">
    <div class="col-md-6 pk-right-side">
        <img src="<?= URL ?>public/images/<?= $mission->getProfil() ?>" alt="profil-single-page">
    </div>
    <div class="col-md-6 pk-left-side">
        <div class="pk-single-list">
            <h2 class="pk-libelle">Nom :</h2>
            <h2 class="pk-big-detail name"><?= $mission->getLastname() ?></h2>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Prénom :</h2>
            <h2 class="pk-big-detail"><?= $mission->getFirstname() ?></h2>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">E-mail :</h2>
            <h2 class="pk-big-detail"><?= $mission->getEmail() ?></h2>
        </div> 
        <div class="pk-single-list">
            <h2 class="pk-libelle">Tel :</h2>
            <h2 class="pk-big-detail"><?= $mission->getTel() ?></h2>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Titre :</h2>
            <h2 class="pk-big-detail"><?= $mission->getTitle() ?></h2>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Provenance :</h2>
            <p class="pk-detail"><?= $mission->getProvenance() ?></p>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Destination :</h2>
            <p class="pk-detail"><?= $mission->getDestination() ?></p>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Echelle :</h2>
            <p class="pk-detail"><?= $mission->getEchelle() ?></p>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Types :</h2>
            <p class="pk-detail"><?= $mission->getTypes() ?></p>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Cadre de la mission :</h2>
            <p class="pk-detail"><?= $mission->getCadreMission() ?></p>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Période de début :</h2>
            <p class="pk-detail"><?= $mission->getDebutMission() ?></p>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Période de fin :</h2>
            <p class="pk-detail"><?= $mission->getFinMission() ?></p>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Composition :</h2>
            <p class="pk-detail"><?= $mission->getCompostion() ?></p>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Département :</h2>
            <p class="pk-detail"><?= $mission->getDepartement() ?></p>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Status :</h2>
            <p class="pk-detail"><?= $mission->getStatus() ?></p>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Observation :</h2>
            <p class="pk-detail"><?= $mission->getObservation() ?></p>
        </div>
        <div class="pk-single-list">
            <h2 class="pk-libelle">Date d'enrégistrement :</h2>
            <p class="pk-detail"><?= $mission->getCreatAt() ?></p>
        </div>
    </div>
</div>

<?php 
    $title = $mission->getTitle();
    $username_auth = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    $user_profil = isset($_SESSION['user_profil']) ? $_SESSION['user_profil'] : "";
    $content = ob_get_clean();
    require_once "template.php";
?>