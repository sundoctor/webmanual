<?php if (!defined('WEBAPP')) die; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <h1><?php echo $header; ?></h1>
    <?php echo view('rmenu.php'); ?>
    <hr />
    <div class="vblock">
        <?php echo isset($content)? $content : ''; ?>
    </div>
    <hr />
    <p class="copyright">This page is created with WebManual v0.01</p>
</body>
</html>
