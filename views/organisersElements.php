<form>
    <input type="search" placeholder="Search...">
    <button type="submit">Submit</button>
</form>
<form id="sorter" action="/projet-php-but-2/homeAdmin.php"
      method="GET">
    <!--<input type="text" name="test" placeholder="Testing" onchange="submit()">-->
    <label for="sort">Tri par :</label>
    <select name="sort" id="sort" onchange="submit()">
        <option value="ID-asc" <?php if ($_GET['sort'] == 'ID-asc') echo "selected=\"selected\"";?>>Identifiant</option>
        <option value="a-z" <?php if ($_GET['sort'] == 'a-z') echo "selected=\"selected\"";?>>A - Z</option>
        <option value="recent" <?php if ($_GET['sort'] == 'recent') echo "selected=\"selected\"";?>>Le plus récent</option>
<!--        <option value="popularite">Popularité</option>-->
    </select>
</form>
<?php
if(isset($_GET['sort'])) {
    echo '<strong>Trieur changé sur l\'option : ' , $_GET['sort'] , '</strong>';
}
?>
