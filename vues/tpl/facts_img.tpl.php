<div id="factslist" class="img">

<?php

foreach ($facts as $id => $fact) {
    print render(Navig::template('tpl', 'fact_img'), array('fact' => $fact, 'action' => $action));
}
?>
</div>