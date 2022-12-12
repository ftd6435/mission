<?php 
    /**
     * Page d'ajout d'un missionaire
     * Elle permet l'utilisateur connecter d'ajouter un missionaire
     */
    ob_start();
?>

<h1 class="page-title">Bienvenu dans ma page d'ajout d'un missionaire</h1>

<a href="<?= URL ?>dashboard" class="btn btn-primary mt-5 px-4 py-3 pk-btn-add">Retour</a>

<div class="row my-5">
    <div class="col-md-10 offset-md-1">

        <?php if(isset($_SESSION['add_missionaire']) && !empty($_SESSION['add_missionaire'])) : ?>
            <div class="alert alert-danger"><?= $_SESSION['add_missionaire'] ?></div>
        <?php 
          unset($_SESSION['add_missionaire']);
          endif; 
        ?>

        <form class="row g-3" action="<?= URL ?>dashboard/validation" method="POST" enctype="multipart/form-data">
          <div class="col-md-6">
            <label for="lastname" class="pk-form-label" >Lastname</label>
            <input type="text" class="form-control pk-form-control" id="lastname" name="lastname" value="">
          </div>
          <div class="col-md-6">
            <label for="firstname" class="pk-form-label" >Firstname</label>
            <input type="text" class="form-control pk-form-control" id="firstname" name="firstname" value="">
          </div>

          <div class="col-md-6">
            <label for="email" class="pk-form-label" >Email</label>
            <input type="email" class="form-control pk-form-control" id="email" name="email" value="">
          </div>
          <div class="col-md-6">
            <label for="tel" class="pk-form-label" >Tel</label>
            <input type="tel" class="form-control pk-form-control" id="tel" name="tel" value="">
          </div>

          <div class="col-md-6">
            <label for="provenance" class="pk-form-label" >Provenance</label>
            <input type="text" class="form-control pk-form-control" id="provenance" name="provenance" value="">
          </div>
          <div class="col-md-6">
            <label for="destination" class="pk-form-label" >Destination</label>
            <input type="text" class="form-control pk-form-control" name="destination" id="destination" value="">
          </div>

          <div class="col-md-6">
            <label for="titre" class="pk-form-label" >Titre</label>
            <input type="text" class="form-control pk-form-control" id="titre" name="titre" value="">
          </div>
          <div class="col-md-6">
            <label for="cadre" class="pk-form-label" >Cadre de mission</label>
            <input type="text" class="form-control pk-form-control" id="cadre" name="cadre-mission" value="">
          </div>

          <div class="col-md-6">
            <label class="form-label" class="pk-form-label" >Echelle</label>
                <select class="form-select pk-form-select" name="echelle" size="3" aria-label="size 3 select example">
                    <option value="nationale" selected>Nationale</option>
                    <option value="internationale">Internationale</option>
                    <option value="africaine">Africaine</option>
                </select>   
          </div>
          <div class="col-md-6">
                <label class="form-label" class="pk-form-label" >Types</label>
                <select class="form-select pk-form-select" name="types" size="3" aria-label="size 3 select example">
                    <option value="entrant" selected>Entrant</option>
                    <option value="sortant">Sortant</option>
                </select>
          </div>

          <div class="col-6">
            <label for="compositon" class="form-label pk-form-label">Composition</label>
            <input type="text" class="form-control pk-form-control" name="composition" id="composition" placeholder="" value="">
          </div>
          <div class="col-6">
            <label for="departement" class="form-label pk-form-label">Département impliqué</label>
            <input type="text" class="form-control pk-form-control" name="departement" id="departement" placeholder="" value="">
          </div>

          <div class="col-md-6">
            <label for="debut" class="form-label pk-form-label">Debut mission</label>
            <input type="date" class="form-control pk-form-control" name="debut-mission" id="debut">
          </div>
          <div class="col-md-6">
            <label for="fin" class="form-label pk-form-label">Fin mission</label>
            <input type="date" class="form-control pk-form-control" name="fin-mission" id="fin">
          </div>

          <div class="col-md-12">
            <label for="observation" class="form-label pk-form-label">Observation</label>
            <textarea class="form-control pk-form-control" id="observation" name="observation" rows="3"></textarea>
          </div>

          <div class="col-md-12">
            <label for="image" class="form-label pk-form-label">Profil image</label>
            <input type="file" class="form-control pk-form-control" id="image" name="image" value="" require>
          </div>

          <div class="col-md-6">
            <label for="status" class="form-label pk-form-label">Status</label>
            <select class="form-select pk-form-select" name="status" aria-label="Default select example">
                <option value="realiser">Réaliser</option>
                <option value="encours">En cours</option>
                <option value="reporter">Réporter</option>
                <option value="autre">Autre</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="creatAt" class="form-label pk-form-label">Date Enregistrement</label>
            <input type="date" name="creatAt" class="form-control pk-form-control">
          </div>

          <div class="col-12">
            <button type="submit" class="btn pk-btn-success">VALIDER</button>
          </div>
        </form>
    </div>
</div>


<?php 
    $title = "Ajout";
    $username_auth = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    $user_profil = isset($_SESSION['user_profil']) ? $_SESSION['user_profil'] : "";
    $content = ob_get_clean();
    require_once "template.php";
?>