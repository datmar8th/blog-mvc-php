<?php 
    global $mediaFiles;
    array_push($mediaFiles['css'], "media/css/users.css");
?>

<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>

<?php if (isset($_SESSION['auth'])) { 
    $data = $this->records;
    $params = (isset($this->records))? array('id'=>$this->records['id']):''; ?>
<form method="post" enctype="multipart/form-data" action="<?php echo html_helpers::url(
		array('ctl'=>'users', 
			  'act'=>$this->action, 
			  'params'=>$params
        )); ?>">
    <div class="row mb-3">
        <label for="name" class="col-sm-2 col-form-label">Full Name</label>
        <div class="col-sm-10">
        <input name="data[<?php echo $this->controller; ?>][fullname]" type="text" class="form-control" id="name" placeholder="name" value = "<?php echo $data['fullname'];?>">
        </div>
    </div>
    <div class="row mb-3">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
        <input name="data[<?php echo $this->controller; ?>][email]" type="text" class="form-control" id="email" placeholder="email" value = "<?php echo $data['email'];?>">
        </div>
    </div>
    <div class="row mb-3">
        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
        <div class="col-sm-10">
        <input name="data[<?php echo $this->controller; ?>][phone]" type="text" class="form-control" id="phone" placeholder="phone" value = "<?php echo $data['phone'];?>">
        </div>
    </div>
    <div class="row mb-3">
        <label for="address" class="col-sm-2 col-form-label">Address</label>
        <div class="col-sm-10">
        <input name="data[<?php echo $this->controller; ?>][address]" type="text" class="form-control" id="address" placeholder="address" value = "<?php echo $data['address'];?>">
        </div>
    </div>
    <div class="row mb-3">
        <label for="image" class="col-sm-2 col-form-label">Avatar</label>
        <div class="col-sm-10 image-upload">
            <input name="image" type="file" class="form-control" id="image" placeholder="image">
            <img src="<?php echo "media/upload/" .$this->controller.'/'.$data['avatar'];?>" 
            alt="<?php echo $data['fullname']; ?>" class="img-thumbnail profile-image">
        </div>
    </div>
    <div class="row mb-3">
        <div class="offset-sm-2 col-sm-10">
            <button name="edit-btn" type="submit" class="btn btn-outline-dark">Edit Profile</button>
        </div>
    </div>
</form>
<?php global $mediaFiles; ?>
<?php array_push($mediaFiles['js'], RootREL."media/js/jquery.min.js"); ?>
<?php array_push($mediaFiles['js'], RootREL."media/js/form.js"); ?>

<?php } else header( "Location: ".html_helpers::url(array('ctl'=>'users', 'act'=>'login')))?>

<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>
