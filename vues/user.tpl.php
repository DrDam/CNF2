<?php
$name = (isset($old)) ? $old->pseudo : '';
$mail = (isset($old)) ? $old->mail : '';
$role = (isset($old)) ? $old->role : '';
?>
<fieldset>
    <legend>Ajouter un utilisateur</legend>
    <form action="" method="post">
        <?php if (isset($old)) : ?>
            <input type='hidden' value = '<?php $old->id ?>' name="uid" />
            <?php print Forms::label('Nouveau mot de passe :', 'new_pass') ?><input id='new_pass' type='checkbox' name='new_pass' value='ok' /><br />
        <?php endif ?>
        <?php print Forms::label('Pseudo :', 'pseudo') ?><input id='pseudo' name="pseudo" value="<?php print $name ?>" type="text" /><br/>
        <?php print Forms::label('Mail :', 'mail') ?><input id='mail' name="mail" value="<?php print $mail ?>"type="text" /><br/>
        <?php print Forms::label('Role :', 'role') ?>
        <select name='role' id='role'>
            <?php print Forms::liste($roles, $role, null, array('id', 'label')) ?>
        </select><br />
        <input type="submit" value="zyva !" />
    </form>
</fieldset>
