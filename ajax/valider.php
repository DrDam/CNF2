<?php
require_once('ajaxboot.php');
ajax_access('moderateur');

$nodoublon = (isset($_POST['nodoublon']) && $_POST['nodoublon'] == 1) ? true : false ;

$fact = Facts::getObject(false, $_POST['type']);

$fact->id = $_POST['fact'];

$fact->load();

if (isset($fact->error) && $fact->error == TRUE) {
    exit(json_encode(array('code' => 1)));
}

$action = $_POST['action'];
$value = $_POST['value'];

//controler de l'action !!
if ($action == 'choix') {
    if (!is_numeric($value) || !in_array($value, array(1, 0))) {
        exit(json_encode(array('code' => 2)));
    }



    if ($value == 1) {
        // on sauvegarde la fact
        $fact->statut = 1;
        $fact->clean();
        $fact->save();
        // on lui crée un doublon
        $doublon = new Doublons();
        $doublon->id = $fact->id;
        $doublon->cut($fact->fact);
        $doublon->save();
        exit(json_encode(array('code' => 0)));
    }
    if ($value == 0) {
        $code='3';
        $doublon = new Doublons();
        $doubl_id = $doublon->getDoublon($fact->fact);
        if ($doubl_id != null && $nodoublon == false) {
            $old = Base::autoLoad('Fact', array('id' => $doubl_id));
            $old->points += $fact->points;
            $old->votes += $fact->votes;
            $old->berk += $fact->berk;

            if ($old->votes > 0)
                $old->moyenne = $old->points / $old->votes;
            $old->save(true);
            $code='5';
        }
        $fact->delete();
        $this->clean();
        exit(json_encode(array('code' => $code)));
    }

    $hesit = new Hesit();
    $hesit->fact_id = $fact->id;
    $hesit->delete();
}

if ($action == 'hesit') {
    $hesit = new Hesit();
    $hesit->fact_id = $fact->id;
    $hesit->save();

    exit(json_encode(array('code' => 4)));
}
