<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- link fontawesome  -->
    <script src="https://kit.fontawesome.com/b91affedee.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- personal css style sheet -->
    <link rel="stylesheet" href="<?= URL ?>views/css/style.css" type="text/css" />

    <title><?= $title ?> || By : Pathé PK Diallo</title>
</head>
<body>
    <header class="header">
        <nav class="pk-navbar">
            <div class="profil-user">
                <span class="profil-img">
                    <?php if(isset($user_profil) && !empty($user_profil)): ?>
                        <img src="<?= URL ?>public/images/<?= $user_profil ?>" alt="profil">
                    <?php endif ?>
                </span>
                <?php if(isset($username_auth) && !empty($username_auth)): ?>
                    <span class="profil-username"><?= $username_auth ?></span>
                <?php endif ?>
            </div>

            <ul class="pk-nav-links">
                <li class="pk-nav-item"><a class="pk-nav-link" href="<?= URL ?>dashboard">Dashboard</a></li>
                <li class="pk-nav-item"><a class="pk-nav-link" href="<?= URL ?>admin-dashboard">Gestion user</a></li>
                <?php if(isset($username_auth) && !empty($username_auth)): ?>
                    <li class="pk-nav-item"><a class="pk-nav-link" href="<?= URL ?>disconnect">Deconnexion</a></li>
                <?php endif ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <?= $content ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>