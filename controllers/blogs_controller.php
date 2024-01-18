<?php
class blogs_controller extends main_controller
{
    protected blog_model $blog;
	protected like_model $like;
	protected comment_model $comment;

    public function __construct()
    {
        $this->blog = blog_model::getInstance();
		$this->comment = comment_model::getInstance();
		$this->like = like_model::getInstance();
        parent::__construct();
    }

    public function index()
    {
        if (isset($_SESSION['auth'])) {
            $id = $_SESSION['auth']['id'];
            $fields = "id, title, category, content, image, slug";
            $record = $this->blog->getRecordByUserId($id, $fields);
            $this->setProperty('records', $record);
            $this->checkAuth();
        } else {
            header("Location: " . html_helpers::url(array('ctl' => 'users', 'act' => 'login')));
        }
        $this->display();
    }

    public function create()
    {
        $user = user_model::getInstance();
		$user->createTable();

		$activity = activity_model::getInstance();
		$activity->createTable();

		$this->blogs = $user->getAllTables();
		$this->display();
    }

    public function getBlogData($id) 
	{
		$record = $this->blog->getRecord($id);
		$this->setProperty('records', $record);
		return $record;
	}

	public function getComment($id) 
	{
		$record = $this->comment->getRecordUser($fields = '*', "blog_id =". $id);
		$this->setProperty('commentRecords', $record);
		return $record;
	}

	public function getLike($id) {
		$record = $this->like->getLikeRecord($_SESSION['auth']['id'], $id, "type_id", "type = 'comment'");
		$this->setProperty('likeRecords', $record);
		$liked = array();
		foreach ($record as $parentArray) {
			foreach ($parentArray as $k=>$v) {
				// array_push($liked, $v);
				$liked[]=$v;
			}
		}
		return $liked;
	}

	public function view($id)
	{
		if(isset($_SESSION['auth'])) 
		{
			$this->getComment($id);
			$this->getBlogData($id);
			$this->likeRecords=$this->getLike($id);
			$this->display();
		} else {
            header( "Location: ".html_helpers::url(array('ctl'=>'users', 'act'=>'login')));
		}

	}

	public function add()
	{
		$this->display();
	}

	public function edit($id)
	{
		$record = $this->getBlogData($id);
		if($this->checkCurrentAuth($record['user_id'])) $this->display();		
	}

	public function del($id) 
	{
		$record = $this->blog->getRecord($id);
		if(file_exists(RootURI."/media/upload/" .$this->controller.'/'.$record['image']))
			unlink(RootURI."/media/upload/" .$this->controller.'/'.$record['image']);
			
		$this->blog->delRecord($id);
		header( "Location: ".html_helpers::url(array('ctl'=>'blogs')));
	}

	public function createSubmit()
	{
		if (isset($_POST['add_blog'])) {
			$id = $_SESSION['auth']['id'];
			$blogData = $_POST['data'][$this->controller];
			date_default_timezone_set("Asia/Ho_Chi_Minh");
			$slug = html_helpers::convert_name($blogData['title']." ".date("h:i:s", time())." ". strval((rand(0, 10000))));
			$blogData['slug'] = $slug;
			$blogData['user_id'] = $id;
			if (!empty($blogData['title'])) {
				if (isset($_FILES) and $_FILES["image"]["name"]) {
					$blogData['image'] = SimpleImage_Component::uploadImg($_FILES, $this->controller);
				}
				if ($this->blog->addRecord($blogData)) {
					header("Location: " . html_helpers::url(array('ctl' => 'blogs')));
				}
			}
		}
	}

	public function editSubmit($id)
	{
		$records = $this->getData($_SESSION['auth']['id'], 'edit');
		$this->setProperty('records',$records);
		
		if (isset($_POST['edit_blog'])) {
			$blogData = $_POST['data'][$this->controller];
			date_default_timezone_set("Asia/Ho_Chi_Minh");
			$slug = html_helpers::convert_name($blogData['title']." ".date("h:i:s", time())." ". strval((rand(0, 10000))));
			$blogData['slug'] = $slug;
			if (!empty($blogData['title'])) {
				if (isset($_FILES) and $_FILES["image"]["name"]) {
					if(file_exists(UploadREL .$this->controller.'/'.$records['image']))
					unlink(UploadREL .$this->controller.'/'.$records['image']);
					$blogData['image'] = SimpleImage_Component::uploadImg($_FILES, $this->controller);
				}				
				if ($this->blog->editRecord($id, $blogData)) {
					header("Location: " . html_helpers::url(array('ctl' => 'blogs')));
				}
			}
		}

		if (isset($_POST['cancel_edit_blog'])) {
			header("Location: " . html_helpers::url(array('ctl' => 'blogs')));
		}
	}
}
