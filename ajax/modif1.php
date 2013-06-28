<?php
require_once('ajaxboot.php');

$fact = Facts::getObject(false, 'txt');

$fact->id = $_POST['fact'];
$fact->load();

if (isset($fact->fact)) :    ?>
    <form id="modif" fact='<?php print $fact->id ?>'>
        <textarea id="factmodif<?php print $fact->id ?>" cols="80"><?php print stripslashes($fact->fact) ?></textarea>
        <input type="submit" value="Ok" />
    </form>
<?php else : ?>
    Trop tard ! ChuckNorris n'a pas supporter cette blague !
<?php endif ?>
