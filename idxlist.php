<?php if (!defined('WEBAPP')) die; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<script type="text/javascript">
$(document).ready(function(){
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
});
</script>

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
    return $s;
}

?>

    <h1><?php echo PROJECT_TITLE; ?></h1>
    <?php echo view('menu.php'); ?>
    <hr />
    <div class="vblock">
    <div class="idxlist">
        <?php echo listview(); ?>
    </div>
    </div>
    <hr />
    <p class="copyright">&copy; 2007-2014 Igor Salnikov</p>

</body>
</html>
