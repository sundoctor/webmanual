<?php if (!defined('WEBAPP')) die; ?>
<?php

echo view('page.php', array(
    'pos' => 'right',
    'header' => 'Subject X'.rand(1,1000)
    
));

?>
