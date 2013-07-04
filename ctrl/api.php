<?php

// cas url  = cnf/api/api
if (count(arg()) < 2) {
    require_once Navig::ctrl('home');
} else {
    if (arg('0') == arg(1) && arg(1) == "api") {
        $news_content = News::get_content_from_slug('api');

        $content = ($news_content == null) ? 'faire le contenu' : $news_content;

        $output = array('content' => $content, 'titre' => 'api');
    } else {
        // cas url = cnf/api/get?data=tri:aaa;type:bbb;nb:ccc
        $no_render = true;

        $action = arg(1);
        $params = $_GET['data'];

        $api = new API($action, $params);

        print $api->getFacts();
    }
}
