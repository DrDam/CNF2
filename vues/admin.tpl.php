<?php
global $user;
?>
<?php if ($user->role->id > 0): ?>
    <div class="head"> Menu Modérateur: 
        <a href="/valider">Valider (<?php print $attentes ?>)</a> | 
        <a href="/valider/images">Valider images (<?php print $img_att ?>)</a> |
        <a href="/updateDoublon">MAJ doublons</a>
    </div>
<?php endif; ?>  

<?php if ($user->role->id > 1): ?>
    <div class="head"> Menu Webmaster: 
        <a href="/berk">Berk (<?php print $berk ?>)</a> |
        <a href="/addnews">Ajouter News</a> |
        <a href="/news">Voir les news</a>
    </div>
<?php endif; ?>  


<?php if ($user->role->id == 3): ?>
    <div class="head"> Menu Super Admin: 
        <a href="/users">Gestion des utilisateurs</a>
    </div>
<?php endif; ?>  
