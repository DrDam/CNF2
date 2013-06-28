<?php

// classe Image Manipulation Tools Kit
class ImageSave {

    private $max_width;
    private $min_width;
    private $path;
    private $imagePath;

    public function __construct($confs = array()) {
        foreach ($confs as $conf => $value) {
            $this->$conf = $value;
        }
    }

    public function saveImage($file) {
//		var_dump($file);
        // On créé les miniatures pour l'image

        $imgsize = getimagesize($file['fichier']['tmp_name']);
        $width = $imgsize['0'];
        $height = $imgsize['1'];

        if ($width < $this->max_width) {
            $mini1 = $this->path . '/' . uniqid('q') . '.jpg';
            move_uploaded_file($file['fichier']['tmp_name'], $mini1);
        } else {
            $mini1 = $this->creer_miniature($file['fichier']['tmp_name']);
        }

        $this->imagePath = $mini1;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function creer_miniature($file) {

        $final_width = $this->max_width;
        $imgsize = getimagesize($file);
        $width = $imgsize['0'];
        $height = $imgsize['1'];

        $a = $width / $final_width;
        $newheight = $height / $a;
        $newheight = ceil($newheight);

        $source = imagecreatefromjpeg($file); // La photo est la source
        $destination = imagecreatetruecolor($final_width, $newheight); // On crée la miniature vide
        // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
        $largeur_source = imagesx($source);
        $hauteur_source = imagesy($source);
        $largeur_destination = imagesx($destination);
        $hauteur_destination = imagesy($destination);

        // On crée la miniature
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

        // On enregistre la miniature	  
        $name = $this->path . '/' . uniqid('q') . '.jpg';
        imagejpeg($destination, $name);
        return $name;
    }

}
