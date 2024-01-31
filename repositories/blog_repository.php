<?php
class blog_repository extends main_repository {

	public function getCommentRecord($id = null, $fields = '*', $options = null)
	{
		$conditions = '';
		if (isset($options)) {
			$conditions .= ' and ' . $options;
		}
		// $query = "SELECT $fields FROM users INNER JOIN $this->table ON $this->table.user_id = users.id $conditions ORDER BY $this->table.path ASC";
		$query = "SELECT users.fullname, users.avatar, comments.*, GROUP_CONCAT(likes.user_id) AS userLikes FROM comments
					INNER JOIN users ON comments.user_id = users.id and blog_id = $id
					LEFT JOIN likes ON likes.type_id = comments.id AND likes.type = 'comment'
					GROUP BY comments.id ORDER BY comments.path ASC";
		
		
		$result = mysqli_query($this->con, $query);
		$result = $result->fetch_all(MYSQLI_ASSOC);
		return $result;
	}

	// public function getLike($id) {
    //     $likeModel = like_model::getInstance();
	// 	$record = $likeModel->getLikeRecord($id, "*", "type = 'comment'");
	// 	$liked = array();
	// 	foreach ($record as $parentArray) {
	// 		foreach ($parentArray as $k=>$v) {
	// 			// array_push($liked, $v);
	// 			$liked[]=$v;
	// 		}
	// 	}
	// 	return $liked;
	// }
}