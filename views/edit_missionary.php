<?php 
    /**
     * Page de modification
     * Elle permet de modifier les information d'un missionaire
     */
    ob_start();
?>

<h1 class="page-title">Bienvenu dans ma page de modification</h1>

<a href="<?= URL ?>dashboard" class="btn btn-primary mt-5 px-4 py-3 pk-btn-add">Retour</a>

<div class="row my-5">
    <div class="col-md-10 offset-md-1">
        <?php if(isset($_SESSION['update-mis']) && !empty($_SESSION['update-mis'])) : ?>
            <div class="alert alert-danger"><?= $_SESSION['update-mis'] ?></div>
        <?php 
          unset($_SESSION['update-mis']);
          endif; 
        ?>

        <form class="row g-3" action="<?= URL ?>dashboard/vupdate" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $missionUpdate->getId() ?>">
          <div class="col-md-6">
            <label for="lastname" class="form-label pk-form-label">Lastname</label>
            <input type="text" name="lastname" class="form-control pk-form-control" id="lastname" value="<?= $missionUpdate->getLastname() ?>">
          </div>
          <div class="col-md-6">
            <label for="firstname" class="form-label pk-form-label">Firstname</label>
            <input type="text" name="firstname" class="form-control pk-form-control" id="firstname" value="<?= $missionUpdate->getFirstname() ?>">
          </div>

          <div class="col-md-6">
            <label for="email" class="form-label pk-form-label">Email</label>
            <input type="email" name="email" class="form-control pk-form-control" id="email" value="<?= $missionUpdate->getEmail() ?>">
          </div>
          <div class="col-md-6">
            <label for="tel" class="form-label pk-form-label">Tel</label>
            <input type="tel" name="tel" class="form-control pk-form-control" id="tel" value="<?= $missionUpdate->getTel() ?>">
          </div>

          <div class="col-md-6">
            <label for="provenance" class="form-label pk-form-label">Provenance</label>
            <input type="text" name="provenance" class="form-control pk-form-control" id="provenance" value="<?= $missionUpdate->getProvenance() ?>">
          </div>
          <div class="col-md-6">
            <label for="destionation" class="form-label pk-form-label">Destination</label>
            <input type="text" name="destination" class="form-control pk-form-control" id="destionation" value="<?= $missionUpdate->getDestination() ?>">
          </div>

          <div class="col-md-6">
            <label for="titre" class="form-label pk-form-label">Titre</label>
            <input type="text" name="titre" class="form-control pk-form-control" id="titre" value="<?= $missionUpdate->getTitle() ?>">
          </div>
          <div class="col-md-6">
            <label for="cadre-mission" class="form-label pk-form-label">Cadre de mission</label>
            <input type="text" name="cadre-mission" class="form-control pk-form-control" id="cadre-mission" value="<?= $missionUpdate->getCadreMission() ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label" for="">Echelle</label>
                <select class="form-select pk-form-select" name="echelle" size="3" aria-label="size 3 select example">
                    <option value="national" <?= ($missionUpdate->getEchelle() === "national") ? "selected" : "" ?>>Nationale</option>
                    <option value="internationale" <?= ($missionUpdate->getEchelle() === "internationale") ? "selected" : "" ?>>Internationale</option>
                    <option value="africaine" <?= ($missionUpdate->getEchelle() === "africaine") ? "selected" : "" ?>>Africaine</option>
                </select>   
          </div>
          <div class="col-md-6">
                <label class="form-label" for="">Types</label>
                <select class="form-select pk-form-select" name="types" size="3" aria-label="size 3 select example">
                    <option value="entrant" <?= ($missionUpdate->getTypes() === "entrant") ? "selected" : "" ?>>Entrant</option>
                    <option value="sortant" <?= ($missionUpdate->getTypes() === "sortant") ? "selected" : "" ?>>Sortant</option>
                </select>
          </div>

          <div class="col-6">
            <label for="compositon" class="form-label">Composition</label>
            <input type="text" class="form-control pk-form-control" name="composition" id="composition" value="<?= $missionUpdate->getCompostion() ?>">
          </div>
          <div class="col-6">
            <label for="departement" class="form-label pk-form-label">Département impliqué</label>
            <input type="text" name="departement" class="form-control pk-form-control" id="departement" value="<?= $missionUpdate->getDepartement() ?>">
          </div>

          <div class="col-md-6">
            <label for="debut" class="form-label pk-form-label">Debut mission</label>
            <input type="date" name="debut-mission" class="form-control pk-form-control" id="debut" value="<?= $missionUpdate->getDebutMission() ?>">
          </div>
          <div class="col-md-6">
            <label for="fin" class="form-label pk-form-label">Fin mission</label>
            <input type="date" name="fin-mission" class="form-control pk-form-control" id="fin" value="<?= $missionUpdate->getFinMission() ?>">
          </div>

          <div class="col-md-12">
            <label for="observation" class="form-label pk-form-label">Observation</label>
            <textarea class="form-control pk-form-control" name="observation" id="observation" rows="3"><?= $missionUpdate->getObservation() ?></textarea>
          </div>

          <div class="col-md-2">
            <img src="<?= URL ?>public/images/<?= $missionUpdate->getProfil() ?>" alt="Profil_missionaire">
          </div>
          <div class="col-md-12">
            <label for="image" class="form-label pk-form-label">Profil image</label>
            <input type="file" class="form-control pk-form-control" id="image" name="image" value="" require>
          </div>

          <div class="col-md-6">
            <label for="status" class="form-label pk-form-label">Status</label>
            <select class="form-select pk-form-select" name="status" aria-label="Default select example">
                <option value="realiser" <?= ($missionUpdate->getStatus() === "realiser") ? "selected" : "" ?>>Réaliser</option>
                <option value="encours" <?= ($missionUpdate->getStatus() === "encours") ? "selected" : "" ?>>En cours</option>
                <option value="reporter" <?= ($missionUpdate->getStatus() === "reporter") ? "selected" : "" ?>>Réporter</option>
                <option value="autre" <?= ($missionUpdate->getStatus() === "autre") ? "selected" : "" ?>>Autre</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="creatAt" class="form-label">Date Enregistrement</label>
            <input type="date" name="creatAt" class="form-control pk-form-control" id="creatAt" value="<?= $missionUpdate->getCreatAt() ?>">
          </div>

          <div class="col-12">
            <button type="submit" class="btn pk-btn-success">VALIDER</button>
          </div>
        </form>
    </div>
</div>


<?php 
    $title = "Modification";
    $username_auth = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    $user_profil = isset($_SESSION['user_profil']) ? $_SESSION['user_profil'] : "";
    $content = ob_get_clean();
    require_once "template.php";
?>