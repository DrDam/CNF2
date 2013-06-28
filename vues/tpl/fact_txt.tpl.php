<div class="fact" fact_id="<?php print $fact->id ?>" id="fact<?php print $fact->id ?>">
    <?php
    if (isset($action)) {
        print render(Navig::template('tpl', $action), array('fact' => $fact));
    }
    ?>
    <div class="factbody">
        <?php
        print render(Navig::template('tpl', 'factbody'), array('fact' => $fact));
        ?>
    </div>
</div>