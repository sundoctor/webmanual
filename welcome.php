<?php if (!defined('WEBAPP')) die; ?>
<?php ob_start(); ?>

    <h1>Welcome to the WebManual!</h1>
    <ul class="mline">
        <li><b>WebManual is free opensource system for fast network manual building</b></li>
    </ul>
    <hr />
    <div class="vblock">
        <p>Hello world!</p>
        <p>You can change this starting text in file <b><?php echo __FILE__; ?></b></p>
    </div>
    <hr />
    <p class="copyright">This page is created with <?php echo APPLICATION; ?> v<?php echo VERSION; ?></p>

<?php $r = ob_get_contents(); ob_end_clean(); ?>
<?php echo view('center.php', array('title'=>PROJECT_TITLE, 'content'=>$r)); ?>
