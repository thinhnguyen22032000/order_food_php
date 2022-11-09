<?php


require './mvc/helpers/helpers.php';
require './mvc/helpers/validation.php';

class Auth extends Controller
{

    private $authModel;

    function __construct()
    {
        $this->authModel = $this->model("AuthModel");
    }

    function index()
    {
        $this->view('public_layout', [
            'Page' => 'auth/login'
        ]);
    }

    function register()
    {
        $this->view('public_layout', [
            'Page' => 'auth/register'
        ]);
    }

    function authLogin()
    {
        $url_loc = '';
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $vals = [
            'username' => $username,
            'password' => $password
        ];
        $rules = [
            'username' => 'required|max:8',
            'password'  => 'required|max:14',
        ];
        $result = Validation::validator($vals, $rules);
        if (!empty($result)) {
            $_SESSION['error_msg'] = $result;
            $url_loc = 'auth/login';
        } else {
            // validation passes
            $user = $this->authModel->login($username, $password);
            if ($user) {
                setcookie('username', $_POST['username'], time() + 3600, '/');
                $url_loc = 'manager/index';
            } else {
                $_SESSION['error_msg'] = "ERR_LOGIN";
                $url_loc = 'auth/login';
            }
        }
        $this->render($url_loc);
    }

    function authRegister()
    {
        $msg = '';
        $msg_type = 'notify_msg';
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $vals = [
            'username' => $username,
            'password' => $password
        ];
        $rules = [
            'username' => 'required|max:8',
            'password'  => 'required|min:6',
        ];
        $result = Validation::validator($vals, $rules);
        if (!empty($result)) {
            $msg = $result;
            $msg_type = 'error_msg';
        } else {
            $result = $this->authModel->register($username, $password);
            $msg = $result ? 'REGISTER_SUCCESS' : 'REGISTER_ERR_USER_EXIST';
            $msg_type = $result ? $msg_type : 'error_msg';
        }
        Helpers::set_session_and_navigate($msg_type, $msg, 'auth/register');
    }

    function logout()
    {
        if (isset($_COOKIE['username'])) {
            setcookie('username', null, -1, '/');
            $this->render('auth/login');
        }
        $this->render('auth/login');
    }
}
