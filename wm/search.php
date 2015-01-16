<?php if (!defined('WEBAPP')) die; ?>
<?php

function listview() {
    $db = db_connect();
    $where = '';
    if (isset($_POST['search']) && is_string($_POST['search'])) {
        $w = substr($_POST['search'], 0, 100);
        if (trim($w)!='') $where = sprintf("WHERE content_title LIKE %s", $db->quote("%$w%"));
    }
    $sql = "SELECT content_id, content_title FROM content $where ORDER BY content_title";
    $s = '';   
    foreach($db->query($sql) as $row) {
        $t = '<div class="subject"><a class="link" href="%s" target="right">%s</a></div>';
        $u = 'index.php?cmd=text&id='.$row['content_id'];
        $s .= sprintf($t, $u, htmlspecialchars($row['content_title']));
    }
    return '<div class="idxlist">'.$s.'</div>';
}

?>
<?php

echo view('page.php', array(
    'menu' => view('menu-left.php'),
    'header' => PROJECT_TITLE,
    'content' => listview()
));

?>
