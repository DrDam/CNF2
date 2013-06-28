<?php

/*
 * Objectif : 
 * Parcourir la table des doublons, 
 * chercher si certain ne sont pas en double
 * 
 * si c'est le cas : 
 * 		update la facts "parente"
 * 		suppression du doublon
 * 		suppression de la facts 
 */

if (user_access('moderateur')) {
    $datas = array();

    if (isset($_POST['valider']) && isset($_POST['perm']) && is_array($_POST['perm'])) {
        foreach ($_POST['perm'] as $new => $ref) {
            $fact = Base::autoLoad('Fact', array('id' => $new));
            $old = Base::autoLoad('Fact', array('id' => $ref));
            $doublon = Base::autoLoad('Doublons', array('id' => $new));

            $old->points += $fact->points;
            $old->votes += $fact->votes;
            $old->berk += $fact->berk;
            if ($old->votes > 0)
                $old->moyenne = $old->points / $old->votes;

            $old->save(true);
            $doublon->delete();
            $fact->delete();
        }
        
        unset($fact);
        unset($doublon);
        unset($old);
    }


    
    $lastDoublon = variables::get_var('last_doublon');
    $time_out = false;


    if (isset($_POST['reset']) && $_POST['reset'] == 'reset') {
        $lastDoublon = null;
    }
    $where = ($lastDoublon != null ) ? 'where id > ' . $lastDoublon : '';

    $bdd = new Base();
    $doubles = array();

    $doublons = $bdd->getCollection('select * from Doublons ' . $where . ' order by id', 'Doublons');

    // toutes les facts sur lesquels on détecte pas de doublon 
    // sont ajoutée
    foreach ($doublons as $key => $doublon) {

        $doubl_id = $doublon->getDoublon();
        if ($doubl_id != null) {
            //		print $doublon->id.'->'.$doubl_id.'<br>';
            $old = Base::autoLoad('Fact', array('id' => $doubl_id));
            $fact = Base::autoLoad('Fact', array('id' => $doublon->id));
            $doubles[$fact->id] = array('new' => $fact->fact, 'old' => $old->fact, 'ref' => $old->id);
            $doubles[$fact->id]['data'] = $doublon->data;
        }
        // on sort 20 doubles par page, ou on coupe après 20sec d'execution
        if (count($doubles) > 20 || time() - $_SERVER["REQUEST_TIME"] > 20) {
            variables::set_var('last_doublon', $doublon->id);
            $time_out = true;

            $reste = count(array_slice($doublons, $key));
            if(count($doubles) < 20)
            {    
               $str = (count($doubles) > 0) ? 'Quelques doublons détectés' : 'Aucun doublon détecté';
               $str .=' dans le temps imparti. Il en reste encore '.$reste.' à tester. Retente ta chance ! ';
            }
            else
            {
                $str ='Il reste encore '.$reste.' doublons à tester, mais on va se limiter à quelques uns. Réessaye pour continuer !';
            }
                Helpers::error($str);
            break;
        }
    }
    
    if (isset($doubles) && $doubles != array()) {
        $datas['doubles'] = $doubles;
    } else {
        if ($time_out == false)
            Helpers::ok('Pas de doublons détectés');
    }

    $titre = 'C\'est moche !';

    $content = render(Navig::maVue(), $datas);

    $output = array('content' => $content, 'titre' => $titre);
}
