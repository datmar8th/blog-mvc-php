<?php
class home_controller extends main_controller {
	public function index() {
		$blog = blog_model::getInstance();
		$this->records =  $blog->getAllBlogs();
		$this->display();
	}
}
?>
