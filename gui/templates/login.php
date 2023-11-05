<body class="bg-[#EDE9FF] flex flex-col xl:flex-row justify-around items-center h-screen">
  <img src="/gui/assets/logoecho.png" alt="logo echo" class="w-2/3 md:w-2/5 xl:w-1/5">

  <form class="w-4/5 xl:w-1/3 flex flex-col items-center space-y-4" method="post">
    <h1 class="text-[#b2a5ff] text-2xl">Connection</h1>

    <input name="login" type="text" placeholder="Email" class="w-full rounded-md text-lg outline-none border-2 p-1">
    <input name="password" type="password" placeholder="Password" class="w-full rounded-md text-lg outline-none border-2 p-1">

    <div class="w-full flex justify-between">
      <button class="border-none bg-transparent"><a href="forgetPassword">Mot de passe oublié ?</a></button>
      <button class="border-none bg-transparent"><a href="register">Inscription</a></button>
    </div>

    <button class="bg-[#b2a5ff] p-2 w-full rounded-md">Connection</button>

    <div class="h-px w-full bg-[#e8eaed]"></div>
  </form>
</body>