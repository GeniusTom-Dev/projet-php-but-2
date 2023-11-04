<?php
session_start();
$_SESSION['suid'] = session_id();
$_SESSION['userid'] = 1;
$_SESSION['isAdmin'] = true;
//unset($_SESSION['isAdmin']);
if (! (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'])){
    header('Location: homepage.php');
    die();
}
else {
    require_once '../autoloads/adminAutoloader.php';
    checkTab();
    checkSort();
    checkSearch();
    checkPage();

    require_once '../GFramework/utilities/utils.inc.php';
    start_page("Gestion Admin");
?>

    <header class="flex flex-lign items-center mb-2 bg-purple-800 p-2">
        <div class="w-100 h-100">
            <img src="/projet-php-but-2/html/images/profile-removebg-preview.png" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">
        </div>
    </header>

    <?php require 'admin_views/nav-admin.php';?>

    <section>
        <?php homeReload();?>
    </section>
</body>
</html>
<?php
}
?>