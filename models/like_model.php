<?php
class like_model extends main_model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function addRecord($datas)
	{
        parent::addRecord($datas);
	}

	public function delLikeRecord($user_id, $type_id) {
		$query = "DELETE FROM $this->table WHERE user_id = $user_id and type_id = $type_id";
		return mysqli_query($this->con, $query);
	}

	public function getLikeRecord($blog_id, $fields = '*', $options = null) {
		$conditions = '';
		if (isset($options)) {
			$conditions .= ' and ' . $options;
		}
		$query = "SELECT $this->table.$fields
					FROM $this->table 
					INNER JOIN comments on $this->table.type_id = comments.id 
					WHERE  comments.blog_id = $blog_id and $options ";
		$result = mysqli_query($this->con, $query);
		$result = $result->fetch_all(MYSQLI_ASSOC);
		return $result;

		// SELECT c.*, CASE WHEN EXISTS (SELECT 1 FROM likes WHERE type_id = c.id AND user_id = 1)
		// THEN TRUE ELSE FALSE END AS islike FROM comments c WHERE c.blog_id = 18;

	}


	// public function getListLikeByUserIdInBlog($user_id, $blog_id) {
	// 	$query = "SELECT c.*, CASE WHEN EXISTS (SELECT 1 FROM $this->table WHERE type_id = c.id AND user_id = $user_id) 
	// 				THEN TRUE ELSE FALSE END AS islike FROM comments c WHERE c.blog_id = $blog_id ";
	// 	$result = mysqli_query($this->con, $query);
	// 	$result = $result->fetch_all(MYSQLI_ASSOC);
	// 	return $result;
	// }
}
