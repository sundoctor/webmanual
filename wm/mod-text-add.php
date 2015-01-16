<?php if (!defined('WEBAPP')) die; ?>
<?php

if (!(isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)) die;

$pid = isset($_GET['pid']) && is_numeric($_GET['pid']) ? (int)$_GET['pid'] : 0;

$test = isset($_POST['pid']) && isset($_POST['title']) && 
    isset($_POST['text']) && isset($_POST['format']) &&
    is_numeric($_POST['pid']) && is_string($_POST['title']) && 
    is_string($_POST['text']) && is_string($_POST['format']);

if ($test) {
    $pid = (int)$_POST['pid'];
    $title = substr($_POST['title'],0,100);
    $text = substr($_POST['text'],0,65000);
    $format = substr($_POST['format'],0,10);
    if ($title!='') {
        $id = text_add(array('title'=>$title,'text'=>$text,'format'=>$format));
        header('Location: index.php?cmd=text&id='.$id.'&r=1');
        exit;
    }
    echo view('text-add.php', array('pid'=>$pid, 'title'=>$title, 'text'=>$text, 'format'=>$format));
}
else {
    echo view('text-add.php', array('pid'=>$pid));
}

?>
