<?php if (!defined('WEBAPP')) die; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
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
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
});
</script>

    <h1><?php echo PROJECT_TITLE; ?></h1>
    <?php echo view('menu.php'); ?>
    <hr />

<?php

function nodeview($pid=0) {
    $db = db_connect();
    $sql = "SELECT content_id, content_title FROM content WHERE content_topic_id=%d ORDER BY content_title";
    $sql = sprintf($sql, $pid);
    $s = '';   
    foreach($db->query($sql) as $row) {
        $t = '<div class="subject"><div><a class="link" href="%s" target="right">%s</a></div></div>';
        $s .= sprintf($t,'',htmlspecialchars($row['content_title']));
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
        $t = '<div><a class="link" href="%s" target="right">%s</a></div>';
        $s = sprintf($t, '', htmlspecialchars($row['topic_name']));
        $t = '<div class="submenu" style="%s">%s</div>';
        $display='display:none;';
        if ($text!='') $s.=sprintf($t,$display,$text);
        $t = '<div class="topic closed">%s</div>';
        $s = sprintf($t, $s);
        $r .= $s;
    }
    return $r;
}

echo treeview();
    
?>

    <hr />
    <p class="copyright">&copy; 2007-2014 Igor Salnikov</p>

</body>
</html>

