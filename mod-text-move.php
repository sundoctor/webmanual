<?php if (!defined('WEBAPP')) die; ?>
<?php

if (!(isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)) die;

$test = isset($_POST['id']) && isset($_POST['to']) && 
        is_numeric($_POST['id']) && is_numeric($_POST['to']);

if ($test) {
    $id = (int)$_POST['id'];
    $to = (int)$_POST['to'];
    App::mod()->set('text_id',$id);
    text_move($id, $to);
    header('Location: index.php?cmd=text&id='.$id.'&r=1');
    exit;
}
else {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
    App::mod()->set('text_id',$id);
    echo view('text-move.php', array('id'=>$id, 'to'=>0));
}

?>
