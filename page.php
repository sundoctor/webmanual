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
    var b=<?php echo (isset($refresh) && $refresh==1?1:0); ?>;
    if (b) parent.left.location.reload();
});
</script>

    <h1><?php echo $header; ?></h1>
    <?php echo view($pos=='right'?'menu-right.php': ($pos=='left'? 'menu-left.php': 'menu-node.php')); ?>
    <hr />
    <div class="vblock">
    <?php echo isset($content)? $content : ''; ?>
    </div>
    <hr />
    <?php if ($pos=='right'): ?>
    <p class="copyright">This page is created with <?php echo APPLICATION; ?> v<?php echo VERSION; ?></p>
    <?php else: ?>
    <p class="copyright">&copy; 2007-<?php echo date('Y'); ?> Igor Salnikov</p>
    <?php endif; ?>
    
</body>
</html>
