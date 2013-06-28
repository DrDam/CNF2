Ajout de facts !

<?php print Helpers::printMessages() ?>


<form method='post' >

    <textarea name='facts' rows='5' cols='60'><?php print (isset($oldfact)) ? $oldfact : ''  ?></textarea>


    <?php if (isset($double) && $double == true): ?>
        <br />

        <?php print Forms::label('Ma facts est autentique !', 'double') ?>
        <input id="double" value='double' type="checkbox" name="double" />
    <?php endif ?>
    <br />

    <?php print Forms::label('combien font ' . $capchat[0] . ' plus ' . $capchat[1] . ' ? ', 'cap') ?>
    <input id='cap' type='text' name="cap" size="3" />

    <br />

    <input type='submit' name='add' />

</form>
