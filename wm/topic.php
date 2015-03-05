<?php if (!defined('WEBAPP')) die; ?>
<?php ob_start(); ?>
<script type="text/javascript">
$(document).ready(function(){
    $('.topic').click(function(){
        $(this).toggleClass('closed opened');
        $(this).children('.submenu').toggle();
        $.ajax({
            url: $(this).attr("url")
        });
        return false;
    });
    $('.submenu').click(function(){
        return false;
    });
    $('a.link').click(function(event){
        event.stopPropagation();
        if ($(this).attr("href").indexOf("cmd=node")>=0 || 
            $(this).attr("href").indexOf("cmd=text")>=0) {
            parent.right.location=$(this).attr("href");
            return true;
        } else 
            return false;
    });
});
</script>
<?php $js = ob_get_contents(); ob_end_clean(); ?>

<?php

function nodeview($pid=0) {
    $db = db_connect();
    $sql = "SELECT content_id, content_seq, content_title ".
           "FROM content WHERE content_topic_id=%d ORDER BY content_seq";
    $sql = sprintf($sql, $pid);
    $s = '';   
    foreach($db->query($sql) as $row) {
        $t = '<div class="subject"><div><a class="link" href="%s" target="right">%s</a></div></div>'."\n";
        $u = 'index.php?cmd=text&id='.$row['content_id'];
        $content_title = $row['content_title'];
        if (App::mod()->registered())
			$content_title = $row['content_seq'].'. '.$content_title;
        $s .= sprintf($t,$u,htmlspecialchars($content_title));
    }
    return $s;
}

function treeview($pid=0) {
    $db = db_connect();
    $sql = "SELECT * FROM topic WHERE topic_pid=%d ORDER BY topic_seq";
    $sql = sprintf($sql, $pid);
    $r = '';
    foreach($db->query($sql) as $row) {
        $topic = treeview($row['topic_id']);
        $node = nodeview($row['topic_id']);
        $text = $topic.$node;
        $t = '<div><a class="link" href="%s" target="right">%s</a></div>'."\n";
        $usw = 'index.php?cmd=switch&id='.$row['topic_id']; $u='';
        $topic_name = $row['topic_name'];
        if (App::mod()->registered()) {
            $u = 'index.php?cmd=node&id='.$row['topic_id'];
            $topic_name = $row['topic_seq'].'. '.$topic_name;
        }
        $s = sprintf($t, $u, htmlspecialchars($topic_name));
        $t = '<div class="submenu" style="%s">%s</div>'."\n";
        $display='display:none;';
        $test = isset($_SESSION[SECRET_KEY.'opened']) && is_array($_SESSION[SECRET_KEY.'opened']) &&
            isset($_SESSION[SECRET_KEY.'opened'][$row['topic_id']]);
        if ($test) $display='';
        $state=($display==''?'opened':'closed');
        if ($text!='') $s.=sprintf($t,$display,$text);
        $t = '<div class="topic '.$state.'" url="%s">%s</div>'."\n";
        $s = sprintf($t, $usw, $s);
        $r .= $s;
    }
    return $r;
}

?>
<?php

echo view('page.php', array(
    'menu' => view('menu-left.php'),
    'header' => PROJECT_TITLE,
    'content' => $js.treeview()
));

?>
