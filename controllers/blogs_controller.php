<?php
class blogs_controller extends main_controller
{
	
    public function index()
    {
        if (isset($_SESSION['auth'])) {
            $id = $_SESSION['auth']['id'];
            $fields = "id, title, category, content, image, slug";
			$blogModel = blog_model::getInstance();
            $record = $blogModel->getRecordByUserId($id, $fields);
            $this->setProperty('records', $record);
            $this->checkAuth();
        } else {
            header("Location: " . html_helpers::url(array('ctl' => 'users', 'act' => 'login')));
        }
        $this->display();
    }

	public function view($id) {
		$blogsRepository = blog_repository::getInstance();

		$blogModel = blog_model::getInstance();
		$blogRecord = $blogModel->getRecord($id);
		$this->setProperty('records', $blogRecord);

		$commentRecords = $blogsRepository->getCommentRecord($id);
		$this->setProperty('commentRecords', $commentRecords);
		
		$this->display();
	}

	public function add()
	{
		$this->display();
	}

	public function edit($id)
	{
		$blogModel = blog_model::getInstance();
		$blogRecord = $blogModel->getRecord($id);
		if($this->checkCurrentAuth($blogRecord['user_id'])) $this->display();		
	}

	public function del($id) 
	{
		$blogModel = blog_model::getInstance();
		$record = $blogModel->getRecord($id);
		if(file_exists(RootURI."/media/upload/" .$this->controller.'/'.$record['image']))
			unlink(RootURI."/media/upload/" .$this->controller.'/'.$record['image']);
			
		$blogModel->delRecord($id);
		header( "Location: ".html_helpers::url(array('ctl'=>'blogs')));
	}

	public function createSubmit()
	{
		$blogModel = blog_model::getInstance();
		if (isset($_POST['add_blog'])) {
			$id = $_SESSION['auth']['id'];
			$blogData = $_POST['data'][$this->controller];
			date_default_timezone_set("Asia/Ho_Chi_Minh");
			$slug = html_helpers::convert_to_slug($blogData['title']." ".date("h:i:s", time()));
			$blogData['slug'] = $slug;
			$blogData['user_id'] = $id;
			if (!empty($blogData['title'])) {
				if (isset($_FILES) and $_FILES["image"]["name"]) {
					$blogData['image'] = SimpleImage_Component::uploadImg($_FILES, $this->controller);
				}
				if ($blogModel->addRecord($blogData)) {
					header("Location: " . html_helpers::url(array('ctl' => 'blogs')));
				}
			}
		}
	}

	public function editSubmit($id)
	{
		$blogModel = blog_model::getInstance();

		$records = $this->getData($_SESSION['auth']['id'], 'edit');
		$this->setProperty('records',$records);
		
		if (isset($_POST['edit_blog'])) {
			$blogData = $_POST['data'][$this->controller];
			date_default_timezone_set("Asia/Ho_Chi_Minh");
			$slug = html_helpers::convert_to_slug($blogData['title']." ".date("h:i:s", time()));
			$blogData['slug'] = $slug;
			if (!empty($blogData['title'])) {
				if (isset($_FILES) and $_FILES["image"]["name"]) {
					if(file_exists(UploadREL .$this->controller.'/'.$records['image']))
					unlink(UploadREL .$this->controller.'/'.$records['image']);
					$blogData['image'] = SimpleImage_Component::uploadImg($_FILES, $this->controller);
				}				
				if ($blogModel->editRecord($id, $blogData)) {
					header("Location: " . html_helpers::url(array('ctl' => 'blogs')));
				}
			}
		}

		if (isset($_POST['cancel_edit_blog'])) {
			header("Location: " . html_helpers::url(array('ctl' => 'blogs')));
		}
	}
}
