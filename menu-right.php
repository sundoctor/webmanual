<?php if (!defined('WEBAPP')) die; ?>
<script type="text/javascript">
$(document).ready(function(){
    $('.delobj').click(function(){
        return confirm("Are you sure you want to delete?");
    })
});
</script>
    <ul class="mline">
        <li><a href="index.php?cmd=welcome">Home</a></li>
<?php if (App::mod()->get('text_id')!=''): ?>
        <li>| <a href="index.php?cmd=text-print&id=<?php echo App::mod()->get('text_id'); ?>">Print</a></li>
<?php endif; ?>
<?php if (isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN): ?>
<?php if (App::mod()->get('text_id')!=''): ?>
        <li>| <a href="index.php?cmd=text-edit&id=<?php echo App::mod()->get('text_id'); ?>">Edit</a></li>
        <li>| <a href="index.php?cmd=text-move&id=<?php echo App::mod()->get('text_id'); ?>">Move</a></li>
        <li>| <a class="delobj" href="index.php?cmd=text-del&id=<?php echo App::mod()->get('text_id'); ?>">Delete</a></li>
<?php endif; ?>
<?php endif; ?>
    </ul>
 
