<?php if (!defined('WEBAPP')) die; ?>
<?php

$id = isset($_GET['id']) && is_numeric($_GET['id'])? $_GET['id'] : 1;

$refresh = isset($_GET['r']) && $_GET['r']==1? 1: 0;

$row = text_row($id);

App::mod()->set('text_id',$id);

$t = 'Text #'.$id;
echo view('page.php', array(
    'id' => $id,
    'menu' => view('menu-right.php'),
    'refresh' => $refresh,
    'title' => htmlspecialchars($row['content_title']),
    'header' => htmlspecialchars($row['content_title']),
    'content' => $row['content']
));

?>
