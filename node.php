<?php if (!defined('WEBAPP')) die; ?>
<?php

$id = isset($_GET['id']) && is_numeric($_GET['id'])? $_GET['id'] : 0;

$refresh = isset($_GET['r']) && $_GET['r']==1? 1: 0;

App::mod()->set('topic_id',$id);

if (!isset($_SESSION['opened'])) $_SESSION['opened'] = array();

if (!isset($_SESSION['opened'][$id])) $_SESSION['opened'][$id]=true;
    else unset($_SESSION['opened'][$id]);

$row = tree_row($id);

echo view('page.php', array(
    'menu' => view('menu-node.php'),
    'refresh' => $refresh,
    'header' => $row['topic_name']
));

?>
