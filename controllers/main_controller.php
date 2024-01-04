<?php
class main_controller {
	protected $layout = "";
	protected $model; 
	protected $controller = "home";
	protected $action = "index";
	protected $tables;
	protected $records;
	
	
	public function  __construct() {
		global $cn, $app;
		$this->controller = $cn;
		$app['ctl'] = $this->controller;
		if(isset($_GET["act"])) $this->action = $_GET["act"];
		$app['act'] = $this->action;
		
		if(method_exists($this, $this->action)) {
			if(count($_GET)>2) {
				// This build for CRUD 
				if($this->action=='view' || $this->action=='edit' || $this->action=='del') {
					$id='';
					if(isset($_GET['id']))	$id=$_GET['id'];
					$this->{$this->action}($id);					
				}
				else {
					$params = array_slice($_GET, 2, count($_GET));
					$this->{$this->action}($params);
				}
			} 
			// else if($this->action == 'loginSubmit') {
			// 	$this->action = 'login';
			// } 
			else $this->{$this->action}();   //goi ham
			
		} else {
			include "views/staticpages/error.php";
		}
	}

	public function checkAuth($datas=null) {
		if($_SESSION['auth']) {
			$this->display();
		} else {
			header( "Location: ".html_helpers::url(array('ctl'=>'users', 'act'=>'login')));
		}
	}
	
	public function checkCurrentAuth($id) {
		if($_SESSION['auth']['id'] == $id) {
			return true;
		} else {
			include "views/staticpages/forbidden.php";		
		}
	}
	
	public function display($options=null) {
		if(!isset($options['ctl']))	$options['ctl'] = $this->controller;
		if(!isset($options['act']))	$options['act'] = $this->action;
		if($this->action == 'loginSubmit'){
			$this->action = 'login';
			$options['act'] = $this->action;
		}
		include_once "views/".$options['ctl']."/".$options['act'].".php";
	}

	public function getData($id, $str) {
		$option['act'] = $str;
		$user = new user_model();
		$userData = $user->getRecord($id);
		return $userData;
	}

    public function setProperty($name, $value) {
        $this->$name = $value;
    }
}
?>
