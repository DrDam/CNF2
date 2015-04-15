<?php print Helpers::ok('Vous pouvez ici poster une image de votre création reprenant un fact déjà publié ou non. Tout type de création est accepté dans la mesure où vous en possédez les droits et qu\'elle respecte les règles du site. Les propositions sont soumises à validation. Les règles se trouvent <a href="/faq#images">ICI</a>. Les images n\'affichant pas de facts seront systèmatiquement refusées.'); ?>

<?php print render(Navig::template('tpl', 'trie'), array('type'=>'img')); ?>

<?php print render(Navig::template('tpl', 'facts_img'), array('facts' => $facts, 'action' => 'head', 'root'=> $root)); ?>
<?php if (isset($pagination)) : ?>
    <?php print render(Navig::template('tpl', 'pagination'), array('pagination' => $pagination)); ?>
<?php endif ?>


<div id="submitImg">
    <fieldset>
        <legend>Envoyer un fact en image</legend>
        <form action="/facts/image" method="post" enctype="multipart/form-data">

            <?php print Forms::label('Image :', 'fichier') ?><input type="file" name="fichier" /><br/>
            <?php print Forms::label('Pseudo :', 'pseudo') ?><input name="pseudo" type="text" /><br/>
            <?php print Forms::label('Mail :', 'mail') ?><input name="mail" type="text" /><br/>
            <?php print Forms::label('Blog (facultatif) :', 'url') ?><input name="url" type="text" /><br/>
            <input type="submit" value="Envoyer"/>
        </form>
    </fieldset>
</div>
