<?php if (!defined('WEBAPP')) die; ?>
<?php

$id = isset($_GET['id']) && is_numeric($_GET['id'])? $_GET['id'] : 1;

App::mod()->set('topic_id',$id);

if (!isset($_SESSION['opened'])) $_SESSION['opened'] = array();

if (!isset($_SESSION['opened'][$id])) $_SESSION['opened'][$id]=true;
    else unset($_SESSION['opened'][$id]);

echo view('page.php', array(
    'pos' => 'node',
    'header' => 'Node #'.$id
));

?>
