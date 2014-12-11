<?php if (!defined('WEBAPP')) die; ?>
<?php

echo view('page.php', array(
    'header' => 'Subject X'.rand(1,1000)
));

?>
