<?php
global $user;
$is_not_image = (get_class($fact) == 'Fact');
$okmodif = ($user != null && $user->role->id > 0 && $is_not_image) ? true : false;
?> 

<div class="head">
    <span>#<?php print $fact->id ?></span> &nbsp; &nbsp; 

    <?php if ($okmodif == true): ?>
    <!-- elements de modération -->
        <a href="#" class="modif" id="modif<?php print $fact->id ?>" style="cursor:pointer;">(Modifier)</a>
    
        <?php if (isset($fact->names)) : ?>
            <strong class="blue"><?php print implode(', ', $fact->names) ?> se tate(nt)</strong>
        <?php endif ?> 
        <?php if (isset($fact->doublon)) : ?>
             <strong class="red"> doublon possible de "<?php print $fact->doublon ?>" </strong>
        <?php endif ?> 
        
    <?php endif ?>
    <div class="social" >
        <a href="https://twitter.com/intent/tweet?button_hashtag=ChuckNorrisFactsFr&text=<?php print urlencode(html_entity_decode($fact->fact,ENT_QUOTES,'UTF-8')) ?>" class="twitter-hashtag-button" data-lang="fr" target="_blank"><img src="/img/social/logo-twitter.png" alt="Share on twitter" width="16" height="16" /></a>
        <a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php print urlencode('ChuckNorrisFacts-fr') ?>&amp;p[summary]=<?php print urlencode(html_entity_decode($fact->fact,ENT_QUOTES,'UTF-8')) ?>&amp;p[url]=<?php print urlencode($root) ?>&amp;', 'sharer', 'toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"><img src="/img/social/logoFacebook.png" alt="Share on facebook" width="16" height="16" /></a>
        <a href="https://m.google.com/app/plus/x/?v=compose&content=<?php print urlencode(html_entity_decode($fact->fact,ENT_QUOTES,'UTF-8')) ?>" onclick="window.open('https://m.google.com/app/plus/x/?v=compose&content=<?php print urlencode(html_entity_decode($fact->fact,ENT_QUOTES,'UTF-8')) ?>', 'gplusshare', 'width=450,height=300,left=' + (screen.availWidth / 2 - 225) + ',top=' + (screen.availHeight / 2 - 150) + '');
              return false;"><img src="/img/social/google-plus.png" alt="Share on Google+" width="16" height="16" /></a>
    </div>
</div>
