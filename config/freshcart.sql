-- ============================================
-- freshCart database
-- Import this whole file from phpMyAdmin -> Import
-- ============================================

CREATE DATABASE IF NOT EXISTS freshcart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE freshcart;

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    discount INT DEFAULT 0,
    quantity INT DEFAULT 0,
    img VARCHAR(500),
    description TEXT
);

-- Users table (for the login/register pages)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(30),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cart table (linked to session/user)
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Favorites table
CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Contacts table (messages submitted from pages/contact.php)
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders table (created from pages/checkout.php once the user places an order)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    address VARCHAR(500) NOT NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20),
    payment_method VARCHAR(20) NOT NULL DEFAULT 'cash',
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order items table (snapshot of each product in an order, so price/title stay
-- correct even if the product changes or gets deleted later)
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Product data (migrated from db.json)
INSERT INTO products (id, title, category, price, discount, quantity, img, description) VALUES
(1, 'Product 1', 'Delicious', 193, 14, 10, 'https://i.ibb.co/b5gYLTbV/1-2.png', 'this is a great product'),
(3, 'Product 2', 'Delicious', 408, 35, 42, 'https://i.ibb.co/4nsPcwh8/1-4.png', 'this is a great product'),
(4, 'Product 3', 'Dairy', 1887, 1, 87, 'https://i.ibb.co/pv6SNJtp/1-6.png', 'this is a great product'),
(5, 'Product 4', 'Dairy', 226, 25, 28, 'https://i.ibb.co/SwVcD10Q/1.png', 'this is a great product'),
(7, 'Product 5', 'Delicious', 600, 1, 81, 'https://i.ibb.co/0pZmb8zh/2-2.png', 'this is a great product'),
(9, 'Product 6', 'Delicious', 1107, 43, 87, 'https://i.ibb.co/zTJX7Wm1/2-4.png', 'this is a great product'),
(11, 'Product 7', 'Delicious', 1400, 48, 11, 'https://i.ibb.co/G4n3P49w/2-6.png', 'this is a great product'),
(13, 'Product 8', 'Delicious', 232, 37, 85, 'https://i.ibb.co/h1Dk8FnG/2.png', 'this is a great product'),
(14, 'Product 9', 'Beverage', 1194, 20, 6, 'https://i.ibb.co/Wm6jp75/3-2.png', 'this is a great product'),
(15, 'Product 10', 'Delicious', 148, 0, 55, 'https://i.ibb.co/ZRzSVqQT/3-4.png', 'this is a great product'),
(16, 'Product 11', 'Beverage', 1898, 29, 61, 'https://i.ibb.co/xtrSvFVH/3-5.png', 'this is a great product'),
(17, 'Product 12', 'Fruits & Vegetables', 751, 15, 56, 'https://i.ibb.co/WvW9TrRq/4-1.png', 'this is a great product'),
(18, 'Product 13', 'Snacks', 635, 45, 96, 'https://i.ibb.co/Cs2vtRcj/4-2.png', 'this is a great product'),
(19, 'Product 14', 'Cooking', 501, 48, 91, 'https://i.ibb.co/MyWN6PFc/4-3.png', 'this is a great product'),
(20, 'Product 15', 'Beverage', 286, 1, 95, 'https://i.ibb.co/n8R1MWrt/5-1.png', 'this is a great product'),
(21, 'Product 16', 'Fruits & Vegetables', 1922, 28, 87, 'https://i.ibb.co/4gdBJvv2/5-2.png', 'this is a great product'),
(22, 'Product 17', 'Snacks', 1195, 21, 84, 'https://i.ibb.co/DDzhGh9P/5.png', 'this is a great product'),
(23, 'Product 18', 'Dairy', 1515, 33, 31, 'https://i.ibb.co/LXfLTTSb/6-1.png', 'this is a great product'),
(24, 'Product 19', 'Fruits & Vegetables', 625, 34, 93, 'https://i.ibb.co/zV7dQGXH/6-2.png', 'this is a great product'),
(25, 'Product 20', 'Delicious', 1185, 22, 34, 'https://i.ibb.co/TBcnsBzj/6.png', 'this is a great product'),
(26, 'Product 21', 'Dairy', 721, 44, 63, 'https://i.ibb.co/213WNntB/7-1.png', 'this is a great product'),
(27, 'Product 22', 'Snacks', 1408, 23, 76, 'https://i.ibb.co/Mxb1tygr/7-2.png', 'this is a great product'),
(28, 'Product 23', 'Beverage', 1687, 29, 43, 'https://i.ibb.co/7xhnvkJ6/7.png', 'this is a great product'),
(29, 'Product 24', 'Cooking', 1560, 14, 58, 'https://i.ibb.co/tpSRLgbf/8-1.png', 'this is a great product'),
(30, 'Product 25', 'Cooking', 1424, 16, 9, 'https://i.ibb.co/FGpQFq3/8-2.png', 'this is a great product'),
(31, 'Product 26', 'Dairy', 1685, 15, 10, 'https://i.ibb.co/qYHXXRcs/8.png', 'this is a great product'),
(32, 'Product 27', 'Fruits & Vegetables', 526, 41, 36, 'https://i.ibb.co/Txm5Chb2/9-1.png', 'this is a great product'),
(33, 'Product 28', 'Beverage', 800, 4, 85, 'https://i.ibb.co/Kz0whKrq/9.png', 'this is a great product'),
(34, 'Product 29', 'Cooking', 334, 19, 93, 'https://i.ibb.co/9mF0dFJ4/10-1.png', 'this is a great product'),
(35, 'Product 30', 'Cooking', 161, 46, 2, 'https://i.ibb.co/Z6cDpdHh/10-2.png', 'this is a great product'),
(36, 'Product 31', 'Dairy', 282, 1, 78, 'https://i.ibb.co/rK0LvF5k/10.png', 'this is a great product'),
(37, 'Product 32', 'Delicious', 650, 16, 7, 'https://i.ibb.co/Fb9Wqytg/11-1.png', 'this is a great product'),
(38, 'Product 33', 'Dairy', 867, 37, 44, 'https://i.ibb.co/r2Z4SBrV/11-2.png', 'this is a great product'),
(39, 'Product 34', 'Snacks', 1947, 40, 97, 'https://i.ibb.co/6RB8hP1q/11.png', 'this is a great product'),
(40, 'Product 35', 'Delicious', 1889, 13, 57, 'https://i.ibb.co/nsfsVfCy/12-1.png', 'this is a great product'),
(41, 'Product 36', 'Fruits & Vegetables', 810, 35, 66, 'https://i.ibb.co/DqBwN3R/12-2.png', 'this is a great product'),
(42, 'Product 37', 'Dairy', 1450, 26, 74, 'https://i.ibb.co/dsHCxfWF/12.png', 'this is a great product'),
(43, 'Product 38', 'Cooking', 1294, 49, 63, 'https://i.ibb.co/jkV6wdnc/13-1.png', 'this is a great product'),
(44, 'Product 39', 'Snacks', 732, 39, 22, 'https://i.ibb.co/j91k4s3X/13.png', 'this is a great product'),
(45, 'Product 40', 'Cooking', 841, 24, 97, 'https://i.ibb.co/Xkr1vzLq/14.png', 'this is a great product'),
(46, 'Product 41', 'Snacks', 1488, 37, 6, 'https://i.ibb.co/cXr1NY4j/15.png', 'this is a great product'),
(47, 'Product 42', 'Delicious', 1898, 42, 67, 'https://i.ibb.co/9QMQ43h/16.png', 'this is a great product'),
(48, 'Product 43', 'Fruits & Vegetables', 1915, 14, 83, 'https://i.ibb.co/dwVMj4HX/17.png', 'this is a great product'),
(49, 'Product 44', 'Beverage', 664, 1, 100, 'https://i.ibb.co/Gfz9M1fv/18.png', 'this is a great product');
