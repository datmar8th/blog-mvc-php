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

	public function getLikeRecord($user_id, $blog_id, $fields = '*', $options = null) {
		$conditions = '';
		if (isset($options)) {
			$conditions .= ' and ' . $options;
		}
		//$query = "SELECT $fields FROM comments INNER JOIN $this->table ON $this->table.type_id = comments.id INNER JOIN users ON $this->table.user_id = users.id" . $conditions;
		$query = "SELECT $this->table.$fields 
					FROM $this->table 
					INNER JOIN comments on $this->table.type_id = comments.id 
    					WHERE $this->table.user_id = $user_id and comments.blog_id = $blog_id and $this->table.type_id 
        					IN 
        					(SELECT  $this->table.type_id FROM $this->table WHERE $options)";
							
		$result = mysqli_query($this->con, $query);
		$result = $result->fetch_all(MYSQLI_ASSOC);
		return $result;
	}
}
