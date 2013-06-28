<?php

$news_content = News::get_content_from_slug('404', false);
$content = ($news_content == null) ? 'oups !!' : $news_content;

$output = array('content' => $content, 'titre' => '404');
