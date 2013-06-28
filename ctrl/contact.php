<?php

$err = 0;

if (isset($_POST['msg'])) {
    if ($_SESSION['nb_alea'] == $_POST['cap']) {

        $mail = trim($_POST['mail']);
        $message = trim($_POST['msg']);
        $message = htmlentities($message, ENT_QUOTES);
        $message= nl2br($message);
        $ip = $_SERVER['REMOTE_ADDR'];
        $message .= "\n";
        $message .= "\n";
        $message .= 'Son mail : ' . $mail . ' et son IP : ' . $ip;

        if (Helpers::isMail($mail) AND !empty($message)) {
            $to = $mail_webmaster;
            $subject = 'Chuck Norris Facts fr - Formulaire de contact';
            $headers = 'From: ' . $mail . '' . "\r\n";
            $headers .= 'Reply-To: ' . $mail . '' . "\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
            Helpers::ok('Mail envoyé avec succès');
        } else {
            Helpers::error('Merci de préciser un message et une adresse mail valide.');
            $err = 1;
        }
    } else {
        Helpers::error('Erreur lors de la confirmation anti-bot. Merci de réviser vos tables d\'addition.');
        $err = 1;
    }
}

$mail = '';
$msg2 = '';

if ($err) {

    $mail = $_POST['mail'];
    $msg2 = $_POST['msg'];
}

$capchat = Helpers::capchat();
$titre = 'A toi la parole';

$content = render(Navig::maVue(), array('capchat' => $capchat, 'msg2' => $msg2, 'mail' => $mail));

$output = array('content' => $content, 'titre' => $titre);
