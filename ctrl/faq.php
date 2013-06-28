<?php
$titre = 'Qu\'est ce que t\'as pas compris ?';

$news_content = News::get_content_from_slug('faq');
$content = ($news_content == null) ? 'FAQ' : $news_content;

$output = array('content' => $content, 'titre' => $titre);
