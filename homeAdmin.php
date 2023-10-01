<?php
session_start();
$_SESSION['suid'] = session_id();
$_SESSION['user'] = 'Utilisateur 1';
$_SESSION['admin'] = true;
if (isset($_SESSION['suid']) && $_SESSION['admin'] == true){
    require_once 'autoloads/adminAutoloader.php';
    checkTab();
    checkSort();
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
    <section>
        <?php homeReload();?>
    </section>
</body>
</html>
<?php
}
?>