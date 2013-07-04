<?php
$base_url = 'http://' . SERVER_ROOT .'/' ;
?>

<rss version="2.0">
    <channel>
        <description><?php print $desc ?></description>
        <link>http://www.chucknorrisfacts.fr</link>
        <title>Chuck Norris Facts</title>
        <?php foreach ($facts as $fact): ?>
            <item>
                <?php if ($type == 'img'): ?>
                    <title>Image par <?php print $fact->pseudo ?></title>
                    <description><![CDATA[<img alt="Image par <?php print $fact->pseudo ?>" src="<?php print $base_url . $fact->fact ?>" height="60" width="72"/>]]></description>
                    <link><?php print $base_url . $fact->fact ?></link>
                <?php else: ?>
                    <title><![CDATA[<?php print html_entity_decode($fact->fact) ?>]]></title>
                <?php endif ?>
            </item>
        <?php endforeach ?>
    </channel>
</rss>

