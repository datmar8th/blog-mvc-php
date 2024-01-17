<?php 
	global $obMediaFiles;
	array_push($obMediaFiles['css'], "media/css/sidebar_blog.css");
?>
<div class="list-group">
	<a href="#" class="list-group-item active">
		<h4 class="list-group-item-heading">Management blogs</h4>
	</a>
	<a href="<?php echo html_helpers::url(array('ctl'=>'blogs')); ?>" class="list-group-item">List all blogs</a>
	<a href="<?php echo html_helpers::url(array('ctl'=>'blogs', 'act'=>'add')); ?>" class="list-group-item">Add new blogs</a>
</div>
