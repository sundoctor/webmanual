<?php if (!defined('WEBAPP')) die; ?>
<script type="text/javascript">
$(document).ready(function(){
	$('.delobj').click(function(){
		return confirm("Are you sure you want to delete?");
	})
});
</script>
    <ul class="mline">
        <li><a href="index.php?cmd=welcome">Home</a> | </li>
        <li><a href="index.php?cmd=favorite">Favorite</a> | </li>
        <li><a href="index.php?cmd=print&pid=<?php echo App::mod()->get('text_id'); ?>">Print</a></li>
<?php if (isset($_SESSION['login']) && $_SESSION['login']==ROOT_LOGIN): ?>
        <li>| <a href="index.php?cmd=textedit&pid=<?php echo App::mod()->get('text_id'); ?>">Edit</a></li>
        <li>| <a href="index.php?cmd=textmove&pid=<?php echo App::mod()->get('text_id'); ?>">Move</a></li>
        <li>| <a class="delobj" href="index.php?cmd=textdel&pid=<?php echo App::mod()->get('text_id'); ?>">Delete</a></li>
<?php endif; ?>
    </ul>
 
