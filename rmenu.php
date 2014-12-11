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
        <li><a href="index.php?cmd=print">Print</a></li>
        <li>| <a href="index.php?cmd=print">Edit</a></li>
        <li>| <a class="delobj" href="index.php?cmd=print">Delete</a></li>
    </ul>
 
