<?php 
    /**
     * Page d'erreur url
     * Elle permet d'afficher toute les attact par URL
     */
    ob_start();
?>

<h1 class="page-title"><?= $msg ?></h1>

<?php 
    $title = "Error";
    $username_auth = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    $user_profil = isset($_SESSION['user_profil']) ? $_SESSION['user_profil'] : "";
    $content = ob_get_clean();
    require_once "template.php";
?>