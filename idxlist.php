<?php if (!defined('WEBAPP')) die; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
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
    'content' => $js.listview()
));

?>
