<?php if (!defined('WEBAPP')) die; ?>
<!DOCTYPE HTML>
<html>
<head>
    <title><?php echo $title; ?></title>
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
<?php echo $content; ?>
</body>
</html>

