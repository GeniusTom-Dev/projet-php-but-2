<?php
if(empty($_POST["email"])){

    $bddUsers = new \GFramework\database\DbUsers();
    $userExist = $bddUsers->isEmailAlreadyUsed($_POST["email"]);
    if($userExist){
        require __RACINE__ . '/PHPMailer/src/Exception.php';
        require __RACINE__ . '/PHPMailer/src/PHPMailer.php';
        require __RACINE__ . '/PHPMailer/src/SMTP.php';


        $mail = new PHPMailer\PHPMailer\PHPMailer(true);


        // Configuration du serveur
        $mail->isSMTP();
        $mail->Host = 'smtp-echo.alwaysdata.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'echo@alwaysdata.net';
        $mail->Password = 'aA97Rix8Ds*kXGw';
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 25;

        // Destinataires
        $mail->setFrom('echo@alwaysdata.net', 'Echo');
        $mail->addAddress($_POST["email"], 'Even Tom');     // Ajoutez un destinataire

        // Contenu de l'e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Sujet de l\'email';
        $mail->Body    = 'Ceci est le contenu HTML de l\'email <b>en gras !</b>';
        $mail->AltBody = 'Ceci est le corps en texte brut pour les clients de messagerie non HTML';

//    $mail->send();
            unset($mail);
    }

}

?>
<body class="bg-[#EDE9FF] flex flex-col xl:flex-row justify-around items-center h-screen">
<img src="/gui/assets/logoecho.png" alt="logo echo" class="w-2/3 md:w-2/5 xl:w-1/5">

<form class="w-4/5 xl:w-1/3 flex flex-col items-center space-y-4" method="post">
    <h1 class="text-[#b2a5ff] text-2xl">Connection</h1>

    <input name="email" type="text" placeholder="Email" class="w-full rounded-md text-lg outline-none border-2 p-1">

    <div class="w-full flex justify-between">
        <button class="border-none bg-transparent"><a href="register">Inscription</a></button>
        <button class="border-none bg-transparent"><a href="login">Connection</a></button>
    </div>

    <button class="bg-[#b2a5ff] p-2 w-full rounded-md">Réinitialiser le mot de passe</button>

    <div class="h-px w-full bg-[#e8eaed]"></div>
</form>
</body>