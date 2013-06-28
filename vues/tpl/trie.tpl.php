<?php
$root_url = '/facts';
$root_url .= ($type == 'img') ? '/image' : '' ;
?>


<div class="choix">
    Type de parcours : 
    <a href="<?php print $root_url ?>/top">Top Points</a> - 
    <a href="<?php print $root_url ?>/flop">Flop points</a> -
    <a href="<?php print $root_url ?>/mtop">Top Moyenne</a> - 
    <a href="<?php print $root_url ?>/mflop">Flop Moyenne</a> - 
    <a href="<?php print $root_url ?>/alea">Aléatoire</a> - 
    <a href="<?php print $root_url ?>/first">Les Débuts</a> - 
    <a href="<?php print $root_url ?>">Derniers ajouts</a>
</div>