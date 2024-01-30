<?php
class users_controller extends main_controller
{
    protected $errors;
    protected user_model $user;
    public function __construct() {
        $this->user = user_model::getInstance();
        parent::__construct();
    }

    public function index() {
        if (isset($_SESSION['auth'])) {
            $this->display();
        } else {
            header("Location: " . html_helpers::url(array('ctl' => 'users', 'act' => 'login')));
        }
        $this->display();
    }

    public function login() {
        if(isset($_POST['login-user'])) {
			$userData = $_POST['data'][$this->controller];
            $userCurrent = $this->user->loginData($userData);
            if (!$userCurrent) {
                $this->errors = "Email or password invalid!!!";
                return $this->display();
            } else {
                $_SESSION['auth'] = $userCurrent;
                header("Location: ". html_helpers::url(array('ctl'=>'home')));
            }
		}
		$this->display();
    }

    public function signup() {
        if (isset($_POST['signup-user'])) {
            $userData = $_POST['data'][$this->controller];
            if (empty($userData['username']) || empty($userData['email']) || empty($userData['password'])) {
                $this->errors = "All fields are required.";
            } elseif ($userData['password'] !== $userData['confirm']) {
                $this->errors = "Passwords do not match.";
            } else {
                unset($userData['confirm']); //xoa confirm password
                if ($this->user->usernameExists($userData['username'])) {
                    $this->errors = "Username already exists. Choose a different username.";
                } elseif ($this->user->emailExists($userData['email'])) {
                    $this->errors = "Email already exists. Choose a different email.";
                } else {
                    if ($this->user->addRecord($userData)) {
                        header("Location: ".html_helpers::url(array('ctl'=>'users', 'act'=>'login')));
                        exit();
                    } else {
                        $this->errors = "An error occurred during registration. Please try again.";
                    }
                }
            }
        }
        $this->display();
    }
    
    
    
    public function logout() {
        session_unset(); 
        session_destroy(); 
        header( "Location: ".html_helpers::url(array('ctl'=>'home')));
    }

    public function user_profile() {
        $records = $this->getData($_SESSION['auth']['id'], 'user_profile');
        $this->setProperty('records',$records);
        $this->display();
    }

    public function change_password() {
        if (isset($_POST['change-password'])) {
            $user = $_POST['data']['users'];
            $password = md5($user['old-password']);
            if ($this->user->checkOldPassword($password) == '1') {
                if ($user['new-password'] !== $user['confirm']) {
                    $this->errors = 'New password and confirm password do not match !!!';
                    return $this->display();
                } else {
                    $newPass = md5($user['new-password']);
                    if ($this->user->editRecord($_SESSION['auth']['id'], array('password' => $newPass))) {
                        header('Location: '. html_helpers::url(array('ctl' => 'users')));
                    }
                }
            } else {
                $this->errors = 'Incorrect old password!!!';
                return $this->display();
            }
        }
        $this->display();
    }

    public function edit_profile() {
        $records = $this->getData($_SESSION['auth']['id'], 'edit_profile');
        $this->setProperty('records',$records);
        if(isset($_POST['edit-btn'])) {
            $id = $_SESSION['auth']['id'];
            $userData = $_POST['data'][$this->controller];
            if(isset($_FILES) and $_FILES["image"]["name"]) {
                if(file_exists(UploadREL .$this->controller.'/'.$records['avatar'])) {
                    if ($records['avatar'] != 'avatar-default.png'){
                        unlink(UploadREL .$this->controller.'/'.$records['avatar']);
                    }
                }
                $userData['avatar'] = SimpleImage_Component::uploadImg($_FILES, $this->controller);
            }
            if ($this->user->editRecord($id, $userData)){
                header( "Location: ".html_helpers::url(array('ctl'=>'users', 'act'=>'user_profile')));
            }
        }
        $this->display();
    }

}
