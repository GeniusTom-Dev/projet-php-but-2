<?php
$link = "https://i.imgur.com/OqEMiMF.png"; // replace by USER.PROFIL_PIC
$username = "jsp"; // replace by USER.USERNAME
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carré avec une image</title>
    <style>
        .carre {
            width: 100px;
            height: 100px;
            border: 1px solid #000;
        }
    </style>
</head>
<body>
<div class="carre">
    <img src="<?php echo $link ?>" alt="Photo de profil de l'utilisateur <?php echo $username ?>">
</body>
</html>