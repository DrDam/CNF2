<div id="factslist">
<?php
    foreach ($facts as $id => $fact) {
        print render(Navig::template('tpl', 'fact_txt'), array('fact' => $fact, 'action' => $action));
    }
?>
</div>