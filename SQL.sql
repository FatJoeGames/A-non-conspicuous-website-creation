-- Run in MariaDB (sudo mysql)
CREATE DATABASE IF NOT EXISTS ht_db_sec;
USE ht_db_sec;

CREATE USER IF NOT EXISTS 'ht_db_usr'@'127.0.0.1' IDENTIFIED BY 'ht_db_usr2026!';
GRANT ALL PRIVILEGES ON ht_db_sec.* TO 'ht_db_usr'@'127.0.0.1';
FLUSH PRIVILEGES;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    storage_name VARCHAR(255) NOT NULL,
    file_size INT NOT NULL,
    upload_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
