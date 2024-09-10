<?php
class UserController {
    // Method to update user details (Admin only)
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            $userId = $_POST['edit_user_id'];
            $name = $_POST['edit_name'];
            $email = $_POST['edit_email'];
            $role = $_POST['edit_role'];
            $password = !empty($_POST['edit_password']) ? $_POST['edit_password'] : null;

            $userModel = new User();
            $success = $userModel->updateUser($userId, $name, $email, $role , $password);

            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update user.']);
            }
        }
    }
    public function users() {
        require_once '../app/views/users.php';
    }
    
    public function getAllUsers() {
        $userModel = new User();
        $users = $userModel->getAllUsers();

        echo json_encode(['users' => $users]);
    }
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
                $_SESSION['role'] = $user['role'];
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

    // Method to delete a user (Admin only)
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            $userId = $_POST['id'];

            $userModel = new User();
            $success = $userModel->deleteUser($userId);

            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'User deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete user.']);
            }
        }
    }
    
    public function logout() {
        session_destroy();
        header('Location:'. BASE_URL . '/');
    }
}
