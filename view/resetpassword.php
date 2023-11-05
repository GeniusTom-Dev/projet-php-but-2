<?php
require "../GFramework/autoloader.php";
$token = $_GET['token'] ?? "";
$email = $_POST['email'] ?? "";
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

if(empty($token) === false){
    if(empty($email) === false && empty($password) === false && empty($passwordConfirm) === false){
        $data = $dbUsers->getPasswordReloadToken($token);
        if($data["USER_EMAIL"] === $email && validatePassword($password) && $password === $passwordConfirm && $data["EXPIRE_DATE"] > date("Y-m-d H:i:s")){
            $password = password_hash($password, PASSWORD_BCRYPT);
            $dbUsers->deletePasswordReloadToken($token);
            $dbUsers->updatePassword($email, $password);
            header("Location: login.php");
        }else if($data["EXPIRE_DATE"] < date("Y-m-d H:i:s")){
            $dbUsers->deletePasswordReloadToken($token);
        }
    }

}

require_once '../GFramework/utilities/utils.inc.php';
start_page("Connection");
?>
    <section class="bg-[#EDE9FF] flex flex-col xl:flex-row justify-around items-center h-screen w-screen">
        <img src="/html/images/logoecho.png" alt="logo echo" class="w-2/3 md:w-2/5 xl:w-1/5">

        <form class="w-4/5 xl:w-1/3 flex flex-col items-center space-y-4" method="post">
            <h1 class="text-[#b2a5ff] text-2xl">Réinitialiser le mot de passe</h1>

            <input name="email" type="text" placeholder="Email" class="w-full rounded-md text-lg outline-none border-2 p-1">
            <input name="password" type="password" placeholder="Password" class="w-full rounded-md text-lg outline-none border-2 p-1">
            <input name="passwordConfirm" type="password" placeholder="Password Confirm" class="w-full rounded-md text-lg outline-none border-2 p-1">

            <div class="w-full flex justify-between">
                <button class="border-none bg-transparent"><a href="login.php">Connection</a></button>
                <button class="border-none bg-transparent"><a href="register.php">Inscription</a></button>
            </div>

            <button class="bg-[#b2a5ff] p-2 w-full rounded-md">Réinitialiser le mot de passe</button>
        </form>
    </section>

<?php
end_page();
?>