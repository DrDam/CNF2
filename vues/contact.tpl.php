
<fieldset>

    <legend>Envoyer un mail</legend>

    <p>Vous voulez envoyer un poème au webmaster de ce merveilleux site ? Lui faire une déclaration d'amour ? Une demande de mariage ? Ou tout simplement signaler un bug ? Exprimez vous ici !</p>

    <form action="" method="post">

        <?php print Forms::label('Votre mail :', 'mail') ?>
        <input type="text" id='mail' name="mail" value="<? echo $mail; ?>"/>

        <br/>

        <?php print Forms::label('Votre mesage :', 'msg') ?>
        <br/>
        <textarea id='msg' cols="60" rows="10" name="msg"><? echo stripslashes($msg2); ?></textarea><br/>

        <?php print Forms::label('combien font ' . $capchat[0] . ' plus ' . $capchat[1] . ' ? ', 'cap') ?>
        <input type='text' name="cap" size="3" />

        <input type="submit" value="Envoyer" />
    </form>
</fieldset>
