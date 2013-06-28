<rss version="2.0">
    <channel>
        <description><?php print $desc ?></description>
        <link>http://www.chucknorrisfacts.fr</link>
        <title>Chuck Norris Facts</title>
        <?php foreach ($facts as $fact): ?>
            <item>
                <?php if ($type == 'img'): ?>
                    <title>Image par <?php print $fact->pseudo ?></title>
                    <description>Proposé par <?php print $fact->pseudo ?></description>
                    <link>http://<?php print $base_url ?>/fact/image/<?php print $fact->id ?></link>
                <?php else: ?>
                    <title><![CDATA[<?php print $fact->fact ?>]]></title>
                    <description><![CDATA[<?php print $fact->fact ?>]]></description>
                    <link>http://<?php print $base_url ?>/fact/<?php print $fact->id ?></link>
                <?php endif ?>
            </item>
        <?php endforeach ?>
    </channel>
</rss>

