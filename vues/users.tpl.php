<p><?php print Forms::linkTo('user', 'Ajouter un utilisateur') ?></p>

<table>
    <tr>
        <th>Nom</th>
        <th>Role</th>
        <th colspan=2>actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php print $user->pseudo ?></td>
            <td><?php print $user->role ?></td>
            <td><?php print Forms::linkTo('/user/' . $user->id, 'modifier') ?></td>
            <td><?php print Forms::linkTo('/user/' . $user->id . '/delete', 'supprimer') ?></td>
        </tr>
    <?php endforeach ?>
</table>
