<?php if (!defined('WEBAPP')) die; ?>
<?php
if (!(isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)) die;

function listfiles() {
    $db = db_connect();
    $sql = "SELECT content_id, content_title FROM content ORDER BY content_title";
    $s = '';   
    foreach($db->query($sql) as $row) {
        $t = '<div class="subject"><a class="link" href="%s" target="right">%s</a></div>';
        $u = 'index.php?cmd=text&id='.$row['content_id'];
        $s .= sprintf($t, $u, htmlspecialchars('FILE '.$row['content_title']));
    }
    return '<div class="idxlist">'.$s.'</div>';
}

?>
<?php

echo view('page.php', array(
    'menu' => view('menu-files.php'),
    'header' => 'Files',
    'content' => listfiles()
));

?>
