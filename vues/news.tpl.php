<?php $bool = user_has_role('moderateur'); ?>
<table>
    <tr>
        <th>Titre</th>
        <th>date</th>
        <th>auteur</th>
        <?php if ($bool == true): ?>
            <th colspan=3>actions</th>
        <?php endif ?>
    </tr>
    <?php
    foreach ($news as $new):
        if ($new->notCached == 1) {
            $label = 'desactiver';
            $class = 'out';
        } else {
            $label = 'activer';
            $class = 'in';
        }
        ?>
        <tr>
            <td><?php print Forms::linkTo('/news/' . $new->slug, $new->titre) ?></td>
            <td><?php print date('d-m-Y', $new->date) ?></td>
            <td><?php print $new->getAuteur() ?></td>
        <?php if ($bool == true): ?>
                <td><?php print Forms::linkTo('/addnews/' . $new->id, 'modifier') ?></td>
                <td><?php print Forms::linkTo('/news/' . $new->id . '/delete', 'supprimer') ?></td>
                <td><?php print Forms::linkTo($new->id, $label, null, $class) ?></td>
    <?php endif ?>
        </tr>
<?php endforeach ?>
</table>
