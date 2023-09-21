<form>
    <input type="search" placeholder="Search...">
    <button type="submit">Submit</button>
</form>
<form id="trieur-result" action="../homeAdmin.php"
      method="POST">
    <!--<input type="text" name="test" placeholder="Testing" onchange="submit()">-->
    <label for="trieur_select">Tri par :</label>
    <select name="trieur_select" onchange="submit()">
        <option value="a-z" selected="selected">A - Z</option>
        <option value="z-a">Z - A</option>
        <option value="recent">Le plus récent</option>
        <option value="ancien">Le plus ancien</option>
        <option value="popularite">Popularité</option>
    </select>
</form>
<?php
if(isset($_POST['trieur_select'])) {
    echo '<strong>Trieur changé sur l\'option : ' , $_POST['trieur_select'] , '</strong>';
}
?>
