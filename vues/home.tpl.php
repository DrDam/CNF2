<?php if (isset($last)): ?>
    <div id="<?php print $last->slug ?>">
        <div class="news">
            <strong>Dernièrement sur ChuckNorrisFacts : </strong> <a href="<?php print '/news/' . $last->slug ?>"><?php print $last->titre ?></a><br/>	
        </div>
    </div>

<?php endif ?> 


<div class="welcome">
    <?php print $content ?>
</div>
<div id='facthome'>
    <div class="factshome">
        <div class="lasthome">
            <p>Les dernières facts : </p>
            <?php foreach ($homefacts as $key => $fact): ?>
                <div class="fact home"><?php print stripslashes($fact->fact) ?></div>
            <?php endforeach ?>
            <a href='/facts' >voir toutes les facts</a>
        </div>
        <div class="tophome">
            <p>Le top 5 : </p>
            <?php foreach ($homefactsTop as $key => $fact): ?>
                <div class="fact home"><?php print stripslashes($fact->fact) ?></div>
            <?php endforeach ?>
            <a href='/facts/top' >voir toutes les facts</a>
        </div>
    </div>
    <div class="factsImghome">
        <a href='/facts/image' ><span>Les dernières images : </span></a>	
        <?php foreach ($homefactsImg as $key => $fact): ?>
            <div class="content" align="center" >
                <a rel="lightbox" href="/<?php print $fact->fact ?>" >
                    <img alt="Chuck Norris" src="/<?php print $fact->fact ?>" >
                </a>
            </div> 
        <?php endforeach ?>
        <a href='/facts/image' >voir toutes les Images</a>
    </div>
</div>
