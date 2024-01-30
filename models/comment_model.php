<?php 
class comment_model extends main_model {
    public function __construct()
    {
        parent::__construct();
    }

    public function addRecord($datas)
    {
        $datas['comment_content'] = mysqli_real_escape_string($this->con, $datas['comment_content']);
        parent::addRecord($datas);
        $last_record = parent::getLastRecord('comments');
        $path = str_pad($last_record['id'], 5, "0", STR_PAD_LEFT);
        $updatePath = array('path' => $path);
        parent::editRecord($last_record['id'], $updatePath);
        return parent::getRecord($last_record['id']);
    }

    public function getCommentRecord($id = null, $fields = '*', $options = null)
	{
		$conditions = '';
		if (isset($options)) {
			$conditions .= ' and ' . $options;
		}
		// $query = "SELECT $fields FROM users INNER JOIN $this->table ON $this->table.user_id = users.id $conditions ORDER BY $this->table.path ASC";
		$query = "SELECT users.fullname, users.avatar, comments.*, GROUP_CONCAT(likes.user_id) AS userLikes FROM users
					INNER JOIN comments ON comments.user_id = users.id and blog_id = $id
					LEFT JOIN likes ON likes.type_id = comments.id AND likes.type = 'comment'
					GROUP BY comments.id ORDER BY comments.path ASC";
		
		
		$result = mysqli_query($this->con, $query);
		$result = $result->fetch_all(MYSQLI_ASSOC);
		return $result;
	}

    public function addReplyRecord($id, $datas) {
		$datas['comment_content'] = mysqli_real_escape_string($this->con, $datas['comment_content']);
		parent::addRecord($datas);
		$last_record = parent::getLastRecord('comments');
		$parentRecord = parent::getRecord($id);
		$path = $parentRecord['path'] . "." . str_pad($last_record['id'], 5, "0", STR_PAD_LEFT);
		$updatePath = array('path' => $path);
		parent::editRecord($last_record['id'], $updatePath);
		return parent::getRecord($last_record['id']);
	}

	// public function getViewBlog($id) {
	// 	$query = "SELECT b.*, c.*, l.*
    //           FROM blogs b
    //           LEFT JOIN comments c ON b.id = c.blog_id
    //           LEFT JOIN likes l ON c.id = l.type_id AND l.type = 'comment'
    //           WHERE b.id = $id";	  
	// 	$result = mysqli_query($this->con, $query);
	// 	$result = $result->fetch_all(MYSQLI_ASSOC);

	// 	$viewData = [];
	// 	while ($row = $result) {
	// 		$viewData['blogRecord'] = $row; // Thông tin blog
	// 		$viewData['commentRecords'][] = $row; // Thông tin comment
	// 		if (!empty($row['like_id'])) {
	// 			$viewData['likeRecords'][] = $row; // Thông tin like
	// 		}
	// 	}
	// 	return $viewData;
	// }

	// public function addHistoryComment($datas) {
	// 	global $app;
	// 	$fields = $values = '';
	// 	$i = 0;
	// 	$datas['comment_content'] = mysqli_real_escape_string($this->con, $datas['comment_content']);
	// 	foreach ($datas as $k => $v) {
	// 		if ($i) {
	// 			$fields .= ',';
	// 			$values .= ',';
	// 		}
	// 		$fields .= $k;
	// 		$values .= "'" . $v . "'";
	// 		$i++;
	// 	}
	// 	$query = "INSERT INTO comment_history ($fields) VALUES ($values)";
	// 	if ($createdTime = $this->recordTime($app['recordTime']['created'])) {
	// 		$fields .= ',' . $app['recordTime']['created'];
	// 		$values .= ',' . $createdTime;
	// 	}		
	// 	return mysqli_query($this->con, $query);
	// }

}
?>