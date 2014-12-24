<?php if (!defined('WEBAPP')) die; ?>
<?php

$id = isset($_GET['id']) && is_numeric($_GET['id'])? $_GET['id'] : 1;

if (!isset($_SESSION['opened'])) $_SESSION['opened'] = array();

if (!isset($_SESSION['opened'][$id])) $_SESSION['opened'][$id]=true;
    else unset($_SESSION['opened'][$id]);

echo jsonencode(array());

?>
