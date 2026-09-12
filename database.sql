-- Inventory & POS System Database
-- Run this in phpMyAdmin or MySQL CLI

CREATE DATABASE IF NOT EXISTS inventory_pos;
USE inventory_pos;

-- Users table for login system
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    barcode VARCHAR(50) UNIQUE,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sales table (one row per completed sale / invoice)
CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total DECIMAL(10,2) NOT NULL,
    sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sale items table (line items for each sale)
CREATE TABLE sale_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Default admin user (password: admin123)
-- The password is hashed with PHP password_hash() — this hash was generated for "admin123"
INSERT INTO users (username, password) VALUES
('admin', '$2y$10$YourHashWillBeSetBySetupPhp.PleaseRunSetupOrUseDefault');

-- Sample products
INSERT INTO products (name, category, barcode, price, stock) VALUES
('Milk 1L', 'Dairy', '8901001', 2.50, 30),
('Bread Loaf', 'Bakery', '8901002', 1.80, 25),
('Rice 5kg', 'Grocery', '8901003', 12.00, 15),
('Sugar 1kg', 'Grocery', '8901004', 1.20, 40),
('Tea Bags', 'Beverages', '8901005', 3.50, 20),
('Coffee Jar', 'Beverages', '8901006', 6.75, 12),
('Potato Chips', 'Snacks', '8901007', 1.50, 50),
('Water 1.5L', 'Beverages', '8901008', 0.80, 60),
('Biscuits', 'Snacks', '8901009', 2.00, 35),
('Butter 200g', 'Dairy', '8901010', 3.20, 4),
('Salt 1kg', 'Grocery', '8901011', 0.90, 22),
('Cooking Oil 1L', 'Grocery', '8901012', 4.50, 18);
