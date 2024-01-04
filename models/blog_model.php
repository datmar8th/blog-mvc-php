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
}
