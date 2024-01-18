<?php
global $mediaFiles;
array_push($mediaFiles['css'], "/php-mvc/media/css/home1.css");
array_push($mediaFiles['css'], RootREL . 'media/fontawesome/css/all.css');
//$blog = blog_model::getRecord('*', 'published = 1');
?>
<?php include_once 'views/layout/' . $this->layout . 'header.php'; ?>
<div class="content">
	<h2>List blogs</h2>
	<?php $blogs = $this->records; ?>
	<div class="row">
		<div class="col-9">
			<?php if (count($blogs)) { ?>
				<?php foreach ($blogs as $blog) { ?>
					<div class="row blog-card">
						<div class="col-1">
							<a class="text-decoration-none" href="<?php echo html_helpers::url(['ctl' => 'users', 'act' => 'user_profile']); ?>">
								<img alt="avatar" class="rounded-circle img-fluid profile-avatar" src="media/upload/users/<?php if (empty($blog['avatar'])) {
																																echo 'avatar-default.png';
																															} else echo $blog['avatar'] ?>"></a>
						</div>
						<div class="col-11">
							<div class="d-flex">
								<a class="text-decoration-none " href="<?php echo html_helpers::url(['ctl' => 'users', 'act' => 'user_profile']); ?>">
									<div class="user-info">
										<h5 class="my-3"><?php echo $blog['fullname'] ?></h5>
									</div>
								</a>
								<div class="user-info">
										<h5 class="my-3"><?php echo $blog['blogs_created']; ?></h5>
								</div>
							</div>
							<a class="text-decoration-none" href="<?php echo html_helpers::url(
									[
										'ctl' => 'blogs',
										'act' => 'view',
										'params' => array(
											'id' => $blog['blog_id'],
											'slug' => $blog['slug']
										)
									]
								); ?>">
									<h2><?php echo $blog['title'] ?></h2>
									<div class="fakeimg"><img src="<?php echo "media/upload/blogs" . '/' . $blog['image']; ?>" alt="<?php echo $blog['id']; ?>" class="img-thumbnail"></div>
								</a>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="col-3">
			<div class="blog-card">
				<h2>About Me</h2>
				<div class="fakeimg">
					Image
				</div>
				<p>Some text about me in culpa qui officia deserunt mollit anim..</p>
			</div>
			<div class="blog-card">
				<h3>Popular Post</h3>
				<div class="fakeimg">Image</div><br>
				<div class="fakeimg">Image</div><br>
				<div class="fakeimg">Image</div>
			</div>
			<div class="blog-card">
				<h3>Follow Me</h3>
				<p>Some text..</p>
			</div>
		</div>
	</div>
</div>
<?php include_once 'views/layout/' . $this->layout . 'footer.php'; ?>