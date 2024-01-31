<?php
class main_repository {
	protected $con;
	private static $instance = [];
	protected $table;

	protected function __construct()
	{
		$instanceDB = ConnectDb::getInstance();
		$this->con = $instanceDB->getConnection();
		if (!$this->table)	$this->setTableName();
	}

	public static function getInstance() {
		$called_class = get_called_class();
		if (!array_key_exists($called_class, self::$instance)) {
			self::$instance[$called_class] = new $called_class();
		}
		return self::$instance[$called_class];
	}

	public function setTableName($table = null)
	{
		if ($table) {
			$this->table = $table;
		} else {
			$cln = get_class($this);
			$clnf = str_split($cln, strrpos($cln, '_'))[0];
			$this->table = noun_utils::pluralize($clnf);
			/*
			if (strrpos($clnf,"y")) {
				if ((strrpos($clnf,"y") + 1) == strlen($clnf)) {
					$this->table = str_split($clnf, strrpos($clnf, 'y'))[0].'ies'; 
				} 
			} else {
				$this->table = $clnf.'s';
			}
			*/
		}
	}
}