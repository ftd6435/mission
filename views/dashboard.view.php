<?php 
    /**
     * Dashboard ou tableau de bord
     * Elle permet d'afficher toutes les caractéristique a propos des missionaire
     */
 
    $i = 1;
    // $pages = ceil(count($missionaires)/PAR_PAGE);
    // $page = $_SESSION['c_page'];
    ob_start();
?>

<h1 class="page-title">Bienvenu dans le dashboard principal</h1>

<a class="btn btn-primary mt-5 px-4 py-3 pk-btn-add" href="<?= URL ?>dashboard/add">Ajouter</a>

<div class="row">
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Nombre total de missionaire</h5>
        <p class="card-text"><?= $reqTotal ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Nombre de mission encours</h5>
        <p class="card-text"><?= $reqEncours ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Nombre de mission réaliser</h5>
        <p class="card-text"><?= $reqRealiser ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Nombre de mission réporter</h5>
        <p class="card-text"><?= $reqReporter ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Nombre de missionaire entrant</h5>
        <p class="card-text"><?= $reqEntrant ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Nombre de missionaire sortant</h5>
        <p class="card-text"><?= $reqSortant ?></p>
      </div>
    </div>
  </div>
</div>

<!-- formulaire de recherche  -->
<form action="dashboard" class="row" style="text-align: center;" method="POST">
    <div class="col-md-6 offset-md-3">
        <input type="search" name="q" class="pk-search-control" placeholder="Rechercher">
        <input type="submit" class="pk-search-submit" value="Search">
    </div>
</form>

<div class="row my-5">
    <div class="col-md-12">

        <?php if(isset($_SESSION['add_mis_success'])) : ?>
            <div class="alert alert-success"><?= $_SESSION['add_mis_success'] ?></div>
        <?php 
          unset($_SESSION['add_mis_success']);
          endif; 
        ?>

        <?php if(isset($_SESSION['delete_m_success'])) : ?>
            <div class="alert alert-success"><?= $_SESSION['delete_m_success'] ?></div>
        <?php 
          unset($_SESSION['delete_m_success']);
          endif; 
        ?>

        <?php if(isset($_SESSION['update-mis-success'])) : ?>
            <div class="alert alert-success"><?= $_SESSION['update-mis-success'] ?></div>
        <?php 
          unset($_SESSION['update-mis-success']);
          endif; 
        ?>

        <?php if(!is_countable($missionaires)) : ?>
            <div class="alert alert-danger">Il n'est possible de rechercher que par le status(encours, realiser, reporter), echelle(national, international, africain) et types(sortant, entrant) !</div>
        <?php endif; ?>          

        <table class="table pk-table">
        <thead class="table-dark">
            <tr>
                <td>N°</td>
                <td>Profil</td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Intitulé Missionaire</td>
                <td colspan="3">Action</td>
            </tr>
        </thead>
        <tbody>
          <?php if(is_countable($missionaires)) : ?>
            <?php foreach($missionaires as $mission): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><img src="<?= URL ?>public/images/<?= $mission->getProfil() ?>" alt="profil" width="80px" height="80px"></td>
                    <td><?= $mission->getLastname() ?></td>
                    <td><?= $mission->getFirstname() ?></td>
                    <td><?= $mission->getTitle() ?></td>
                    <td><a href="<?= URL ?>dashboard/single-page/<?= $mission->getId() ?>" class="btn btn-secondary">See more</a></td>
                    <td><a href="<?= URL ?>dashboard/update/<?= $mission->getId() ?>" class="btn btn-warning">Edit</a></td>
                    <td><a onclick="return confirm('Voulez-vous vraiment supprimer ce missionaire ?');" href="<?= URL ?>dashboard/delete/<?= $mission->getId() ?>" class="btn btn-danger">Delete</a></td>
                </tr>
            <?php endforeach ?>
          <?php endif ?>
        </tbody>
        </table>
        </div>
        <!-- <div class="col-md-12">
          <div class="d-flex space-between">
            <?php if($pages >= $page && $page > 1) : ?>
              <a href="<?= URL ?>dashboard/p/<?= $page - 1 ?>" class="btn btn-primary mt-5 mx-4 px-4 py-3 pk-btn-add">Précédent</a>
            <?php endif ?>
            <?php if($pages > $page) : ?>
              <a href="<?= URL ?>dashboard/p/<?= $page + 1 ?>" class="btn btn-primary mt-5 mx-4 px-4 py-3 pk-btn-add">Suivant</a>
            <?php endif ?>
          </div>
        </div> -->
</div>


<?php 
    $title = "Dashboard";
    $username_auth = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    $user_profil = isset($_SESSION['user_profil']) ? $_SESSION['user_profil'] : "";
    $content = ob_get_clean();
    require_once "template.php";
?>