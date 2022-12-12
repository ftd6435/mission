<?php 
    /**
     * Page d'acceuil
     * Elle permet a l'utilisateur de s'authentifié
     * Pour avoir accès aux données
     */
    ob_start();
?>

<h1 class="page-title">Bienvenu dans la page d'authentification</h1>

<div class="row my-5">
    <div class="col-md-6 offset-md-3">
        <?php if(isset($_SESSION['auth_error'])) : ?>
            <div class="alert alert-danger"><?= $_SESSION['auth_error'] ?></div>
        <?php 
          unset($_SESSION['auth_error']);
          endif; 
        ?>
        <form class="row g-3" class="auth-form" action="<?= URL ?>auth" method="POST">
          <div class="col-md-12">
            <label for="username" class="form-label pk-form-label">Username</label>
            <input type="text" class="form-control pk-form-control" id="username" name="username" placeholder="Username">
          </div>

          <div class="col-md-12">
            <label for="password" class="form-label pk-form-label">Password</label>
            <input type="password" class="form-control pk-form-control" id="password" name="password" placeholder="Password">
          </div>

          <div class="col-12">
            <button type="submit" class="btn pk-btn-success">Connecter</button>
          </div>
        </form>
    </div>
</div>

<?php 
    $title = "Authentification";
    $username_auth = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    $user_profil = isset($_SESSION['user_profil']) ? $_SESSION['user_profil'] : "";
    $content = ob_get_clean();
    require_once "template.php";
?>