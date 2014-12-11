<?php if (!defined('WEBAPP')) die; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
    <title><?php echo PROJECT_TITLE; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <form action="index.php?cmd=login" method="post">
        <table class="login-form">
        <tbody>
        <tr>
            <td>Login:</td>
            <td><input type="text" name="login" value="<?php echo htmlspecialchars($login); ?>" size="20" maxlength="50" /></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="pass" value="" size="20" maxlength="50" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value=" Login " /></td>
        </tr>
        </tbody>
        </table>
    </form>
</body>
</html>
