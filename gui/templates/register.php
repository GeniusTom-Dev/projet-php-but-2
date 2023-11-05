<body class="bg-[#EDE9FF] flex flex-col xl:flex-row justify-around items-center h-screen">
<img src="/gui/assets/logoecho.png" alt="logo echo" class="w-1/3 md:w-1/5">

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
        <div class="h-px w-full bg-[#e8eaed]"></div>
        <div class="flex w-4/5 md:w-2/3 xl:w-1/3 justify-between">
            <button><img src="/gui/assets/icons/google.svg" alt="google icons" class="w-8 h-8 rounded-full"></button>
            <button><img src="/gui/assets/icons/github.svg" alt="github icons" class="w-8 h-8 rounded-full"></button>
            <button><img src="/gui/assets/icons/linkedin.svg" alt="linkedin icons" class="w-8 h-8 rounded-full"></button>
        </div>
    </form>
    <script src="/gui/js/register.js"></script>
</body>