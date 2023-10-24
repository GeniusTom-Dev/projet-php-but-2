<?php
include "../../../GFramework/autoloader.php";
require __ROOT__. '/GFramework/functions/validatePassword.php';

if(isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"])){
    $dbUsers = new DbUsers($dbConn);

    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        $emailError = "L'adresse mail n'est pas au bon format.";
    }else{
        if($dbUsers->isEmailAlreadyUsed($email)){
            $email = "Mail déjà utilisé.";
        }
    }

    if($dbUsers->isUsernameAlreadyUsed($username)){
        $usernameError = "Nom d'utilisateur déjà utilisé.";
    }

    if(validatePassword($password) === false){
        $passwordError = "Requis: 1 lettre, 1 chiffre, 6 caractère.";
    }

    if($password !== $confirmPassword){
        $confirmPasswordError = "Les mots de passe ne correspondent pas.";
    }


}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <title>Register | Echo</title>
</head>
<!--bg-[#EDE9FF]-->
<body class="flex flex-col  xl:flex-row xl:justify-around items-center h-screen ">
<img src="/assets/echo.png" alt="logo echo" class="w-4/5 xl:w-1/3">

<form class="w-4/5 xl:w-1/3 flex flex-col items-center space-y-4" method="post">
    <h1 class="text-[#b2a5ff] text-2xl">Inscription</h1>
    <input name="email" type="text" placeholder="Email" class="w-full rounded-md text-lg outline-none border-2 p-1">
    <input name="username" type="text" placeholder="Nom d'utilisateur" class="w-full rounded-md text-lg outline-none border-2 p-1">
    <input name="password" type="password" id="mainPasswordInput" placeholder="Password" class="w-full rounded-md text-lg outline-none border-2 p-1">
    <input name="confirmPassword" type="password" placeholder="Confirmer le mot de passe" class="w-full rounded-md text-lg outline-none border-2 p-1">
    <p class="mr-auto" id="passwordStrengthText">Complexitée du mot de passe :</p>
    <div class="w-full h-3 rounded-md border-2 flex">
        <div class="tick border-r-2 w-1/4 h-full rounded-l-md"></div>
        <div class="tick border-r-2 w-1/4 h-full"></div>
        <div class="tick border-r-2 w-1/4 h-full"></div>
        <div class="tick border-r-2 w-1/4 h-full rounded-r-md"></div>
    </div>
    <button class="border-none bg-transparent mr-auto"><a href="login.php">Vous avez déjà un compte ?</a></button>
    <button class="bg-[#b2a5ff] p-2 w-full rounded-md">Inscription</button>
    <div class="h-px w-full bg-[#e8eaed]"></div>
    <div class="flex w-4/5 md:w-2/3 xl:w-1/3 justify-between">
        <button><img src="/assets/icons/google.png" alt="google icons" class="w-8 h-8 rounded-full"></button>
        <button><img src="/assets/icons/github.png" alt="github icons" class="w-8 h-8 rounded-full"></button>
        <button><img src="/assets/icons/linkedin.png" alt="linkedin icons" class="w-8 h-8 rounded-full"></button>
    </div>
</form>
<script src="../../scripts/admin/register.js"></script>
</body>
</html>