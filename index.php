<?php
// Init


$layout = new \gui\Layout();

// Récupération de la page actuelle:
$page = $_GET['page'] ?? '';
$id = $_GET['id'] ?? '';

$structure = file_get_contents("structure.json");
$structure = json_decode($structure);

if(empty($page) === false || $page !== "/"){

}