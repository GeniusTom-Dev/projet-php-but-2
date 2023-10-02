<?php
$conn = mysqli_connect('localhost','root','')
    or die('Pb de connexion au serveur: ' . mysqli_connect_error());
mysqli_select_db($conn, 'php-proj') or die ('Pb de sélection BD : ' . mysqli_error($conn));
?>

