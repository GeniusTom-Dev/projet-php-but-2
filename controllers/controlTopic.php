<?php

namespace controllers;

use controlGeneratePosts;

use DbTopics;

class controlTopic
{
    private DbTopics $dbTopics;


    public function __construct($dbTopics)
    {
        $this->dbTopics = $dbTopics;
    }

    public function getTopic(int $topicId): string
    {
        $topicData = $this->dbTopics->selectById($topicId)->getContent();
        ob_start(); ?>
        <section class="topiceSimple flex flex-col items-left w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6 mb-4">
            <a href="topicPage.php?name=<?= $topicData['NAME'] ?>"">
                <p style="font-size: large"><?= $topicData['NAME'] ?></p>
                <p style="font-size: small"><?= $topicData['DESCRIPTION'] ?></p>
            </a>
        </section>
        <?php $topicHeader = ob_get_contents();
        ob_end_clean();
        return $topicHeader;
    }
}