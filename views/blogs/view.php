<?php
global $mediaFiles;
array_push($mediaFiles['css'], "media/css/blogs.css");
array_push($mediaFiles['css'], "media/css/view_blog.css");
array_push($mediaFiles['css'], RootREL . 'media/fontawesome/css/all.css');
?>

<?php include_once 'views/layout/' . $this->layout . 'header.php'; ?>
<?php if (isset($_SESSION['auth'])) {
    $data = $_SESSION['auth'];
    $params = (isset($this->records)) ? array('id' => $this->records['id']) : ''; ?>
    <h1 class="my-3"><?php echo $this->records['title'];?></h2>
    <h5 class="content"><?php echo $this->records['created']; ?></h5>
    <h5 class="content"><?php echo $this->records['content']; ?></h5>
    <section class="content-item mt-3" id="comments">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10 comment-contain">
                    <form name="comment-form" class="comment-form">
                        <h3>Comment</h3>
                        <fieldset>
                            <div class="row">
                                <div class="col-sm-3 col-lg-2">
                                    <img class="rounded-circle w-75 h-75" src="media/upload/users/<?php if (empty($data['avatar'])) {
																										echo 'avatar-default.png';
																										} else echo $data['avatar'] ?>">
                                </div>
                                <div class="form-group col-xs-12 col-sm-9 col-lg-10">
                                    <textarea name="comment_content" class="form-control" id="message" placeholder="Your comment" required></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <div class="d-flex justify-content-end">
                            <button data-blog="<?php echo $this->records['id'] ?>" name="comment-btn" type="" class="btn btn-custom-auth text-light comment-btn" alt="" >Comment</button>
                        </div>
                    </form>

                    <h3 id="comment-count"><?php echo count($this->commentRecords); ?> Comments</h3>

                    <div class="comment-ances">
                        <?php foreach ($this->commentRecords as $datas) { ?>
                            <div alt="<?php echo $datas['id']; ?>" class="media d-flex flex-column <?php if (substr_count($datas['path'], '.') == 1) echo 'ms-5';
                                                                                                    elseif (substr_count($datas['path'], '.') > 1) echo 'ms-6' ?>">
                                <div class="d-flex flex-row">
                                    <a class="col-lg-2 pull-left" href="#"><img class="w-75 h-75 rounded-circle" src="media/upload/users/<?php if (empty($datas['avatar'])) {
																															                    echo 'avatar-default.png';
																														                        } else echo $datas['avatar'] ?>"></a>
                                    <div class="col-lg-10 media-body flex-grow-1">
                                        <h4 class="media-heading"><?php echo $datas['fullname']; ?></h4>
                                        <p><?php echo $datas['comment_content'] ?></p>

                                        <div class="justify-content-between">
                                            <ul class="list-unstyled list-inline media-detail d-flex">
                                                <li>
                                                    <i class="fa fa-calendar"></i>
                                                    <span>
                                                        <?php echo $datas['created'] ?>
                                                    </span>
                                                </li>
                                                <li class="like-group" alt="<?php echo $datas['id'] ?>">
                                                    <i class="fa fa-thumbs-up"></i>
                                                    <span class="like-count" alt="<?php echo $datas['id'] ?>">
                                                        <?php echo $datas['like_count']; ?>
                                                    </span>
                                                </li>
                                            </ul>
                                            <br>
                                            <ul class="list-unstyled list-inline media-detail d-flex icon">
                                                <li>
                                                    <a class="like-btn <?php if (in_array($datas['id'], $this->likeRecords)) {
                                                                            echo "liked";
                                                                        } ?>" alt="<?php echo $datas['id']; ?>">
                                                        <i class="fa-solid fa-thumbs-up like-icon"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="reply-btn" alt="<?php echo $datas['id']; ?>">
                                                        <i class="fa-regular fa-message-dots"></i>
                                                    </a>
                                                </li>
                                                <?php if ($_SESSION['auth']['id'] == $datas['user_id']) { ?>
                                                    <li>
                                                        <a class="edit-btn" alt="<?php echo $datas['id']; ?>">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="delete-btn" alt="<?php echo $datas['id']; ?>">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="reply-comment" alt="<?php echo $datas['id'] ?>">
                                    <form name="reply-form" class="reply-form ps-5 mt-3">
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-sm-3 col-lg-2">
                                                    <img class="rounded-circle" src="media/upload/users/<?php if (empty($data['avatar'])) {
																												echo 'avatar-default.png';
																												} else echo $data['avatar'] ?>">
                                                </div>
                                                <div class="form-group col-xs-12 col-sm-9 col-lg-10">
                                                    <textarea name="reply_comment_content" class="reply-content form-control" alt="<?php echo $datas['id'] ?>" placeholder="Your comment" required></textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-light cancel-reply-btn">Cancel</button>
                                            <button name="reply" type="button" class="btn btn-custom-auth text-light reply-button" alt="<?php echo $datas['id'] ?>" data-blog="<?php echo $this->records['id'] ?>">Reply</button>
                                        </div>
                                    </form>
                                </div>
                                <?php if ($_SESSION['auth']['id'] == $datas['user_id']) { ?>
                                    <div class="edit-comment" alt="<?php echo $datas['id'] ?>">
                                        <form name="edit-form" class="edit-form ps-5 mt-3">
                                            <h3 class="ps-4">Edit</h3>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-sm-3 col-lg-2">
                                                        <img class="rounded-circle" src="media/upload/users/<?php if (empty($data['avatar'])) {
																												echo 'avatar-default.png';
																												} else echo $data['avatar'] ?>">
                                                    </div>
                                                    <div class="form-group col-xs-12 col-sm-9 col-lg-10">
                                                        <textarea name="edit_comment_content" class="edit-content form-control" alt="<?php echo $datas['id'] ?>" value="<?php echo $datas['comment_content'] ?>" required></textarea>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-light cancel-edit-btn">Cancel</button>
                                                <button name="edit" type="button" class="btn btn-custom-auth text-light edit-button" alt="<?php echo $datas['id'] ?>">Edit</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php } ?>
                                <div class="comment-reply ps-5" alt="<?php echo $datas['id'] ?>">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var auth_avt = "<?php if (empty($data['avatar'])) {
                                echo 'avatar-default.png';
                                } else echo $data['avatar'] ?>",
            blog_id = "<?php echo $this->records['id'] ?> "
            auth_fullname = "<?php echo $_SESSION['auth']['fullname'] ?>";
        
    </script>                                                                                                                                                                       
<?php } else header("Location: " . html_helpers::url(array('ctl' => 'users', 'act' => 'login'))) ?>

<?php global $mediaFiles; ?>
<?php array_push($mediaFiles['js'], RootREL . "media/js/jquery.min.js"); ?>
<?php array_push($mediaFiles['js'], RootREL . "media/js/blogs.js"); ?>
<?php include_once 'views/layout/' . $this->layout . 'footer.php'; ?>