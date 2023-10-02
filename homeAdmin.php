<?php
session_start();
$_SESSION['suid'] = session_id();
$_SESSION['user'] = 'Utilisateur 1';
$_SESSION['admin'] = true;
if (isset($_SESSION['suid']) && $_SESSION['admin'] == true){
    require_once 'autoloads/adminAutoloader.php';
    checkTab();
    checkSort();

    // Système de conservation d'élément de GET précédents qui n'ont pas été envoyés via la nouvelle requête mais sont présents et doivent être mentionnés.
    if(http_build_query($_GET) == ''){
        $url = '/projet-php-but-2/homeAdmin.php';
        if($_SERVER['REQUEST_URI'] != $url){
            header('Location: ' . $url);
        }
    }
    else {
        $url = '/projet-php-but-2/homeAdmin.php?' . http_build_query($_GET);
        if($_SERVER['REQUEST_URI'] != $url){
            header('Location: ' . $url);
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Admin</title>
</head>
<body>
    <header></header>
    <?php require 'views/nav-admin.php';?>
    <?php echo '<p>', $_SERVER['REQUEST_URI'], '</p>'; ?>
    <?php echo '<p>', http_build_query($_GET), '</p>'; ?>
<!--    --><?php //$_SERVER['REQUEST_URI'] = '/projet-php-but-2/homeAdmin.php?' . http_build_query($_GET); ?>
<!--    --><?php //echo '<p>', $_SERVER['REQUEST_URI'], '</p>'; ?>
    <section>
        <?php homeReload();?>
    </section>
</body>
</html>
<?php
}
?>