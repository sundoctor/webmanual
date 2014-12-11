<?php if (!defined('WEBAPP')) die; ?>
    <ul class="mline">
        <li><a href="index.php" target="_top">Home</a> | </li>
        <li><a href="index.php?cmd=topic">Topics</a> | </li>
        <li><a href="index.php?cmd=idxlist">Index</a> | </li>
        <li><a class="search-button">Search</a> | </li>
        <li><a href="index.php?cmd=files" target="right">Files</a> | </li>
<?php if (isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN): ?>
        <li><a href="index.php?cmd=logout" target="_top">Logout</a></li>
<?php else: ?>
        <li><a href="index.php?cmd=login" target="_top">Login</a></li>
<?php endif; ?>
    </ul>
    <form action="index.php?cmd=search" class="search-form" style="display:none;">
        <input type="text" name="search" size="30" maxlength="100" />
        <input type="submit" value=" Go search! " />
    </form>
 
