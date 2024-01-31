<?php
class blog_model extends main_model
{
	public function __construct() {
		parent::__construct();		
	}

	public function addRecord($datas) {
		$datas['published'] = 1;	
		$datas['title'] = mysqli_real_escape_string($this->con, $datas['title']);
		return parent::addRecord($datas);
	}	

	public function editRecord($id, $datas)
	{
		$datas['title'] = mysqli_real_escape_string($this->con, $datas['title']);
		return parent::editRecord($id, $datas);
	}

	public function getRecordByUserId($id=null, $fields='*', $options=null) {
		$conditions ="";
		if(isset($options['conditions'])) {
			$conditions .= ' and '. $options['conditions'];
		}
		$query = "SELECT $fields FROM $this->table where user_id=$id".$conditions;
		$record = mysqli_query($this->con,$query);
		return $record;
	}

	public function getAllBlogs()
	{
		$query = "SELECT *, blogs.id as blog_id, blogs.created as blogs_created,  (SELECT COUNT(id) FROM comments 
		WHERE comments.blog_id = blogs.id)  AS count_comment FROM `blogs` 
		INNER JOIN `users` ON users.id = blogs.user_id ORDER BY `blog_id` DESC";
		$result = mysqli_query($this->con, $query);
		$result = $result->fetch_all(MYSQLI_ASSOC);
		return $result;
	}

	public function getSlugById($id) {
		$id = mysqli_real_escape_string($this->con, $id);
		$query = "SELECT slug FROM blogs WHERE id=$id";
		$result = mysqli_query($this->con, $query);
		$result = $result->fetch_all(MYSQLI_ASSOC);
		return $result;
	}
}
