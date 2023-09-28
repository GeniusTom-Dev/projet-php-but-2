<?php
require("database/db.php");
require("database/dbStock.php");
require("database/dbUsers.php");
require ("utilities/GReturn.php");

$db = new \GFramework\database\db();
$db = $db->getConnection()->getContent();

// ** Permission ** \\
