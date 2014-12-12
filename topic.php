<?php if (!defined('WEBAPP')) die; ?>
<?php ob_start(); ?>
<script type="text/javascript">
$(document).ready(function(){
    $('.topic').click(function(){
        $(this).toggleClass('closed opened');
        $(this).children('.submenu').toggle();
        return false;
    });
    $('.submenu').click(function(){
        return false;
    });
    $('a.link').click(function(){
        if ($(this).attr("href")) {
            parent.right.location=$(this).attr("href");
            return true;
        }
    });
});
</script>
<?php $js = ob_get_contents(); ob_end_clean(); ?>

<?php

function nodeview($pid=0) {
    $db = db_connect();
    $sql = "SELECT content_id, content_title FROM content WHERE content_topic_id=%d ORDER BY content_title";
    $sql = sprintf($sql, $pid);
    $s = '';   
    foreach($db->query($sql) as $row) {
        $t = '<div class="subject"><div><a class="link" href="%s" target="right">%s</a></div></div>'."\n";
        $u = 'index.php?cmd=text&id='.$row['content_id'];
        $s .= sprintf($t,$u,htmlspecialchars($row['content_title']));
    }
    return $s;
}

function treeview($pid=0) {
    $db = db_connect();
    $sql = "SELECT * FROM topic WHERE topic_pid=%d ORDER BY topic_name";
    $sql = sprintf($sql, $pid);
    $r = '';
    foreach($db->query($sql) as $row) {
        $topic = treeview($row['topic_id']);
        $node = nodeview($row['topic_id']);
        $text = $topic.$node;
        $t = '<div><a class="link" href="%s" target="right">%s</a></div>'."\n";
        $u = 'index.php?cmd=node&id='.$row['topic_id'];
        $s = sprintf($t, $u, htmlspecialchars($row['topic_name']));
        $t = '<div class="submenu" style="%s">%s</div>'."\n";
        $display='display:none;';
        $test = isset($_SESSION['opened']) && is_array($_SESSION['opened']) &&
            isset($_SESSION['opened'][$row['topic_id']]);
        if ($test) $display='';
        $state=($display==''?'opened':'closed');
        if ($text!='') $s.=sprintf($t,$display,$text);
        $t = '<div class="topic '.$state.'">%s</div>'."\n";
        $s = sprintf($t, $s);
        $r .= $s;
    }
    return $r;
}

?>
<?php

echo view('page.php', array(
    'pos' => 'left',
    'header' => PROJECT_TITLE,
    'content' => $js.treeview()
));

?>
