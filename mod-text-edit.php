<?php if (!defined('WEBAPP')) die; ?>
<?php

if (!(isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)) die;

$test = isset($_POST['id']) && isset($_POST['title']) && isset($_POST['text']) &&
        is_numeric($_POST['id']) && is_string($_POST['title']) && is_string($_POST['text']);

if ($test) {
    $id = (int)$_POST['id'];
    $title = substr($_POST['title'],0,100);
    $text = substr($_POST['text'],0,65000);
    if ($title!='') {
        $sql = "UPDATE content SET content_title=?, content_text=? WHERE content_id=?";
        $db = db_connect();
        $c = $db->prepare($sql);
        $c->execute(array($title, $text, $id));
        header('Location: index.php?cmd=text&id='.$id.'&r=1');
        exit;
    }
    echo view('text-edit.php', array('id'=>$id, 'title'=>$title, 'text'=>$text));
}
else {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
    $row = textrow($id);
    echo view('text-edit.php', array('id'=>$row['content_id'],
       'title'=>$row['content_title'], 'text'=>$row['content_text']));
}

?>
