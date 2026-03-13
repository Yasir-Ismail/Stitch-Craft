CREATE DATABASE IF NOT EXISTS stitchcraft;
USE stitchcraft;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin password is 'admin123'
INSERT INTO admins (username, password) VALUES ('admin', '$2y$10$Y14pOMZ6X8K3t0mJkXzN1eq6z2r8i/Qv8n4P8r4P8r4P8q3tQv8n4');

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE measurements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    chest DECIMAL(5,2),
    shoulder DECIMAL(5,2),
    sleeve DECIMAL(5,2),
    shirt_length DECIMAL(5,2),
    waist DECIMAL(5,2),
    shalwar_length DECIMAL(5,2),
    bust DECIMAL(5,2),
    hip DECIMAL(5,2),
    dress_length DECIMAL(5,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    dress_type VARCHAR(50) NOT NULL,
    fabric_details TEXT,
    delivery_date DATE NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    status ENUM('Pending', 'In Stitching', 'Ready', 'Delivered') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);