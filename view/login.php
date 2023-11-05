<?php
require "../GFramework/autoloader.php";
$login = $_POST['login'] ?? "";
$password = $_POST['password'] ?? "";
if (empty($login) === false && empty($password) === false) {
    if(filter_var($login, FILTER_VALIDATE_EMAIL)){
        if($dbUsers->isEmailAlreadyUsed($login)){
            $typeConnection = "email";
            $savedPassword = $dbUsers->getPasswordFromLogin($login, $typeConnection);
        }
    }else{
        if($dbUsers->isUsernameAlreadyUsed($login)){
            $typeConnection = "login";
            $savedPassword = $dbUsers->getPasswordFromLogin($login, $typeConnection);
        }
    }



    if(empty($password) === false && empty($savedPassword) === false){
        if(password_verify($password, $savedPassword)){
            $userId = $dbUsers->getUserIDFromLogin($login, $typeConnection);
            $idAdmin = $dbUsers->isAdminFromId($userId);
            $_SESSION["suid"] = $userId;
            $_SESSION["isAdmin"] = $idAdmin;
            header("Location: homepage.php");
        }
    }



}
require_once '../GFramework/utilities/utils.inc.php';
start_page("Profil Utilisateur");

?>
<section class="bg-[#EDE9FF] flex flex-col xl:flex-row justify-around items-center h-screen w-screen">
<img src="/html/images/logoecho.png" alt="logo echo" class="w-2/3 md:w-2/5 xl:w-1/5">

<form class="w-4/5 xl:w-1/3 flex flex-col items-center space-y-4" method="post">
    <h1 class="text-[#b2a5ff] text-2xl">Connection</h1>

    <input name="login" type="text" placeholder="Email" class="w-full rounded-md text-lg outline-none border-2 p-1">
    <input name="password" type="password" placeholder="Password" class="w-full rounded-md text-lg outline-none border-2 p-1">

    <div class="w-full flex justify-between">
        <button class="border-none bg-transparent text-[#b2a5ff]">Mot de passe oublié ?</button>
        <button class="border-none bg-transparent"><a href="register.php">Inscription</a></button>
    </div>

    <button class="bg-[#b2a5ff] p-2 w-full rounded-md">Connection</button>
</form>
</section>

<?php
end_page();
?>