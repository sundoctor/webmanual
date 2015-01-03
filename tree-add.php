<?php if (!defined('WEBAPP')) die; ?>
<?php ob_start(); ?>

<script type="text/javascript">
$(document).ready(function(){
    $('#topic').focus();
});
</script>

    <form action="index.php?cmd=tree-add" method="post">
        <input type="hidden" name="pid" value="<?php echo isset($pid)?$pid:0; ?>" />
        <table class="input-form">
        <tbody>
        <tr>
            <td>Topic:</td>
            <td><input type="text" id="topic" name="topic" value="<?php echo isset($topic)?htmlspecialchars($topic):''; ?>" size="70" maxlength="100" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value=" Submit " /></td>
        </tr>
        </tbody>
        </table>
    </form>
    
<?php $r = ob_get_contents(); ob_end_clean(); ?>
<?php

echo view('page.php', array(
    'pos' => 'node',
    'header' => 'New Topic',
    'content' => $r
));

?>
