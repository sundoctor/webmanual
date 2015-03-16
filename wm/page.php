<?php if (!defined('WEBAPP')) die; ?>
<!DOCTYPE HTML>
<html>
<head>
<?php if (isset($title)): ?>
    <title><?php echo $title; ?></title>
<?php endif; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    
<script type="text/javascript">
$(document).ready(function(){
    var id=<?php echo isset($id)?$id:0; ?>;
    if (!parent.left && id) parent.location.href='index.php?id='+id;
    var rs=<?php echo (isset($refresh) && $refresh==1?1:0); ?>;
    if (rs && parent.left) parent.left.location.reload();
    $('#cpy').click(function(){
        window.clipboardData.setData("Text",location.href);
        alert('This page URL now is in clipboard!');
        return false;
    });
});
</script>

    <h1><?php echo $header; ?></h1>
    <?php echo $menu; ?>
    <hr />
    <div class="vblock">
    <?php echo isset($content)? $content : ''; ?>
    </div>
    <hr />
    <p class="copyright"><?php echo APPLICATION; ?> v<?php echo VERSION; ?> &copy; 2007-<?php echo date('Y'); ?> Igor Salnikov aka SunDoctor</p>
    
</body>
</html>
