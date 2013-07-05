<rss version="2.0">
    <channel>
        <description><?php print $desc ?></description>
        <link>http://www.chucknorrisfacts.fr</link>
        <title>Chuck Norris Facts</title>
        <?php foreach ($facts as $fact): ?>
            <item>
                <?php if ($type == 'img'): ?>
                    <title>Image par <?php print $fact->pseudo ?></title>
                    <description><![CDATA[<img alt="Image par <?php print $fact->pseudo ?>" src="http://<?php print SERVER_ROOT .'/' . $fact->fact ?>" height="60" width="72"/>]]></description>
                    <link>http://<?php print SERVER_ROOT .'/' . $fact->fact ?></link>
                <?php else: ?>
                    <title><![CDATA[<?php print html_entity_decode($fact->fact,ENT_QUOTES,'UTF-8') ?>]]></title>
                <?php endif ?>
            </item>
        <?php endforeach ?>
    </channel>
</rss>

