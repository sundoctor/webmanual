<?php if (!defined('WEBAPP')) die; ?>
<?php

if (!(isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)) die;

$id = isset($_GET['id']) && is_numeric($_GET['id'])? $_GET['id'] : 0;

if ($id>0) treedel($id);

header('Location: index.php?cmd=welcome&r=1'); 

?>
