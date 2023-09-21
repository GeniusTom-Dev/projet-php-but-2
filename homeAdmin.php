<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test du PHP</title>
</head>
<body>
    <header></header>
    <?php require 'views/nav-admin.php';?>
    <?php require 'autoloads/autoloader.php';?>
    <section>
        <?php homeReload();?>
    </section>
</body>
</html>