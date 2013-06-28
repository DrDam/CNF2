<?php
$titre = 'A propos de ChuckNorrisFacts.fr';

$news_content = News::get_content_from_slug('a-propos');
$content = ($news_content == null) ? 'A Propos' : $news_content;

$output = array('content' => $content, 'titre' => $titre);
