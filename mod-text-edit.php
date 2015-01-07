<?php if (!defined('WEBAPP')) die; ?>
<?php

if (!(isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)) die;

$test = isset($_POST['id']) && isset($_POST['title']) && 
        isset($_POST['text']) && isset($_POST['format']) && 
        is_numeric($_POST['id']) && is_string($_POST['title']) && 
        is_string($_POST['text']) && is_string($_POST['format']);

if ($test) {
    $id = (int)$_POST['id'];
    App::mod()->set('text_id',$id);
    $title = substr($_POST['title'],0,100);
    $text = substr($_POST['text'],0,65000);
    $format = substr($_POST['format'], 0, 10);
    if ($title!='') {
        text_edit($id, array('title'=>$title,'text'=>$text,'format'=>$format));
        header('Location: index.php?cmd=text&id='.$id.'&r=1');
        exit;
    }
    echo view('text-edit.php', array('id'=>$id, 'title'=>$title, 'text'=>$text, 'format'=>$format));
}
else {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
    App::mod()->set('text_id',$id);
    $row = text_row($id);
    echo view('text-edit.php', array('id'=>$row['content_id'],
       'title'=>$row['content_title'], 'text'=>$row['content_text'], 'format'=>$row['content_format']));
}

?>
