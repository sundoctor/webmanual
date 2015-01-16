<?php if (!defined('WEBAPP')) die; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
    <title><?php echo PROJECT_TITLE; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>
<?php $start = (isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN)?
    "index.php?cmd=node&id=0" : "index.php?cmd=welcome"; ?>
<frameset cols="35%,*" frameborder="1" framespacing="1">
    <frame id="left" name="left" src="index.php?cmd=topic">
    <frame id="right" name="right" src="<?php echo $start; ?>">
</frameset>
</html>
