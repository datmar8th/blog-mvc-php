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

    public function getRecordUser($fields = '*', $options = null)
	{
		$conditions = '';
		if (isset($options)) {
			$conditions .= ' and ' . $options;
		}
		$query = "SELECT $fields FROM users INNER JOIN $this->table ON $this->table.user_id = users.id $conditions ORDER BY $this->table.path ASC";
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