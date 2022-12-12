<?php 
    /**
     * Page d'ajout d'utilisateur
     * Elle permet l'utilisateur connecter d'ajouter un missionaire
     */
    ob_start();
?>

<h1 class="page-title">Bienvenu dans la page d'ajout admin</h1>

<a class="btn btn-primary mt-5 px-4 py-3 pk-btn-add" href="<?= URL ?>admin-dashboard">Retour</a>

<div class="row my-5">
    <div class="col-md-6 offset-md-3">
        <?php if(isset($_SESSION['add-user'])) : ?>
            <div class="alert alert-danger"><?= $_SESSION['add-user'] ?></div>
        <?php 
          unset($_SESSION['add-user']);
          endif; 
        ?>
        <form class="row g-3" action="<?= URL ?>admin-dashboard/v-addAmin" method="POST" enctype="multipart/form-data">
          
          <div class="col-md-12">
            <label for="lastname" class="form-label pk-form-label">Nom</label>
            <input type="text" class="form-control pk-form-control" id="lastname" name="lastname" value="" require>
          </div>
          <div class="col-md-12">
            <label for="firstname" class="form-label pk-form-label">Prénom</label>
            <input type="text" class="form-control pk-form-control" id="firstname" name="firstname" value="" require>
          </div>
          <div class="col-md-12">
            <label for="username" class="form-label pk-form-label">Username</label>
            <input type="text" class="form-control pk-form-control" id="username" name="username" value="" require>
          </div>

          <div class="col-md-12">
            <label for="email" class="form-label pk-form-label">Email</label>
            <input type="email" class="form-control pk-form-control" id="email" name="email" value="" require>
          </div>

          <div class="col-md-12">
            <label for="image" class="form-label pk-form-label">Profil image</label>
            <input type="file" class="form-control pk-form-control" id="image" name="image" value="" require>
          </div>

          <div class="col-md-12">
            <label for="password" class="form-label pk-form-label">Password</label>
            <input type="password" class="form-control pk-form-control" id="password" name="password" value="" require>
          </div>

          <div class="col-12">
            <button type="submit" class="btn pk-btn-success">Valider</button>
          </div>
        </form>
    </div>
</div>

<?php 
    $title = "Ajout Admin";
    $username_auth = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    $user_profil = isset($_SESSION['user_profil']) ? $_SESSION['user_profil'] : "";
    $content = ob_get_clean();
    require_once "views/template.php";
?>