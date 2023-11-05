<?php
require "../GFramework/autoloader.php";
$email = $_POST['email'] ?? "";
$login = $_POST['login'] ?? "";
$password = $_POST['password'] ?? "";
$passwordConfirm = $_POST['passwordConfirm'] ?? "";
function validatePassword(string $password): bool{
    if (strlen($password) < 6) {
        return false;
    }

    if (preg_match('/[a-zA-Z]/', $password)=== false) {
        return false;
    }

    if (preg_match('/[0-9]/', $password) === false) {
        return false;
    }

    return true;
}

if (empty($email) === false && empty($login) === false && empty($password) === false && empty($passwordConfirm) === false) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        $errors["email"] = "L'adresse mail n'est pas au bon format.";
    }else{
        if($dbUsers->isEmailAlreadyUsed($email)){
            $errors["email"] = "Cette adresse mail est déjà utilisé.";
        }
    }

    if($dbUsers->isUsernameAlreadyUsed($login)){
        $errors["login"] = "Ce nom d'utilisateur est déjà utilisé.";
    }

    if(validatePassword($password) === false){
        $errors["password"] = "Le mot de passe doit contenir 1 lettre, 1 chiffre, 6 caractères.";
    }

    if($password !== $passwordConfirm){
        $errors["passwordConfirm"] = "Les mots de passe ne correspondent pas.";
    }

    if(empty($errors)){
        $password = password_hash($password, PASSWORD_BCRYPT);
        $dbUsers->addUser($login, $email, $password);
        $userId = $dbUsers->getUserIDFromLogin($email, "email");
        $idAdmin = $dbUsers->isAdminFromId($userId);
        session_start();
        $_SESSION["suid"] = $userId;
        $_SESSION["isAdmin"] = $idAdmin;
        header("Location: homepage.php");
    }
}


require_once '../GFramework/utilities/utils.inc.php';
start_page("Inscription");

?>
<section class="bg-[#EDE9FF] flex flex-col xl:flex-row justify-around items-center h-screen w-screen">
<img src="/html/images/logoecho.png" alt="logo echo" class="w-1/3 md:w-1/5">

    <form class="w-4/5 xl:w-1/3 flex flex-col items-center space-y-4" method="post">
        <h1 class="text-[#b2a5ff] text-2xl">Inscription</h1>
        <input name="email" type="text" placeholder="Email" class="w-full rounded-md text-lg outline-none border-2 p-1">
        <input name="login" type="text" placeholder="Nom d'utilisateur" class="w-full rounded-md text-lg outline-none border-2 p-1">
        <input name="password" type="password" id="mainPasswordInput" placeholder="Password" class="w-full rounded-md text-lg outline-none border-2 p-1">
        <input name="passwordConfirm" type="password" placeholder="Confirmer le mot de passe" class="w-full rounded-md text-lg outline-none border-2 p-1">
        <p class="mr-auto" id="passwordStrengthText">Complexitée du mot de passe :</p>
        <div class="w-full h-3 rounded-md border-2 flex">
            <div class="tick border-r-2 w-1/4 h-full rounded-l-md"></div>
            <div class="tick border-r-2 w-1/4 h-full"></div>
            <div class="tick border-r-2 w-1/4 h-full"></div>
            <div class="tick border-r-2 w-1/4 h-full rounded-r-md"></div>
        </div>
        <button class="border-none bg-transparent mr-auto"><a href="login.php">Vous avez déjà un compte ?</a></button>
        <button class="bg-[#b2a5ff] p-2 w-full rounded-md">Inscription</button>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <script src="/html/script/register.js"></script>
</section>

<?php
end_page();
?>