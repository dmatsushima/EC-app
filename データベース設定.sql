cd /Applications/MAMP/Library/bin/mysql80/bin
./mysql -u root -p
password: root

CREATE DATABASE ec_db;

CREATE USER 'ec_user'@'localhost' IDENTIFIED BY 'ec_pass';
GRANT ALL PRIVILEGES ON * . * TO 'ec_user'@'localhost';
FLUSH PRIVILEGES;

//ログイン機能
use ec_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  is_admin BOOLEAN DEFAULT FALSE,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

//商品一覧と商品詳細ページの表示
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

