<?php
require_once  __DIR__ .'/controlSearchBar.php';
require_once  __DIR__ . '/../autoloader.php';
?>

<tbody>
<?php

foreach (getTopicsResults($dbTopics) as $topic) {
    displayTopic($topic);
}

?>


</tbody>

<?php
function displayTopic(array $topic) {
    echo '<p>' . $topic["NAME"] . '</p>';
    echo '<p>' . $topic["DESCRIPTION"] . '</p>';
    /*(function (currentLine) {
        row.addEventListener('click', function () {
            alert('Vous avez cliqué sur la ligne avec l\'ID ' + results[currentLine][Object.entries(columns)[0][0]]);
        });
    })(line);*/
 } ?>