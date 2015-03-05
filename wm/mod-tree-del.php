<?php if (!defined('WEBAPP')) die; ?>
<?php

if (!App::mod()->registered()) die;

$id = isset($_GET['id']) && is_numeric($_GET['id'])? $_GET['id'] : 0;

if ($id>0) tree_del($id);

header('Location: index.php?cmd=welcome&r=1'); 

?>
