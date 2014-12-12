<?php if (!defined('WEBAPP')) die; ?>
<?php

$id = isset($_GET['id']) && is_numeric($_GET['id'])? $_GET['id'] : 1;

App::mod()->set('text_id',$id);

echo view('page.php', array(
    'pos' => 'right',
    'header' => 'Subject #'.$id
    
));

?>
