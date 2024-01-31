<?php
global $mediaFiles;
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign up</title>
	<link rel="stylesheet" href="media/css/users.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet" />
</head>

<body>
	<section class="vh-100 bg-image">
		<div class="mask d-flex align-items-center h-100 gradient-custom-3">
			<div class="container h-100">
				<div class="row d-flex justify-content-center align-items-center h-100">
					<div class="col-12 col-md-9 col-lg-7 col-xl-6">
						<div class="card" style="border-radius: 15px;">
							<div class="card-body p-5">
								<h2 class="text-uppercase text-center mb-5">Create an account</h2>

								<?php
								$params = (isset($this->record)) ? array('id' => $this->record['id']) : '';
								?>

								<form name="register-form" method="POST" action="<?php echo html_helpers::url(
																						array(
																							'ctl' => 'users',
																							'act' => 'signup',
																							'params' => $params
																						)
																					); ?>" class="mb-md-5 mt-md-4 pb-5 form-register">

									<div class="form-outline">
										<input name="data[<?php echo $this->controller; ?>][fullname]" type="text" id="name" class="form-control form-control-lg" require />
										<label class="form-label" for="name">Name</label>
									</div>
									<p class="mb-4 error name-error"></p>

									<div class="form-outline">
										<input name="data[<?php echo $this->controller; ?>][username]" type="text" id="username" class="form-control form-control-lg" require />
										<label class="form-label" for="username">Username</label>
									</div>
									<p class="mb-4 error username-error"></p>

									<div class="form-outline">
										<input name="data[<?php echo $this->controller; ?>][email]" type="email" id="email" class="form-control form-control-lg" require />
										<label class="form-label" for="email">Email</label>
									</div>
									<p class="mb-4 error email-error"></p>

									<div class="form-outline">
										<input name="data[<?php echo $this->controller; ?>][password]" type="password" id="password" class="form-control form-control-lg" require />
										<label class="form-label" for="password">Password</label>
									</div>
									<p class="mb-4 error password-error"></p>

									<div class="form-outline">
										<input name="data[<?php echo $this->controller; ?>][confirm]" type="password" id="confirm-password" class="form-control form-control-lg" required />

										<label class="form-label" for="password">Confirm Password</label>
									</div>
									<p class="mb-4 error password-error"></p>

									<div class="d-flex justify-content-center">
										<button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" name="signup-user">
											Sign up
										</button>
									</div>

									<p class="text-center text-muted mt-5 mb-0">Have already an account?
										<a href="<?php echo html_helpers::url(['ctl' => 'users', 'act' => 'login']); ?>" class="fw-bold text-body">
											Login
										</a>
									</p>

								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>
	<script type="text/javascript" src="media/js/users.js"></script>
</body>

</html>