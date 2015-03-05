<?php if (!defined('WEBAPP')) die; ?>
<?php

$_SESSION[SECRET_KEY.'login']='';
header('Location: index.php'); 

?>
