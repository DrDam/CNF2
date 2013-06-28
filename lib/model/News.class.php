<?php

class News extends Base {

    static $primary = 'id';
    static $structure = array(
        'id' => array('type' => 'serial'),
        'news' => array('type' => 'text'),
        'titre' => array('type' => 'varchar', 'length' => 255),
        'auteur' => array('type' => 'int', 'length' => 11),
        'date' => array('type' => 'int', 'length' => 11),
        'notCached' => array('type' => 'bool'),
        'slug' => array('type' => 'varchar', 'length' => 255)
    );
    public $id;
    public $news;
    public $titre;
    public $auteur;
    public $date;
    public $notCached;
    public $slug;

    public function setNews($slug, $titre, $news, $auteur) {
        $toslug = ($slug == '') ? $titre : $slug;
        $this->slug = Helpers::slugify($toslug);
        $this->titre = $this->transforme($titre);
        $this->news = $this->transforme($news);
        $this->notCached = false;
        $this->auteur = $auteur->id;
    }

    public function save() {
        $this->date = time();
        parent::save();
    }

    private function transforme($data) {
        return htmlentities(trim($data), ENT_QUOTES);
    }

    public function getNews() {
        return html_entity_decode($this->news, ENT_QUOTES);
    }

    public function getAuteur() {
        $obj = new User();
        $obj->id = $this->auteur;
        $obj->load();
        return $obj->pseudo;
    }

    public function getLast() {
        $delta = 3600 * 24 * 15; // 15jours

        $cible = time() - $delta;

        $req = 'select * from ' . $this->getTable() . ' where notCached = 1 and date > ' . $cible . ' order by date DESC LIMIT 1';

        $collection = $this->getCollection($req, $this->getTable());

        if (count($collection) > 0) {
            $news = $collection[0];
            $this->id = $news->id;
            $this->titre = $news->titre;
            $this->slug = $news->slug;
            $this->news = $news->news;
            $this->auteur = $news->auteur;
            $this->date = $news->date;
        }
    }

    static function get_content_from_slug($slug, $title = true) {
        $news = new News();
        $news->slug = $slug;
        $news->load();

        if (isset($news->id)) {
            return render(Navig::maVue('news_txt'), array('news' => $news, 'withTitle' => $title));
        }
        return null;
    }

}
