<?php
$data = array();
$news = new News();
$news->getLast();

if ($news->titre != null) {
    $data['last'] = $news;
}

$titre = 'chuckNorrisFacts';

$news_content = News::get_content_from_slug('home', false);
$data['content'] = ($news_content == null) ? 'home' : $news_content;

$facts = new Facts(null, 1, 'txt', 5);
$data['homefacts'] = $facts->getFacts();
unset($facts);

$facts = new Facts('top', 1, 'txt', 5);
$data['homefactsTop'] = $facts->getFacts();
unset($facts);

$facts = new Facts(null, 1, 'img', 2);
$data['homefactsImg'] = $facts->getFacts();
unset($facts);

$content = render(Navig::maVue('home'), $data);

$output = array('content' => $content, 'titre' => $titre);
