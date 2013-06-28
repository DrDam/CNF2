<div class="fact img" fact_id="<?php print $fact->id ?>" id="fact<?php print $fact->id ?>">
    <?php
    if (isset($action)) {
        print render(Navig::template('tpl', $action), array('fact' => $fact));
    }
    ?>
    <div class="factImg" align="center" id="fact<?php print $fact->id ?>">
        <a rel="lightbox" href="/<?php print $fact->fact ?>" >
            <img alt="Chuck Norris" src="/<?php print $fact->fact ?>" >
        </a>
    </div>
    <div class="vote">
        <div>Votez !</div> 
        <div class="ratybox">
            <div class="raty" id="raty<?php print $fact->id ?>" data-score="<?php print round($fact->moyenne, 2) ?>" ></div>
        </div>
    </div>
</div>