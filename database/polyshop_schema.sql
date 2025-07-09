-- File: polyshop_schema.sql 
 
-- 1. Bảng người dùng 
CREATE TABLE users ( 
    id INT PRIMARY KEY AUTO_INCREMENT, 
    username VARCHAR(50) UNIQUE NOT NULL, 
    email VARCHAR(100) UNIQUE NOT NULL, 
    password VARCHAR(255) NOT NULL, 
    role ENUM('user', 'admin') DEFAULT 'user', 
    active TINYINT(1) DEFAULT 1, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
); 

-- 2. Bảng danh mục sản phẩm 
CREATE TABLE categories ( 
    id INT PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(100) NOT NULL, 
    description TEXT 
); 

-- 3. Bảng sản phẩm 
CREATE TABLE products ( 
    id INT PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(150) NOT NULL, 
    description TEXT, 
    specifications TEXT, 
    price DECIMAL(10, 2) NOT NULL, 
    image_url VARCHAR(255), 
    category_id INT, 
    stock INT DEFAULT 0, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (category_id) REFERENCES categories(id) 
); 

-- 4. Bảng bình luận sản phẩm 
CREATE TABLE comments ( 
    id INT PRIMARY KEY AUTO_INCREMENT, 
    user_id INT, 
    product_id INT, 
    content TEXT NOT NULL, 
    approved BOOLEAN DEFAULT FALSE, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (user_id) REFERENCES users(id), 
    FOREIGN KEY (product_id) REFERENCES products(id) 
); 

-- 5. Bảng mã khuyến mãi 
CREATE TABLE promotions ( 
    id INT PRIMARY KEY AUTO_INCREMENT, 
    code VARCHAR(50) UNIQUE NOT NULL, 
    description TEXT, 
    discount_percent DECIMAL(5, 2), 
    start_date DATE, 
    end_date DATE, 
    active BOOLEAN DEFAULT TRUE 
); 

-- 6. Bảng theo dõi kho hàng (tùy chọn) 
CREATE TABLE inventory_logs ( 
    id INT PRIMARY KEY AUTO_INCREMENT, 
    product_id INT, 
    quantity INT, 
    log_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (product_id) REFERENCES products(id) 
);

-- 7. Bảng lưu token ghi nhớ đăng nhập
CREATE TABLE remember_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);