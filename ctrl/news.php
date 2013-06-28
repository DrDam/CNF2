<?php
addJs('vote');
// page des news
if (count(arg()) == 1) {
    $titre = 'toutes les news';

    $obj = new News();

    if (!user_has_role('moderateur')) {
        $obj->notCached = 1;
    } else {
        addJs('news');
    }
    $news = $obj->find();

    $content = render(Navig::maVue('news'), array('news' => $news));
} else {
    if (count(arg()) == 2) {

        $content = News::get_content_from_slug(arg(1));
    } elseif (count(arg()) > 2 && arg(2) == 'delete') {
        $id = arg(1);
        $news = new News();
        $news->id = $id;
        $news->delete();

        $content = Navig::redirect('/news');
    }

    if ($content == null) {
        require_once Navig::ctrl('inc/404');
    }
}
$output = array('content' => $content, 'titre' => $titre);
