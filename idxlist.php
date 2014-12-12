<?php if (!defined('WEBAPP')) die; ?>
<?php

function listview() {
    $db = db_connect();
    $sql = "SELECT content_id, content_title FROM content ORDER BY content_title";
    $sql = sprintf($sql);
    $s = '';   
    foreach($db->query($sql) as $row) {
        $t = '<div class="subject"><a class="link" href="%s" target="right">%s</a></div>';
        $u = 'index.php?cmd=subject&id='.$row['content_id'];
        $s .= sprintf($t, $u, htmlspecialchars($row['content_title']));
    }
    return '<div class="idxlist">'.$s.'</div>';
}

?>
<?php

echo view('page.php', array(
    'pos' => 'left',
    'header' => PROJECT_TITLE,
    'content' => listview()
));

?>
