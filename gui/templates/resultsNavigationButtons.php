<div class="flex flex-lign items-center mb-4">
    <div class="flex flex-lign items-center mb-4">
        <div>
            <form method="get">
                <button name="page" <?php if (!isset($_GET['pageNb']) || $_GET['pageNb'] == 1) echo "disabled" ?>
                        value="<?= empty($_GET["pageNb"]) === false ? $_GET["pageNb"] - 1 : 1; ?>"
                        class="bg-purple-500 text-white p-2 rounded-md hover:bg-purple-700 mr-2 disabled:bg-gray-500 disabled:cursor-not-allowed">
                    Page précédente
                </button>
            </form>
        </div>
        <div>
            <form method="get">
                <button name="page" <?php if (!isset($_GET['pageNb']) || $_GET['pageNb'] == $max) echo "disabled" ?>
                        value="<?= empty($_GET["pageNb"]) === false ? $_GET["pageNb"] + 1 : 1; ?>"
                        class="bg-purple-500 text-white p-2 rounded-md hover:bg-purple-700 disabled:bg-gray-500 disabled:cursor-not-allowed">
                    Page suivante
                </button>
            </form>
        </div>
    </div>
</div>