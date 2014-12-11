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
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
});
</script>
    <h1><?php echo PROJECT_TITLE; ?></h1>
    <?php echo view('menu.php'); ?>
    <hr />
    <div class="idxlist">
        <div class="subject"><a class="link" href="subject1.html" target="right">Содержание 1</a></div>
        <div class="subject"><a class="link" href="subject2.html" target="right">Содержание 2</a></div>
    </div>
    <hr />
    <p class="copyright">&copy; 2007-2014 Igor Salnikov</p>

</body>
</html>
