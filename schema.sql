CREATE DATABASE IF NOT EXISTS shoestore CHARACTER SET utf8mb4;
USE shoestore;

CREATE TABLE users (
 id INT PRIMARY KEY AUTO_INCREMENT,
 email VARCHAR(255) UNIQUE NOT NULL,
 password VARCHAR(255) NOT NULL,
 name VARCHAR(100) NOT NULL,
 phone VARCHAR(20),
 role ENUM('admin','manager','user') DEFAULT 'user',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
 id INT PRIMARY KEY AUTO_INCREMENT,
 name VARCHAR(255) NOT NULL,
 description TEXT,
 category VARCHAR(100),
 brand VARCHAR(100),
 price DECIMAL(10,2) NOT NULL,
 color VARCHAR(50),
 material VARCHAR(100),
 status ENUM('active','hidden') DEFAULT 'active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO products(name,description,price) VALUES
('Кроссовки Nike','Спортивные кроссовки',5990),
('Ботинки зимние','Теплые зимние ботинки',7990),
('Туфли классические','Классические туфли',4990);
