<?php
class vendor_api_controller extends vendor_crud_controller {
	public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') die();
		parent::__construct();
	}
}
?>
