<?php if (!defined('WEBAPP')) die; ?>
<?php

$id = isset($_GET['id']) && is_numeric($_GET['id'])? $_GET['id'] : 1;

if (!isset($_SESSION[SECRET_KEY.'opened'])) $_SESSION[SECRET_KEY.'opened'] = array();

if (!isset($_SESSION[SECRET_KEY.'opened'][$id])) $_SESSION[SECRET_KEY.'opened'][$id]=true;
    else unset($_SESSION[SECRET_KEY.'opened'][$id]);

echo json_encode(array());

?>
