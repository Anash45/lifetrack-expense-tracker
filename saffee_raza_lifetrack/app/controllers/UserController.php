<?php
class UserController {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validate input and save to the database
            $userModel = new User();
            $userModel->register($name, $email, $password);

            // Redirect or show a success message
            header('Location: ' . BASE_URL . 'user/login');
            exit();
        }

        require_once '../app/views/register.php';
    }

    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validate input and check credentials
            $userModel = new User();
            $user = $userModel->login($email, $password);

            if ($user) {
                // Set session variables or other login logic
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['logged_in'] = true;
                header('Location: ' . BASE_URL . 'dashboard'); // Redirect to a dashboard or home page
                exit();
            } else {
                // Handle login failure
                $error = "Invalid email or password.";
            }
        }

        require_once '../app/views/login.php';
    }
    
    public function logout() {
        session_destroy();
        header('Location:'. BASE_URL . '/');
    }
}
