<?php 
    global $mediaFiles;
    array_push($mediaFiles['css'], "media/css/users.css");
?>

<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>

<?php if (isset($_SESSION['auth'])) { 
    $data = $this->records;
    $params = (isset($this->records))? array('id'=>$this->records['id']):''; ?>
<form name="changepass-form" method="POST" enctype="multipart/form-data" class="changepass-form" action="<?php echo html_helpers::url(
		array('ctl'=>'users', 
			  'act'=>'change_password', 
			  'params'=>$params
        )); ?>">
    <div class="row mb-3">
        <label for="name" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
            <input name="data[<?php echo $this->controller; ?>][old-password]" type="password" class="form-control old-pass" placeholder="Password" require>
        </div>
    </div>
    <p class="mb-4 ms-5 error text-danger password-error"></p>

    <div class="row mb-3">
        <label for="email" class="col-sm-2 col-form-label">New password</label>
        <div class="col-sm-10">
            <input name="data[<?php echo $this->controller; ?>][new-password]" type="password" class="form-control new-pass" placeholder="New password" require>
        </div>
    </div>
    <p class="mb-4 ms-5 error text-danger new-pass-error"></p>

    <div class="row mb-3">
        <label for="phone" class="col-sm-2 col-form-label">Confirm password</label>
        <div class="col-sm-10">
            <input name="data[<?php echo $this->controller; ?>][confirm]" type="password" class="form-control confirm-pass" placeholder="Confirm password" require>
        </div>
    </div>
    <p class="mb-4 ms-5 error text-danger confirm-pass-error"></p>
    
    <div class="row mb-3">
        <div class="offset-sm-2 col-sm-10">
            <button name="change-password" type="submit" class="btn btn-outline-dark">Submit</button>
        </div>
    </div>
</form>
<?php if($this->errors) { ?>
    <div class="alert alert-danger alert-dismissible error-change" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $this->errors; ?>
    </div>
    <?php } ?>
<?php global $mediaFiles; ?>
<?php array_push($mediaFiles['js'], RootREL."media/js/jquery.min.js"); ?>
<?php array_push($mediaFiles['js'], RootREL."media/js/changepass.js"); ?>
<?php array_push($mediaFiles['js'], RootREL."media/bootstrap/js/bootstrap.min.js"); ?>

<?php } else header( "Location: ".html_helpers::url(array('ctl'=>'users', 'act'=>'login')))?>

<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>
