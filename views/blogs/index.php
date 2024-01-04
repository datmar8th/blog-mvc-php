<?php
	global $mediaFiles;
	array_push($mediaFiles['css'], "media/css/blogs.css");
	array_push($mediaFiles['css'], RootREL.'media/fontawesome/css/all.css');
?>

<?php include_once 'views/layout/' . $this->layout . 'header.php'; ?>

<div class="row row-offcanvas row-offcanvas-right">
	<div class="col-xs-12 col-sm-9">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="5%">Id</th>
						<th width="20%">Title</th>
						<th width="10%">Category</th>
						<th width="30%">Photo</th>
						<th width="15%">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($this->records) { ?>
						<?php while ($row = mysqli_fetch_array($this->records)) : ?>
							<tr>
								<td width="5%"><?php echo $row['id']; ?></td>
								<td width="20%"><?php echo $row['title']; ?></td>
								<td width="10%"><?php echo $row['category']; ?></td>
								<td width="20%"><img src="<?php echo "media/upload/" . $this->controller . '/' . $row['image']; ?>" alt="<?php echo $row['id']; ?>" class="img-thumbnail"></td>
								<td width="10%">
									<a class="btn btn-outline-info table-link" role="button" href="<?php echo html_helpers::url(
																										[
																											'ctl' => 'blogs',
																											'act' => 'view',
																											'params' => array(
																												'id' => $row['id'],
																												'slug' => $row['slug']																												
																											)
																										]
																									); ?>">
										<i class="fa-solid fa-eye" aria-hidden="true"></i>
									</a>
									<a class="btn btn-outline-warning" role="button" href="<?php echo html_helpers::url(
																								array(
																									'ctl' => 'blogs',
																									'act' => 'edit',
																									'params' => array(
																										'id' => $row['id']
																									)
																								)
																							); ?>">
										<i class="fas fa-edit"></i>
									</a>
									<a class="btn btn-outline-danger table-link danger delete" role="button" href="<?php echo html_helpers::url(
																														array(
																															'ctl' => 'blogs',
																															'act' => 'del',
																															'params' => array(
																																'id' => $row['id']
																															)
																														)
																													); ?>">
										<i class="fas fa-trash"></i>
									</a>
								</td>
							</tr>
						<?php endwhile; ?>
					<?php } else { ?>
						<tr>
							<td colspan="7" scope="row">There are no blog!</td>
						</tr>
					<?php }  ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
		<?php include_once 'views/widgets/sidebar_blog.php'; ?>
	</div>
</div>
<?php include_once 'views/layout/' . $this->layout . 'footer.php'; ?>