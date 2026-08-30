CREATE DATABASE IF NOT EXISTS hotel_db;
USE hotel_db;

CREATE TABLE IF NOT EXISTS menu_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  description TEXT,
  price DECIMAL(10,2),
  category VARCHAR(50),
  image_url VARCHAR(255) DEFAULT ''
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  table_no INT,
  total_price DECIMAL(10,2),
  status VARCHAR(50) DEFAULT 'Pending',
  order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  menu_item_id INT,
  quantity INT,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS admin_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(255)
);

-- fixed menu (explicit IDs for easy lookup)
INSERT INTO menu_items (id, name, description, price, category) VALUES
(101, 'Margherita Pizza', 'Classic cheese pizza', 199.00, 'Pizza'),
(102, 'Veg Burger', 'Veg patty with lettuce and sauce', 99.00, 'Burgers'),
(103, 'French Fries', 'Crispy potato fries', 69.00, 'Sides'),
(104, 'Cold Coffee', 'Iced coffee with milk', 89.00, 'Beverages'),
(105, 'Paneer Butter Masala', 'Creamy paneer curry', 149.00, 'Main Course'),
(106, 'Plain Naan', 'Tandoori flatbread', 29.00, 'Bread');

-- admin user
INSERT INTO admin_users (username, password) VALUES ('admin', MD5('admin123'));

-- Note: Menu is fixed — admin cannot change items in this version.
