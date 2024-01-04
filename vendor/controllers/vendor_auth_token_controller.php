<?php
class vendor_auth_token_controller extends vendor_api_controller {
	public function __construct() {
		$this->checkAuthToken();
		//$this->checkPermission();
		parent::__construct();
	}

	public function checkAuthToken() {
		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') die();
		if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
			http_response_code(200);
			echo json_encode(
				[
					'success' => 0,
					'message'=>'Header Authorization is required'
				]
			);
			exit();
		}
		$authorization = $_SERVER['HTTP_AUTHORIZATION'];
		$token_auth = ltrim($authorization, 'Bearer ');
		$app['token_auth'] = $token_auth;
		if ($token_auth && strlen($token_auth) > 1) {
			$um = new user_model();
			$user_token =  $um->getRecordWhere([
				'token' => $token_auth
			]);
			if ($user_token) {
				global $app;
				$app['user_auth'] = $user_token;
				return true;
			} else {
				http_response_code(200);
				echo json_encode(
					[
						'success' => 0,
						'message'=>'Token does not exits'
					]
				);
				exit();
			}
		} else {
			http_response_code(200);
			echo json_encode(
				[
					'success' => 0,
					'message'=>'Token is required'
				]
			);
			exit();
		}
		return true;
	}
}
?>
