<?php if (!defined('WEBAPP')) die; ?>
<?php ob_start(); ?>

<script type="text/javascript">
$(document).ready(function(){
    $('.delobj').click(function(){
        return confirm("Are you sure you want to delete?");
    })
});
</script>

<?php $r = ob_get_contents(); ob_end_clean(); ?>
<?php
if (!(isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)) die;

function listfiles() {
    $db = db_connect();
    $sql = "SELECT file_id, file_path FROM files ORDER BY file_id DESC";
    $s = '';   
    $c = 0;
    foreach($db->query($sql) as $row) {
        $c++;
        if ($c==1) {
            $s.='<table class="files">';
            $s.='<tr><th>template</th><th>filename</th><th>remove?</th></tr>';
        }
        $t = '<tr><td class="col1">{file#%s}</td><td><a href="%s">%s</a></td><td><a class="delobj" href="%s">remove</a></td></tr>';
        $u = 'index.php?cmd=file-get&id='.$row['file_id'];
        $d = 'index.php?cmd=file-del&id='.$row['file_id'];
        $s .= sprintf($t, $row['file_id'], $u, htmlspecialchars($row['file_path']), $d);
    }
    if ($c>0) $s.='</table>';
    return '<div class="files">'.$s.'</div>';
}

?>
<?php

echo view('page.php', array(
    'menu' => view('menu-files.php'),
    'header' => 'Files',
    'content' => $r.listfiles()
));

?>
