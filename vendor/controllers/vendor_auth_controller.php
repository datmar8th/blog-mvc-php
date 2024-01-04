<?php
class vendor_auth_controller extends vendor_crud_controller {
	public function __construct() {
		$this->checkAuth();
		//$this->checkPermission();
		parent::__construct();
	}

	public  function checkPermission() {
		return true;
	}
}
?>