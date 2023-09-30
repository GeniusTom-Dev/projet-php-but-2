<?php
session_start();
$_SESSION['suid'] = session_id();
$_SESSION['user'] = 'Utilisateur 1';
$_SESSION['admin'] = true;
if (isset($_SESSION['suid']) && $_SESSION['admin'] == true){
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test du PHP</title>
</head>
<body>
    <header></header>
    <?php require_once 'views/nav-admin.php';?>
    <?php
//    require 'GFramework/autoloader.php';
    require_once 'autoloads/adminAutoloader.php';?>
    <?php echo '<p>', $_SERVER['REQUEST_URI'], '</p>'; ?>
    <section>
        <?php homeReload();?>
    </section>
</body>
</html>
<?php
}
?>