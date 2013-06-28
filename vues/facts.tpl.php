<?php // manque les menus pour l'ordre des facts  ?>

<?php if (!isset($nontri)): ?>
    <?php print render(Navig::template('tpl', 'trie'), array('type'=>'txt')); ?>
<?php endif ?>

<?php print render(Navig::template('tpl', 'facts_txt'), array('facts' => $facts, 'action' => 'head')); ?>

<?php if (isset($pagination)) : ?>
    <?php print render(Navig::template('tpl', 'pagination'), array('pagination' => $pagination)); ?>
<?php endif ?>

<a href="#top">Maman j'veux remonter !!!</a>