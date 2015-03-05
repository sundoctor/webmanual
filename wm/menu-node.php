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
        <li>| <a href="index.php?cmd=tree-add&pid=<?php echo App::mod()->get('topic_id'); ?>">Add</a></li>
    <?php if (App::mod()->get('topic_id')>0): ?>
        <li>| <a href="index.php?cmd=tree-edit&id=<?php echo App::mod()->get('topic_id'); ?>">Edit</a></li>
        <li>| <a href="index.php?cmd=tree-move&id=<?php echo App::mod()->get('topic_id'); ?>">Move</a></li>
        <li>| <a class="delobj" href="index.php?cmd=tree-del&id=<?php echo App::mod()->get('topic_id'); ?>">Delete</a></li>
        <li>| <a href="index.php?cmd=text-add&pid=<?php echo App::mod()->get('topic_id'); ?>">Add text</a></li>
    <?php endif; ?>
<?php endif; ?>
    </ul>
 
