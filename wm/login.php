<?php if (!defined('WEBAPP')) die; ?>
<?php ob_start(); ?>

<script type="text/javascript">
$(document).ready(function(){
    $('#login').focus();
});
</script>
    <form action="index.php?cmd=login" method="post">
        <table class="login-form">
        <tbody>
        <tr>
            <td>Login:</td>
            <td><input type="text" id="login" name="login" value="<?php echo htmlspecialchars($login); ?>" size="20" maxlength="50" /></td>
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
    
<?php $r = ob_get_contents(); ob_end_clean(); ?>
<?php echo view('center.php', array('title'=>PROJECT_TITLE, 'content'=>$r)); ?>
