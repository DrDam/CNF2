<?php print stripslashes($fact->fact) ?>
<div class="vote"><div>Votez !</div> 
    <div class="raty" id="raty<?php print $fact->id ?>" data-score="<?php print round($fact->moyenne, 2) ?>" ></div>
</div>
<?php if ($fact->statut == 1): ?>
    <div class="points" id="points<?php print $fact->id ?>"><?php print round($fact->moyenne * 2, 2) ?> / 10 </div>
<?php else: ?>
    <div class="points" id="points<?php print $fact->id ?>"><span class="1"><?php print round($fact->moyenne * 100, 2) ?></span> % en <span class="2"><?php print $fact->votes ?></span> Votes </div>    
<?php endif ?>
