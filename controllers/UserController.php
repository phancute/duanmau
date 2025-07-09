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
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'role' => 'user'
                ];
                
                // Thêm log để debug
                error_log("Bắt đầu đăng ký người dùng: " . $username);
                
                try {
                    // Thêm log để debug
                    error_log("Bắt đầu quá trình đăng ký cho: " . $username);
                    
                    // Kiểm tra kết nối cơ sở dữ liệu
                    if (!$this->userModel->getPdo()) {
                        throw new Exception("Không thể kết nối đến cơ sở dữ liệu");
                    }
                    
                    // Kiểm tra cơ sở dữ liệu có tồn tại không
                    try {
                        $checkDb = $this->userModel->getPdo()->query("SELECT DATABASE()");
                        $dbName = $checkDb->fetchColumn();
                        error_log("Đang sử dụng cơ sở dữ liệu: " . $dbName);
                        
                        if (empty($dbName)) {
                            throw new Exception("Không có cơ sở dữ liệu được chọn");
                        }
                    } catch (PDOException $e) {
                        throw new Exception("Lỗi kiểm tra cơ sở dữ liệu: " . $e->getMessage());
                    }
                    
                    // Kiểm tra bảng users có tồn tại không
                    try {
                        $checkTable = $this->userModel->getPdo()->query("SHOW TABLES LIKE 'users'");
                        if ($checkTable->rowCount() == 0) {
                            throw new Exception("Bảng users không tồn tại. Vui lòng chạy script cài đặt cơ sở dữ liệu.");
                        }
                    } catch (PDOException $e) {
                        throw new Exception("Lỗi kiểm tra bảng: " . $e->getMessage());
                    }
                    
                    // Thực hiện đăng ký
                    error_log("Bắt đầu thực hiện đăng ký với dữ liệu: " . json_encode($data));
                    
                    // Thêm script để hiển thị thông báo trong console trước khi đăng ký
                    echo '<script>console.log("Đang xử lý đăng ký cho: ' . $username . '");</script>';
                    
                    $userId = $this->userModel->register($data);
                    
                    if ($userId) {
                        // Thêm log thành công
                        error_log("Đăng ký thành công cho: " . $username . ", ID: " . $userId);
                        
                        // Hiển thị thông báo thành công
                        $_SESSION['success'] = 'Đăng ký tài khoản thành công. Vui lòng đăng nhập.';
                        
                        // Thêm script để hiển thị thông báo trong console
                        echo '<script>console.log("Đăng ký thành công: ' . $username . ' (ID: ' . $userId . ')");</script>';
                        
                        // Chuyển hướng đến trang đăng nhập
                        redirect('login');
                        exit;
                    } else {
                        // Thêm log lỗi
                        error_log("Đăng ký thất bại cho: " . $username);
                        $_SESSION['error'] = 'Có lỗi xảy ra khi đăng ký tài khoản. Vui lòng kiểm tra log lỗi hoặc chạy script kiểm tra cơ sở dữ liệu.';
                        
                        // Thêm script để hiển thị thông báo lỗi trong console
                        echo '<script>console.log("Đăng ký thất bại cho: ' . $username . '");</script>';
                    }
                } catch (Exception $e) {
                    error_log("Lỗi đăng ký: " . $e->getMessage());
                    $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
                    
                    // Thêm script để hiển thị thông báo lỗi trong console
                    echo '<script>console.log("Lỗi đăng ký: ' . addslashes($e->getMessage()) . '");</script>';
                    
                    // Kiểm tra kết nối cơ sở dữ liệu
                    try {
                        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);
                        $testPdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                        echo '<script>console.log("Kết nối cơ sở dữ liệu thành công với: ' . addslashes($dsn) . '");</script>';
                        
                        // Kiểm tra cơ sở dữ liệu
                        $checkDb = $testPdo->query("SELECT DATABASE()");
                        $dbName = $checkDb->fetchColumn();
                        echo '<script>console.log("Cơ sở dữ liệu hiện tại: ' . $dbName . '");</script>';
                        
                        // Kiểm tra bảng users
                        $checkTable = $testPdo->query("SHOW TABLES LIKE 'users'");
                        if ($checkTable->rowCount() > 0) {
                            echo '<script>console.log("Bảng users tồn tại");</script>';
                            
                            // Kiểm tra cấu trúc bảng
                            $tableInfo = $testPdo->query("DESCRIBE users");
                            $columns = [];
                            while ($column = $tableInfo->fetch(PDO::FETCH_ASSOC)) {
                                $columns[] = $column['Field'] . ' (' . $column['Type'] . ')';
                            }
                            echo '<script>console.log("Cấu trúc bảng users: ' . addslashes(implode(", ", $columns)) . '");</script>';
                        } else {
                            echo '<script>console.log("Bảng users không tồn tại");</script>';
                        }
                    } catch (PDOException $pdoEx) {
                        echo '<script>console.log("Lỗi kết nối cơ sở dữ liệu: ' . addslashes($pdoEx->getMessage()) . '");</script>';
                    }
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
                    // Kiểm tra tài khoản có bị khóa không (nếu trường active tồn tại)
                    if (isset($user['active']) && !$user['active']) {
                        $_SESSION['error'] = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.';
                    } else {
                        // Đăng nhập thành công
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['user_role'] = $user['role'];
                        
                        // Thêm thông báo thành công
                        $_SESSION['success'] = 'Đăng nhập thành công. Chào mừng ' . $user['username'] . ' quay trở lại!';
                        
                        // Thêm script để hiển thị thông báo trong console
                        echo '<script>console.log("Đăng nhập thành công: ' . $user['username'] . '");</script>';
                        
                        // Lưu cookie nếu chọn "Ghi nhớ đăng nhập"
                        if ($remember) {
                            $token = bin2hex(random_bytes(32));
                            $expiry = time() + (30 * 24 * 60 * 60); // 30 ngày
                            
                            $this->userModel->saveRememberToken($user['id'], $token, $expiry);
                            
                            setcookie('remember_token', $token, $expiry, '/', '', false, true);
                        }
                        
                        // Kiểm tra vai trò và chuyển hướng phù hợp
                        if ($_SESSION['user_role'] === 'admin') {
                            // Nếu là admin, chuyển hướng đến trang quản trị
                            $redirect = BASE_URL . 'admin';
                        } else {
                            // Nếu là người dùng thường, chuyển hướng đến trang chủ hoặc trang trước đó
                            $redirect = $_SESSION['redirect'] ?? BASE_URL;
                            unset($_SESSION['redirect']);
                        }
                        
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