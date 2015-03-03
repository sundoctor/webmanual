<?php if (!defined('WEBAPP')) die; ?>
<?php
if (!(isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)) die;

function listfiles() {
    $db = db_connect();
    $sql = "SELECT * FROM files ORDER BY file_id DESC";
    $s = '';   
    $c = 0;
    foreach($db->query($sql) as $row) {
        $c++;
        if ($c==1) {
            $s.='<table class="files">';
            $cols = array('template','filename','filesize','dimension','remove?');
            $s.='<tr>'.implode('', array_map(function ($i) { return '<th>'.$i.'</th>';}, $cols)).'</tr>';
        }
        $t = '<tr><td class="col1">{-%s:%s-}</td>'.
            '<td><a href="%s" target="_blank">%s</a></td>'.
            '<td>%s</td><td>%s</td>'.
            '<td><a class="delobj" href="%s">remove</a></td></tr>';
        $u = 'index.php?cmd=file-get&id='.$row['file_id'];
        $d = 'index.php?cmd=file-del&id='.$row['file_id'];
        $p = in_array($row['file_type'], array('jpg','gif','png'))? 'IMG':'FILE';
        $s .= sprintf($t, $p, $row['file_id'], $u, htmlspecialchars($row['file_path']), 
            $row['file_size'], $row['file_sx'].'x'.$row['file_sy'],$d);
    }
    if ($c>0) $s.='</table>';
    return '<div class="files">'.$s.'</div>';
}

?>
<?php

echo view('page.php', array(
    'menu' => view('menu-files.php'),
    'header' => 'Files',
    'content' => listfiles()
));

?>
