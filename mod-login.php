<?php if (!defined('WEBAPP')) die; ?>
<?php

$test = isset($_POST['login']) && isset($_POST['pass']) &&
        is_string($_POST['login']) && is_string($_POST['pass']);

if ($test) {
    $login = substr($_POST['login'],0,50);
    $pass = substr($_POST['pass'],0,50);
    if (strtoupper(ROOT_LOGIN)==strtoupper($login)) {
        $test_pass = false;
        switch(strtolower(PASSWORD_FORMAT)) {
        case 'clean': $test_pass = (ROOT_PASSWORD == $pass); break;
        case 'md5': $test_pass = (ROOT_PASSWORD == md5($pass)); break;
        case 'sha1': $test_pass = (ROOT_PASSWORD == sha1($pass)); break;
        }
        if ($test_pass) {
            $_SESSION['login'] = ROOT_LOGIN;
            header('Location: index.php');
            exit;
        }
    }
    echo view('login.php', array('login'=>$login, 'pass'=>$pass));
}
else {
    echo view('login.php', array('login'=>''));
}

?>
