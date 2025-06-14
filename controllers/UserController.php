<?php
require_once 'models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // Handle user signup.
    public function signup() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            if (empty($username) || empty($password)) {
                $error = "Username and password are required.";
            } else {
                if ($this->userModel->getUserByUsername($username)) {
                    $error = "Username already exists.";
                } else {
                    if ($this->userModel->createUser($username, $password)) {
                        header("Location: index.php?action=login&success=Signup successful. Please log in.");
                        exit;
                    } else {
                        $error = "Signup failed. Please try again.";
                    }
                }
            }
        }
        $page_title = "Signup";
        ob_start();
        require 'views/signup.php';
        $content = ob_get_clean();
        require 'views/layout.php';
    }

    // Handle user login.
    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            if (empty($username) || empty($password)) {
                $error = "Username and password are required.";
            } else {
                $user = $this->userModel->getUserByUsername($username);
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['username'] = $user['username'];
                    header("Location: index.php?action=list&success=Logged in successfully");
                    exit;
                } else {
                    $error = "Invalid username or password.";
                }
            }
        }
        $page_title = "Login";
        ob_start();
        require 'views/login.php';
        $content = ob_get_clean();
        require 'views/layout.php';
    }

    // Handle user logout.
    public function logout() {
        session_destroy();
        header("Location: index.php?action=login&success=Logged out successfully");
        exit;
    }
}
