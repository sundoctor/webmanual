<?php if (!defined('WEBAPP')) die; ?>
<?php ob_start(); ?>

<script type="text/javascript">
$(document).ready(function(){
    $('#title').focus();
});
</script>

    <form action="index.php?cmd=text-edit" method="post">
        <input type="hidden" name="id" value="<?php echo isset($id)?$id:0; ?>" />
        <table class="input-form">
        <tbody>
        <tr>
            <td>Title:</td>
            <td><input type="text" id="title" name="title" value="<?php echo isset($title)?htmlspecialchars($title):''; ?>" size="70" maxlength="100" /></td>
        </tr>
        <tr>
            <td>Text:</td>
            <td><textarea name="text" cols="70" rows="15"><?php echo isset($text)?htmlspecialchars($text):''; ?></textarea></td>
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
    'menu' => view('menu-right.php'),
    'header' => 'Edit Text',
    'content' => $r
));

?>
