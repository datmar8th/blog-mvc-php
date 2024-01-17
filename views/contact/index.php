<?php
global $mediaFiles;
array_push($mediaFiles['css'], "media/css/contact.css");
?>

<?php include_once 'views/layout/' . $this->layout . 'header.php'; ?>
<div class="jumbotron">
	<h1>This is contact page</h1>
	<form class="form-horizontal">
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
				<input type="email" class="form-control" id="inputEmail3" placeholder="Email">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" id="inputPassword3" placeholder="Password">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label>
						<input type="checkbox"> Remember me
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Sign in</button>
			</div>
		</div>
	</form>
</div>
<?php array_push($mediaFiles['js'], "media/js/jquery.min.js"); ?>
<?php array_push($mediaFiles['js'], "media/js/contact.js"); ?>
<?php include_once 'views/layout/' . $this->layout . 'footer.php'; ?>