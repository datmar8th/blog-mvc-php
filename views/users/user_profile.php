<?php
global $mediaFiles;
array_push($mediaFiles['css'], "media/css/users.css");
?>

<?php include_once 'views/layout/' . $this->layout . 'header.php'; ?>

<?php if (isset($_SESSION['auth'])) {
	$data = $this->records; ?>
	<section class="profile-page">
		<div class="container py-5">
			<div class="row">
				<div class="col">
					<nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
						<ol class="breadcrumb mb-0">
							<li class="breadcrumb-item"><a href="<?php echo html_helpers::url(['ctl' => 'home']); ?>">Home</a></li>
							<li class="breadcrumb-item"><a href="<?php echo html_helpers::url(['ctl' => 'users']); ?>">User</a></li>
							<li class="breadcrumb-item active" aria-current="page">User Profile</li>
						</ol>
					</nav>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4">
					<div class="card mb-4">
						<div class="card-body text-center">
							<img alt="avatar" class="rounded-circle img-fluid profile-avatar" src="media/upload/users/<?php if (empty($data['avatar'])) {
																															echo 'avatar-default.png';
																														} else echo $data['avatar'] ?>">
							<h5 class="my-3"><?php echo $data['fullname'] ?></h5>
							<!-- <p class="text-muted mb-1">Career: <?php echo $data['career'] ?></p> -->
							<!-- <p class="text-muted mb-4">Address: <?php echo $data['address'] ?></p> -->
						</div>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="card mb-4">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
									<p class="mb-0">Fullname</p>
								</div>
								<div class="col-sm-9">
									<p class="text-muted mb-0"><?php echo $data['fullname'] ?></p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-3">
									<p class="mb-0">Username</p>
								</div>
								<div class="col-sm-9">
									<p class="text-muted mb-0"><?php echo $data['username'] ?></p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-3">
									<p class="mb-0">Email</p>
								</div>
								<div class="col-sm-9">
									<p class="text-muted mb-0"><?php echo $data['email'] ?></p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-3">
									<p class="mb-0">Phone</p>
								</div>
								<div class="col-sm-9">
									<p class="text-muted mb-0"><?php echo $data['phone']; ?></p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-3">
									<p class="mb-0">Address</p>
								</div>
								<div class="col-sm-9">
									<p class="text-muted mb-0"><?php echo $data['address'] ?></p>
								</div>
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end">
						<a href="<?php echo html_helpers::url(['ctl' => 'users', 'act' => 'edit_profile']); ?>" class="btn btn-outline-dark ">Edit</a>
					</div>

				</div>
			</div>
		</div>
	</section>
<?php } else header("Location: " . html_helpers::url(array('ctl' => 'users', 'act' => 'login'))) ?>

<?php include_once 'views/layout/' . $this->layout . 'footer.php'; ?>