<div id="global">

    <div id="bandeau">
        <a name="top" href="/"><span id="haut"></span></a>
    </div>
    <div id="haut2">

        <ul>
            <li><a href="/<?php print FRONT ?>">Accueil</a></li>
            <li><a href="/facts">Les Facts</a></li>
            <li><a href="/facts/image">En Images!</a></li>
            <li><a href="/moderer">Modérer</a></li>
            <li><a href="/addfacts">Proposer</a></li>
            <li><a href="/faq">FAQ</a> </li>

            <li class="last"><form action="/search" style="display:inline;" method="post" >
                    <input type="input" name="s" class="search" />
                    <input type="submit" value="OK" />
                </form>
            </li>
        </ul>

    </div>

    <?php print Helpers::printUser() ?>

    <div id="corps">

        <?php print Helpers::printMessages() ?>

        <?php print $content ?>

    </div>
    <div id="bas">
        Design ptitlu - Code DrDam - admins : DrDam, ash, Teuvz, IvelfanFr, Reilea   <br/>
        <ul>
            <li class="first">Extras</li>
            <li><a href="/a-propos">A propos</a></li>
            <li><a href="/contact">Contact</a></li>
            <li><a href="/rss">Fil RSS Facts</a></li>
            <li><a href="/rss/image">Fil RSS Images</a></li>
            <li class="last"><a href="/api/api">API</a></li>
        </ul>
    </div>


</div>
