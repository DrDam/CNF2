<?php
$content = "";
$titre = "";
global $user;

// si le formulaire à été validé
if (isset($_POST['pseudo'])) {

    $nom = trim($_POST['pseudo']);
    $nom = htmlentities($nom, ENT_QUOTES);

    $pass = trim($_POST['pass']);
    $pass = md5($pass);

    $objUser = new User();
    $objUser->pseudo = $nom;
    $objUser->password = $pass;
    $objUser->load();

    if (isset($objUser->id)) {

        $_SESSION['pseudo'] = $nom;

        if (isset($_POST['perm']) and $_POST['perm']) {
            $expire = time() + 20 * 24 * 3600;
            $cookie_data = array('n' => $nom, 'p' => $pass);
            setcookie('cnf', serialize($cookie_data), $expire);
        }

        $user = $objUser;
        $GLOBALS['user'] = $user;

        Helpers::ok("Welcome " . $objUser->pseudo . " <br/>");
    } else {
        Helpers::error("Bah non... loupé !");
    }
}

if (isset($user->id)) {
    require_once Navig::ctrl('admin');
} else {
    $titre = "t'es qui toi ? ";
    $content = render(Navig::maVue());
}

$output = array('content' => $content, 'titre' => $titre);
