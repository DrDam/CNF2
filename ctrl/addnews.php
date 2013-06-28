<?php

if (user_access('webmaster')) {
    addjs('tiny_mce/jquery.tinymce');
    addjs('config_tinymce');

    $data = array();

    if (count(arg()) == 2 && is_numeric(arg(1))) {
        $news = new News();
        $news->id = arg(1);
        $news->load();
        if (!isset($news->error)) {
            $data['news'] = $news;
        }
    }


    if (isset($_POST['news'])) {
        global $user;

        $news = new News();

        if (isset($_POST['newsId'])) {
            $news->id = $_POST['newsId'];
            $news->load();
        }
        $news->setNews($_POST['slug'], $_POST['title'], $_POST['news'], $user);
        $news->save();

        Navig::redirect('/news');
    }

    $content = render(Navig::maVue('addnews'), $data);

    $output = array('content' => $content, 'titre' => $titre);
}
