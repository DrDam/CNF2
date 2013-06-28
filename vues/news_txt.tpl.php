<?php if (isset($withTitle) && $withTitle == true): ?>
    <h1><?php print $news->titre ?></h1>
<?php endif ?>
<div id='body'>
    <?php print $news->getNews() ?>
</div>
