<?php
class user_model extends main_model {
	public function __construct()
	{
		return parent::__construct();
	}

	public function createTable() {
		$sql = "CREATE TABLE users (
			id 			INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			username			TEXT(255)    NOT NULL,
			fullname			VARCHAR(255) NOT NULL,
			email				VARCHAR(555) NOT NULL,
			password		    VARCHAR(555) NOT NULL,
			phone				VARCHAR(255) DEFAULT NULL,
			address				VARCHAR(1024) DEFAULT NULL,
			created         	DATETIME	 NOT NUll,
		)";

		$result = $this->con->query($sql);
		return $result;
	}

	public function addRecord($datas) {
		$datas['password'] = md5($datas['password']);
		return parent::addRecord($datas); 
	}

	public function loginData($user) {
		$password =  (md5($user['password']));
		$email = ($user['email']);
		
		$password = mysqli_real_escape_string($this->con, $password);
		$email = mysqli_real_escape_string($this->con, $email);

		$query = "SELECT * FROM $this->table WHERE email = '$email' AND password = '$password'";
		$result = mysqli_query($this->con,$query);
		if ($result) {
			$record = mysqli_fetch_assoc($result);
		} else $record = false;
		return $record;
	}
	
	public function checkOldPassword($password) {
		$email = ucfirst($_SESSION['auth']['email']);
		$sql = "SELECT COUNT(id) as total  FROM `users` WHERE `email` = '".$email."' AND `password` = '".$password."'";
		$result = $this->con->query($sql);
		return $result->fetch_assoc()['total'];
	}

	public function usernameExists($username) {
        // Sanitize the username to prevent SQL injection
        $sanitizedUsername = $this->con->real_escape_string($username);

        $sql = "SELECT COUNT(id) as total FROM `users` WHERE `username` = '$sanitizedUsername'";
        $result = $this->con->query($sql);
        
        return $result->fetch_assoc()['total'] > 0;
    }

    public function emailExists($email) {
        // Sanitize the email to prevent SQL injection
        $sanitizedEmail = $this->con->real_escape_string($email);

        $sql = "SELECT COUNT(id) as total FROM `users` WHERE `email` = '$sanitizedEmail'";
        $result = $this->con->query($sql);

        return $result->fetch_assoc()['total'] > 0;
    }
}
?>
