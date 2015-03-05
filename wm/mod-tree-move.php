<?php if (!defined('WEBAPP')) die; ?>
<?php

if (!App::mod()->registered()) die;

$test = isset($_POST['id']) && isset($_POST['to']) && 
        is_numeric($_POST['id']) && is_numeric($_POST['to']);

if ($test) {
    $id = (int)$_POST['id'];
    $to = (int)$_POST['to'];
    App::mod()->set('topic_id',$id);
    tree_move($id, $to);
    header('Location: index.php?cmd=node&id='.$id.'&r=1');
    exit;
}
else {
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
    App::mod()->set('text_id',$id);
    echo view('tree-move.php', array('id'=>$id, 'to'=>0));
}

?>
