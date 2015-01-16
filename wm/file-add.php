<?php if (!defined('WEBAPP')) die; ?>
<?php ob_start(); ?>

    <form action="index.php?cmd=file-add" method="post" enctype="multipart/form-data">
        <table class="input-form">
        <tbody>
        <tr>
            <td>File:</td>
            <td><input type="file" id="file" name="file" size="70" /></td>
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
    'menu' => view('menu-files.php'),
    'header' => 'New File',
    'content' => $r
));

?>
