<?php

if (user_access('superadmin')) {
    //var_dump(arg(1));

    $uid = 0;
    $vue = 'user';

    if (arg(1) != null && is_numeric(arg(1))) {
        $old_user = new User();
        $old_user->id = arg(1);
        $old_user->load();
        if (isset($old_user->error)) {
            unset($old_user);
        } else {
            $data['old'] = $old_user;
        }
    }

    if (isset($_POST['pseudo']) and isset($_POST['mail'])) {

        if (isset($_POST['uid'])) {
            //edit
            $out = Helpers::editUser($_POST);
        } else {
            //new
            $out = Helpers::saveUser($_POST);
        }

        if ($out != null) {
            Helpers::ok("Ça roule ma poule !!");
            require_once Navig::ctrl('users');
        }
    }

    if (arg(2) != null && arg(2) == 'delete' && isset($data['old'])) {
        global $user;
        $pseudo = $data['old']->pseudo;

        if ($user->id == $data['old']->id) {
            Helpers::error("Aucun suicide n'est tolèré ici !");
        } else {
            $data['old']->delete();
            Helpers::ok("Chuck Norris à fait sa fête à " . $pseudo . " !!");
        }
        $content = Navig::redirect('/users');
    }


    $role = new Role();


    $data['roles'] = $role->find();

    if (!isset($content)) {
        $titre = ' un new';
        $content = render(Navig::maVue($vue), $data);
    }

    $output = array('content' => $content, 'titre' => $titre);
}
