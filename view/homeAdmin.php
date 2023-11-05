<?php
session_start();


//unset($_SESSION['isAdmin']);
if (! (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'])){
    header('Location: homepage.php');
    die();
}
else {
    require_once '../autoloads/adminAutoloader.php';
    checkTab();
    checkSort();
    checkSearchAdmin();
    checkPage();

    require_once '../GFramework/utilities/utils.inc.php';
    start_page("Gestion Admin");
    require_once "enTete.php";
?>

<div class=" h-screen w-64 fixed left-0">
    <?php require 'admin_views/nav-admin.php';?>
</div>
    

    <section class="h-screen w-full center flex flex-col items-center">
        <?php homeReload();?>
    </section>
</body>
</html>
<?php
}
?>