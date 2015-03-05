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
<?php if (App::mod()->registered()): ?>
        <li>| <a href="index.php?cmd=file-add">Add file</a></li>
<?php endif; ?>
    </ul>
 
