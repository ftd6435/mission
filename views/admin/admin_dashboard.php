<?php 
    /**
     * Dashboard Admin ou tableau de bord des administrateur
     * Elle permet d'afficher toute les caractéristique a propos des administrateur
     */

    $i = 1;
    ob_start();
?>

<h1 class="page-title">BIENVENU DANS LE DASHBOARD UTILISATEUR</h1>

<a class="btn btn-primary mt-5 px-4 py-3 pk-btn-add" href="<?= URL ?>admin-dashboard/a-add">Add User</a>

<div class="row">
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Nombre total d'utilisateur</h5>
        <p class="card-text"><?= (is_countable($userss)) ? count($userss) : 0 ?></p>
      </div>
    </div>
  </div>
</div>

<form action="admin-dashboard" class="row" style="text-align: center;" method="POST">
    <div class="col-md-6 offset-md-3">
        <input type="search" name="q" class="pk-search-control" placeholder="Rechercher">
        <input type="submit" class="pk-search-submit" value="Search">
    </div>
</form>

<div class="row my-5">
    <div class="col-md-12">
        <?php if(isset($_SESSION['add-u-success'])) : ?>
            <div class="alert alert-success"><?= $_SESSION['add-u-success'] ?></div>
        <?php 
          unset($_SESSION['add-u-success']);
          endif; 
        ?>

        <?php if(isset($_SESSION['update-u-success'])) : ?>
            <div class="alert alert-success"><?= $_SESSION['update-u-success'] ?></div>
        <?php 
          unset($_SESSION['update-u-success']);
          endif; 
        ?>

        <?php if(isset($_SESSION['delete-u-success'])) : ?>
            <div class="alert alert-success"><?= $_SESSION['delete-u-success'] ?></div>
        <?php 
          unset($_SESSION['delete-u-success']);
          endif; 
        ?>

        <?php if(!is_countable($userss)) : ?>
            <div class="alert alert-danger">Il n'est possible de rechercher que par le nom, prénom et username</div>
        <?php endif; ?> 

        <table class="table pk-table">
        <thead class="table-dark">
            <tr>
                <td>N°</td>
                <td>Profil</td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Username</td>
                <td>Email</td>
                <td colspan="2">Action</td>
            </tr>
        </thead>
        <tbody>
        <?php if(is_countable($userss)) : ?>
            <?php foreach($userss as $user): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><img src="<?= URL ?>public/images/<?= $user->getProfilAdmin() ?>" alt="profil" width="80px" height="80px"></td>
                    <td><?= $user->getLastnameAdmin() ?></td>
                    <td><?= $user->getFirstnameAdmin() ?></td>
                    <td><?= $user->getUsernameAdmin() ?></td>
                    <td><?= $user->getEmailAdmin() ?></td>
                    <td><a href="<?= URL ?>admin-dashboard/a-update/<?= $user->getIdAdmin() ?>" class="btn btn-warning">Edit</a></td>
                    <td><a onclick="return confirm('Voulez-vous vraiment supprimer ce utilisateur ?');" href="<?= URL ?>admin-dashboard/a-delete/<?= $user->getIdAdmin() ?>" class="btn btn-danger">Delete</a></td>
                </tr>
            <?php endforeach ?>
          <?php endif ?>
        </tbody>
        </table>
    </div>
</div>


<?php 
    $title = "Admin dashboard";
    $username_auth = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    $user_profil = isset($_SESSION['user_profil']) ? $_SESSION['user_profil'] : "";
    $content = ob_get_clean();
    require_once "views/template.php";
?>