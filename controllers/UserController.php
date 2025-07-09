<?php

class UserController
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    /**
     * Hiển thị form đăng ký
     */
    public function register()
    {
        // Nếu đã đăng nhập, chuyển hướng về trang chủ
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        
        // Xử lý form đăng ký
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validate dữ liệu
            $errors = [];
            
            if (empty($username)) {
                $errors[] = 'Tên đăng nhập không được để trống';
            } elseif (strlen($username) < 3) {
                $errors[] = 'Tên đăng nhập phải có ít nhất 3 ký tự';
            } elseif ($this->userModel->getByUsername($username)) {
                $errors[] = 'Tên đăng nhập đã tồn tại';
            }
            
            if (empty($email)) {
                $errors[] = 'Email không được để trống';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            } elseif ($this->userModel->getByEmail($email)) {
                $errors[] = 'Email đã được sử dụng';
            }
            
            if (empty($password)) {
                $errors[] = 'Mật khẩu không được để trống';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = 'Xác nhận mật khẩu không khớp';
            }
            
            if (empty($errors)) {
                // Mã hóa mật khẩu
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'role' => 'user',
                    'active' => 1
                ];
                
                $result = $this->userModel->create($data);
                
                if ($result) {
                    $_SESSION['success'] = 'Đăng ký tài khoản thành công. Vui lòng đăng nhập.';
                    header('Location: ' . BASE_URL . 'login');
                    exit;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi đăng ký tài khoản';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        $title = 'Đăng ký tài khoản - PolyShop';
        $view = 'register';
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Hiển thị form đăng nhập
     */
    public function login()
    {
        // Nếu đã đăng nhập, chuyển hướng về trang chủ
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        
        // Xử lý form đăng nhập
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);
            
            // Validate dữ liệu
            $errors = [];
            
            if (empty($username)) {
                $errors[] = 'Tên đăng nhập không được để trống';
            }
            
            if (empty($password)) {
                $errors[] = 'Mật khẩu không được để trống';
            }
            
            if (empty($errors)) {
                $user = $this->userModel->getByUsername($username);
                
                if ($user && password_verify($password, $user['password'])) {
                    // Kiểm tra tài khoản có bị khóa không
                    if (!$user['active']) {
                        $_SESSION['error'] = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.';
                    } else {
                        // Đăng nhập thành công
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['is_admin'] = ($user['role'] === 'admin');
                        
                        // Lưu cookie nếu chọn "Ghi nhớ đăng nhập"
                        if ($remember) {
                            $token = bin2hex(random_bytes(32));
                            $expiry = time() + (30 * 24 * 60 * 60); // 30 ngày
                            
                            $this->userModel->saveRememberToken($user['id'], $token, $expiry);
                            
                            setcookie('remember_token', $token, $expiry, '/', '', false, true);
                        }
                        
                        // Chuyển hướng đến trang chủ hoặc trang trước đó
                        $redirect = $_SESSION['redirect'] ?? BASE_URL;
                        unset($_SESSION['redirect']);
                        
                        header('Location: ' . $redirect);
                        exit;
                    }
                } else {
                    $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không chính xác';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        $title = 'Đăng nhập - PolyShop';
        $view = 'login';
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Đăng xuất
     */
    public function logout()
    {
        // Xóa cookie remember token
        if (isset($_COOKIE['remember_token'])) {
            $this->userModel->deleteRememberToken($_COOKIE['remember_token']);
            setcookie('remember_token', '', time() - 3600, '/', '', false, true);
        }
        
        // Xóa session
        session_unset();
        session_destroy();
        
        header('Location: ' . BASE_URL);
        exit;
    }
    
    /**
     * Hiển thị thông tin tài khoản
     */
    public function profile()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect'] = BASE_URL . 'user/profile';
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem thông tin tài khoản';
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        $user = $this->userModel->getById($_SESSION['user_id']);
        
        if (!$user) {
            $_SESSION['error'] = 'Không tìm thấy thông tin tài khoản';
            header('Location: ' . BASE_URL);
            exit;
        }
        
        // Lấy danh sách bình luận của người dùng
        $commentModel = new CommentModel();
        $comments = $commentModel->getByUser($_SESSION['user_id']);
        
        $title = 'Thông tin tài khoản - PolyShop';
        $view = 'profile';
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Hiển thị form đổi mật khẩu
     */
    public function changePassword()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect'] = BASE_URL . 'user/change-password';
            $_SESSION['error'] = 'Vui lòng đăng nhập để đổi mật khẩu';
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        // Xử lý form đổi mật khẩu
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validate dữ liệu
            $errors = [];
            
            $user = $this->userModel->getById($_SESSION['user_id']);
            
            if (empty($currentPassword)) {
                $errors[] = 'Mật khẩu hiện tại không được để trống';
            } elseif (!password_verify($currentPassword, $user['password'])) {
                $errors[] = 'Mật khẩu hiện tại không chính xác';
            }
            
            if (empty($newPassword)) {
                $errors[] = 'Mật khẩu mới không được để trống';
            } elseif (strlen($newPassword) < 6) {
                $errors[] = 'Mật khẩu mới phải có ít nhất 6 ký tự';
            }
            
            if ($newPassword !== $confirmPassword) {
                $errors[] = 'Xác nhận mật khẩu mới không khớp';
            }
            
            if (empty($errors)) {
                // Mã hóa mật khẩu mới
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                $result = $this->userModel->updatePassword($_SESSION['user_id'], $hashedPassword);
                
                if ($result) {
                    $_SESSION['success'] = 'Đổi mật khẩu thành công';
                    header('Location: ' . BASE_URL . 'user/profile');
                    exit;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi đổi mật khẩu';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        $title = 'Đổi mật khẩu - PolyShop';
        $view = 'change_password';
        
        require_once PATH_VIEW . 'main.php';
    }
}