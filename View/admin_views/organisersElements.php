<form id="sorter" action="" method="GET">
    <!--<input type="text" name="test" placeholder="Testing" onchange="submit()">-->
    <label for="sort">Tri par :</label>
    <select name="sort" id="sort" onchange="submit()">
        <option value="ID-asc" <?php if ($_GET['sort'] == 'ID-asc') echo "selected=\"selected\"";?>>Identifiant</option>
        <option value="a-z" <?php if ($_GET['sort'] == 'a-z') echo "selected=\"selected\"";?>>A - Z</option>
        <option value="recent" <?php if ($_GET['sort'] == 'recent') echo "selected=\"selected\"";?>>Le plus récent</option>
<!--        <option value="popularite">Popularité</option>-->
        <?php
        if ($_GET['tab'] == 'posts'){ ?>
        <option value="id-user" <?php if ($_GET['sort'] == 'id-user') echo "selected=\"selected\"";?>>Utilisateur</option>
        <?php
        }
        if ($_GET['tab'] == 'commentaires'){ ?>
        <option value="id-user" <?php if ($_GET['sort'] == 'id-user') echo "selected=\"selected\"";?>>Utilisateur</option>
        <option value="id-post" <?php if ($_GET['sort'] == 'id-post') echo "selected=\"selected\"";?>>Post</option>
        <?php
        }
        ?>
    </select>
</form>
<?php
//if(isset($_GET['sort'])) {
//    echo '<strong>Trieur changé sur l\'option : ' , $_GET['sort'] , '</strong>';
//}
?>