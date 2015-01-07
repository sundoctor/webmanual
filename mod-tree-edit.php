<?php if (!defined('WEBAPP')) die; ?>
<?php

if (!(isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)) die;

$test = isset($_POST['id']) && isset($_POST['topic']) && 
        is_numeric($_POST['id']) && is_string($_POST['topic']);

if ($test) {
    $id = (int)$_POST['id'];
    App::mod()->set('topic_id',$id);
    $topic = substr($_POST['topic'],0,100);
    if ($topic!='') {
        tree_edit($id, array('topic'=>$topic));
        header('Location: index.php?cmd=node&id='.$id.'&r=1');
        exit;
    }
    echo view('tree-edit.php', array('id'=>$id, 'topic'=>$topic));
}
else {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
    App::mod()->set('topic_id',$id);
    $row = tree_row($id);
    echo view('tree-edit.php', array('id'=>$row['topic_id'], 'topic'=>$row['topic_name']));
}

?>
