<?php

$news_content = News::get_content_from_slug('403', false);
$content = ($news_content == null) ? 'Dégage !!!' : $news_content;

$output = array('content' => $content, 'titre' => '403');
