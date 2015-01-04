<?php if (!defined('WEBAPP')) die; ?>
<?php

if (!(isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)) die;

$pid = isset($_GET['pid']) && is_numeric($_GET['pid']) ? (int)$_GET['pid'] : 0;

$test = isset($_POST['pid']) && isset($_POST['topic']) && 
        is_numeric($_POST['pid']) && is_string($_POST['topic']);

if ($test) {
    $pid = (int)$_POST['pid'];
    App::mod()->set('topic_id',$pid);
    $topic = substr($_POST['topic'],0,100);
    if ($topic!='') {
        $sql = "INSERT INTO topic (topic_pid, topic_name) VALUES (?,?)";
        $db = db_connect();
        $c = $db->prepare($sql);
        $c->execute(array($pid, $topic));
        $id = $db->lastInsertId();
        header('Location: index.php?cmd=node&id='.$id.'&r=1');
        exit;
    }
    echo view('tree-add.php', array('pid'=>$pid, 'topic'=>$topic));
}
else {
    App::mod()->set('topic_id',$pid);
    echo view('tree-add.php', array('pid'=>$pid));
}

?>
