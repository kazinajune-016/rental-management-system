CREATE DATABASE IF NOT EXISTS rental_management
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE rental_management;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE units (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  rent_amount DECIMAL(10,2) NOT NULL,
  status ENUM('vacant','occupied') NOT NULL DEFAULT 'vacant'
);

CREATE TABLE tenants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  phone VARCHAR(30),
  email VARCHAR(150),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE leases (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tenant_id INT NOT NULL,
  unit_id INT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE,
  rent_amount DECIMAL(10,2) NOT NULL,
  deposit DECIMAL(10,2) DEFAULT 0,
  status ENUM('active','ended') NOT NULL DEFAULT 'active',
  FOREIGN KEY (tenant_id) REFERENCES tenants(id),
  FOREIGN KEY (unit_id) REFERENCES units(id)
);

CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lease_id INT NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  paid_on DATE NOT NULL,
  month_covered DATE NOT NULL,
  method VARCHAR(50),
  FOREIGN KEY (lease_id) REFERENCES leases(id)
);