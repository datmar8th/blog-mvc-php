<?php 
class blogs_controller extends main_controller {
    protected blog_model $blog;
    public function __construct() {}

    public function index() {
        $this->display();
    }
}
?>