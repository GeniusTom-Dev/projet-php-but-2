<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register | Echo</title>
</head>
<!--bg-[#EDE9FF]-->
<body class="flex flex-col  xl:flex-row xl:justify-around items-center h-screen ">
<img src="/assets/echo.png" alt="logo echo" class="w-4/5 xl:w-1/3">

<form class="w-4/5 xl:w-1/3 flex flex-col items-center space-y-4" method="post">
    <h1 class="text-[#b2a5ff] text-2xl">Inscription</h1>
    <input name="email" type="text" placeholder="Email" class="w-full rounded-md text-lg outline-none border-2 p-1">
    <input name="username" type="text" placeholder="Nom d'utilisateur" class="w-full rounded-md text-lg outline-none border-2 p-1">
    <input type="password" placeholder="Password" class="w-full rounded-md text-lg outline-none border-2 p-1">
    <input type="password" placeholder="Confirmer le mot de passe" class="w-full rounded-md text-lg outline-none border-2 p-1">
    <button class="border-none bg-transparent mr-auto"><a href="login.php">Vous avez déjà un compte ?</a></button>
    <button class="bg-[#b2a5ff] p-2 w-full rounded-md">Inscription</button>
    <div class="h-px w-full bg-[#e8eaed]"></div>
    <div class="flex w-4/5 md:w-2/3 xl:w-1/3 justify-between">
        <button><img src="/assets/icons/google.png" alt="google icons" class="w-8 h-8 rounded-full"></button>
        <button><img src="/assets/icons/github.png" alt="github icons" class="w-8 h-8 rounded-full"></button>
        <button><img src="/assets/icons/linkedin.png" alt="linkedin icons" class="w-8 h-8 rounded-full"></button>
    </div>
</form>
</body>
</html>