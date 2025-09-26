-- Drop existing database if exists
DROP DATABASE IF EXISTS craftyHive;

-- Create main database and use it
CREATE DATABASE craftyHive;
USE craftyHive;

-- Users table (for login and registration)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Booking table
CREATE TABLE booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    occasion VARCHAR(50),
    date DATE NOT NULL,
    delivery_time DATETIME NOT NULL,
    delivery_address VARCHAR(255) NOT NULL,
    message TEXT,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);


-- Booking Items
CREATE TABLE `booking_items` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  booking_id INT NOT NULL,
  bouquet_name VARCHAR(255) NOT NULL,
  quantity INT NOT NULL,
  FOREIGN KEY (`booking_id`) REFERENCES `booking`(`id`) ON DELETE CASCADE
);
