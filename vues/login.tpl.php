<form action="" method="post" name="login">

    <?php print Forms::label('Pseudo :', 'pseudo') ?>
    <input id="pseudo" type="text" name="pseudo" /><br/>

    <?php print Forms::label('Pass.  :', 'pass') ?>
    <input id="pass"  type="password" name="pass" /><br/>

    <input id="perm" type="checkbox" name="perm" />
    <?php print Forms::label('Connexion permanente (déconseillé sur ordinateurs partagés ou publics)', 'perm') ?>
    <br/>

    <input type="submit" name="go" value="Zyva !" />

</form>