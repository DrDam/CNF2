<?php $url = implode('/', arg()); ?>

<div class="choix">
    <?php foreach ($pagination as $key => $data): ?>

        <?php if (isset($data[1])): ?>
            <a href="/<?php print $url . '?p=' . $data[1]; ?>"><?php print $data[0] ?></a>
        <?php else: ?>
            <span><?php print $data[0] ?></span>
        <?php endif ?>
    <?php endforeach ?>
</div>
