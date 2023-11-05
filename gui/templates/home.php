<div class="flex flex-col items-center mb-8">
    <div class="flex flex-lign items-center mb-4">
        <div class="flex flex-lign items-center mb-4">
            <div>
                <form method="get">
                    <button name="page" <?php if ($_GET['page'] == 1) echo "disabled" ?>
                            value="<?= $_GET['page'] - 1 ?>"
                            class="bg-purple-500 text-white p-2 rounded-md hover:bg-purple-700 mr-2 disabled:bg-gray-500 disabled:cursor-not-allowed">
                        Page précédente
                    </button>
                </form>
            </div>
            <div>
                <form method="get">
                    <button name="page" <?php if ($_GET['page'] == $max) echo "disabled" ?>
                            value="<?= $_GET['page'] + 1 ?>"
                            class="bg-purple-500 text-white p-2 rounded-md hover:bg-purple-700 disabled:bg-gray-500 disabled:cursor-not-allowed">
                        Page suivante
                    </button>
                </form>
            </div>
        </div>
    </div>
    <h2>Resultats de la recherche :</h2>
    <table id="table">
        <?php whatToDisplay($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers, $limitRows, $_GET['page'], 'recent'); ?>
    </table>

    <div class="flex flex-lign items-center mb-4">
        <div>
            <form method="get">
                <button name="page" <?php if ($_GET['page'] == 1) echo "disabled" ?>
                        value="<?= $_GET['page'] - 1 ?>"
                        class="bg-purple-500 text-white p-2 rounded-md hover:bg-purple-700 mr-2 disabled:bg-gray-500 disabled:cursor-not-allowed">
                    Page précédente
                </button>
            </form>
        </div>
        <div>
            <form method="get">
                <button name="page" <?php if ($_GET['page'] == $max) echo "disabled" ?>
                        value="<?= $_GET['page'] + 1 ?>"

                        class="bg-purple-500 text-white p-2 rounded-md hover:bg-purple-700 disabled:bg-gray-500 disabled:cursor-not-allowed">
                    Page suivante
                </button>
            </form>
        </div>
    </div>
</div>