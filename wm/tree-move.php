<?php if (!defined('WEBAPP')) die; ?>
<?php ob_start(); ?>

    <form action="index.php?cmd=tree-move" method="post">
        <input type="hidden" name="id" value="<?php echo isset($id)?$id:0; ?>" />
        <?php
            echo tree_list(0,0,$id);
        ?>
        <input type="submit" value=" Move to " />
    </form>
    
<?php $r = ob_get_contents(); ob_end_clean(); ?>
<?php

echo view('page.php', array(
    'menu' => view('menu-right.php'),
    'header' => 'Move Topic',
    'content' => $r
));

?>
