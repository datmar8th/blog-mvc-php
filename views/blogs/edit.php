<?php
global $mediaFiles;
array_push($mediaFiles['css'], "media/css/add_blog.css");
array_push($mediaFiles['css'], RootREL . 'media/bootstrap/css/bootstrap.min.css');
?>

<?php include_once 'views/layout/' . $this->layout . 'header.php'; ?>

<?php if (isset($_SESSION['auth'])) {

    $params = (isset($this->records)) ? array('id' => $this->records['id']) : ''; ?>

    <section class="set-background">
        <section class="container bg-light ">
            <h1 class="row justify-content-center">EDIT BLOG</h1>

            <form enctype="multipart/form-data" name="edit_blog" class="p-3" action="<?php echo html_helpers::url(
                                                                                            array(
                                                                                                'ctl' => 'blogs',
                                                                                                'act' => 'editSubmit',
                                                                                                'params' => $params
                                                                                            )
                                                                                        ); ?>" method="post">
                <div class="row mb-3 flex-column">
                    <label for="title-blog" class="col-sm-2 col-form-label mb-1">Title</label>
                    <div class="col-sm-10">
                        <input name="data[<?php echo $this->controller; ?>][title]" type="text" id="title-blog" class="w-75 form-control" value="<?php echo (isset($this->records)) ? $this->records['title'] : ""; ?>">
                    </div>
                </div>

                <div class="row mb-3 flex-column">
                    <label for="image" class="col-sm-2 col-form-label mb-1">Image</label>
                    <div class="col-sm-10 image-upload">
                        <input name="image" type="file" class="form-control w-75" id="image" placeholder="image">
                        <img <?php if (!empty($this->records['image'])) {
                                    echo "src='media/upload/" . $this->controller . '/' . $this->records['image'] . "' " . "alt='" . $this->records['id'] . "'";
                                } else { ?> src="<?php echo RootREL; ?>media/img/avatar_default.png" alt='default' <?php } ?> class="img-thumbnail profile-image" name="data[<?php echo $this->controller; ?>][image]">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="content-blog" class="col-sm-2 col-form-label mb-1">Content</label>
                    <div>
                        <textarea name="data[<?php echo $this->controller; ?>][content]" id="content-blog"> <?php echo (isset($this->records)) ? $this->records['content'] : ""; ?> </textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="d-flex justify-content-center">
                        <button name="edit_blog" type="submit" class="btn btn-custom-auth text-light">Edit</button>
                    </div>
                </div>
            </form>
        </section>
    </section>
<?php } else header("Location: " . html_helpers::url(array('ctl' => 'users', 'act' => 'login'))) ?>

<script src="<?php echo RootREL; ?>media/js/jquery.min.js"></script>
<script src="<?php echo RootREL; ?>media/js/form.js"></script>
<script src="<?php echo RootREL; ?>media/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo RootREL; ?>media/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content-blog');
</script>

<?php include_once 'views/layout/' . $this->layout . 'footer.php'; ?>