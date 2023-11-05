<?php
require "../GFramework/autoloader.php";
$email = $_POST['email'] ?? "";
if(empty($email) === false){
    if($dbUsers->isEmailAlreadyUsed($email)){
        require __DIR__. "/../../PHPMailer/src/Exception.php";
        require __DIR__. "/../../PHPMailer/src/PHPMailer.php";
        require __DIR__. "/../../PHPMailer/src/SMTP.php";

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        $token = bin2hex(random_bytes(32));

        $mail->isSMTP();
        $mail->Host = 'smtp-echo.alwaysdata.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'echo@alwaysdata.net';
        $mail->Password = 'aA97Rix8Ds*kXGw';
//        $mail->SMTPSecure = PHPMailer\PHPMailer\Exception::ENCRYPTION_STARTTLS;
        $mail->Port = 25;

        // Destinataires
        $mail->setFrom('echo@alwaysdata.net', 'Echo');
        $mail->addAddress($email);     // Ajoutez un destinataire

        // Contenu de l'e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Réinitialisation de votre mot de passe';
        $resetUrl = "https://echo.alwaysdata.net/view/resetpassword.php?token=$token";
        $mail->Body = <<<EOT
            <html>
            <head>
              <style>
                .reset-password-email {
                  color: #333;
                  font-family: Arial, sans-serif;
                  line-height: 1.8em;
                }
                .button {
                  padding: 10px 20px;
                  color: #fff;
                  background-color: #007bff;
                  display: inline-block;
                  text-decoration: none;
                  border-radius: 5px;
                  transition: background-color 0.3s ease-in-out;
                }
                .button:hover {
                  background-color: #0056b3;
                }
              </style>
            </head>
            <body>
              <div class="reset-password-email">
                <h2>Bonjour,</h2>
                <p>Vous avez demandé la réinitialisation de votre mot de passe. Veuillez cliquer sur le bouton ci-dessous pour définir un nouveau mot de passe.</p>
                <p><a href="$resetUrl" class="button">Réinitialiser mon mot de passe</a></p>
                <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, veuillez ignorer cet e-mail ou nous prévenir.</p>
                <p>Merci,</p>
                <p>Votre équipe de support</p>
                <img src="cid:unique@cid" alt="Logo" />
              </div>
            </body>
            </html>
            EOT;
        $mail->AddEmbeddedImage('../html/images/logoecho.png', 'unique@cid', 'echo.jpg');
        $mail->send();
        $dbUsers->createPasswordReloadToken($email, $token);
        unset($_POST["email"]);
        header("Location: homepage.php");
    }

}

require_once '../GFramework/utilities/utils.inc.php';
start_page("Connection");
?>
    <section class="bg-[#EDE9FF] flex flex-col xl:flex-row justify-around items-center h-screen w-screen">
        <img src="/html/images/logoecho.png" alt="logo echo" class="w-2/3 md:w-2/5 xl:w-1/5">

        <form class="w-4/5 xl:w-1/3 flex flex-col items-center space-y-4" method="post">
            <h1 class="text-[#b2a5ff] text-2xl">Réinitialiser le mot de passe</h1>

            <input name="email" type="text" placeholder="Email" class="w-full rounded-md text-lg outline-none border-2 p-1" value="">

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