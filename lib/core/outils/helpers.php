<?php

function render($template_file, $variables = array()) {
    extract($variables, EXTR_SKIP);        // Extract the variables to a local namespace  
    ob_start();                            // Start output buffering
    include $template_file;   // Include the template file
    return trim(ob_get_clean());                 // End buffering and return its contents
}

function arg($id = null) {
    $args = array();
    if (isset($_GET['q']) && $_GET['q'] != '') {
        $get = $_GET['q'];
        $gets = explode('?', $get);
        $args = explode('/', $gets[0]);

        foreach ($args as $key => $value) {
            if (trim($value) == '') {
                unset($args[$key]);
            }
        }

        $args = array_values($args);
    } else {
        $args[] = FRONT;
    }

    if ($id == null) {
        return $args;
    } else {
        return (isset($args[$id])) ? $args[$id] : NULL;
    }
}

function addJs($file) {
    global $js;
    $js[] = $file;
    $_GLOBALS['js'] = $js;
}

function getScripts() {
    global $js;
    $pre = '<script type="text/javascript" src="/js/';
    $suf = '.js"></script>';

    return getData($js, $pre, $suf);
}

function addCss($file) {
    global $css;
    $css[] = $file;
    $_GLOBALS['css'] = $css;
}

function getStyles() {
    global $css;
    $pre = '<link rel="stylesheet" href="/css/';
    $suf = '.css" type="text/css" />';

    return getData($css, $pre, $suf);
}

function getData($files, $pre, $suf) {
    if ($files == array())
        return '';

    $datas = '';
   $files = array_unique($files);
    foreach ($files as $file)
        $datas .= $pre . $file . $suf;

    return $datas;
}

function send_mail($to, $subject, $msg, $from = null, $reply = null) {

    global $mail_webmaster;
    global $mail_no_reply;

    if ($from == null) {
        $from = $mail_webmaster;
    }
    if ($reply == null) {
        $reply = ($from == $mail_webmaster) ? $mail_no_reply : $from;
    }

    // Envoi du mail
    $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $reply . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $msg, $headers);
}

function user_has_role($access) {
    global $user;

    if ($user == NULL)
        return false;

    $obj = new Role();
    $roles = $obj->find();

    foreach ($roles as $role) {
        if (is_numeric($access)) {
            $elem = $role->id;
        } else {
            $elem = $role->label;
        }

        if ($access == $elem) {
            $role_id = $role->id;
            break;
        }
    }

    return ($user->role->id >= $role_id);
}

function user_access($access) {
    $bool = user_has_role($access);
    if ($bool == false) {
        $_SESSION['403'] = true;
    }
    return $bool;
}
