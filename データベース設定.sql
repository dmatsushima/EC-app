cd /Applications/MAMP/Library/bin/
./mysql -u root -p

CREATE DATABASE ec_db;

CREATE USER 'ec_user'@'localhost' IDENTIFIED BY 'ec_pass';
GRANT ALL PRIVILEGES ON * . * TO 'ec_user'@'localhost';
FLUSH PRIVILEGES;

use ec_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  is_admin BOOLEAN DEFAULT FALSE,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
