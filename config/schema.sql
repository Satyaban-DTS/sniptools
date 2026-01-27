-- database/schema.sql

CREATE DATABASE IF NOT EXISTS sniptools_db;
USE sniptools_db;

CREATE TABLE IF NOT EXISTS categories (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    icon VARCHAR(50),
    sort_order INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS tools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category_id VARCHAR(50),
    icon VARCHAR(50),
    is_featured BOOLEAN DEFAULT FALSE,
    view_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS settings (
    `key` VARCHAR(50) PRIMARY KEY,
    value TEXT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS visits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page VARCHAR(255),
    ip_hash VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'admin'
) ENGINE=InnoDB;

-- Seed Data
INSERT INTO categories (id, name, icon, sort_order) VALUES
('text', 'Text Tools', 'fa-font', 1),
('developer', 'Developer Tools', 'fa-code', 2),
('image', 'Image Tools', 'fa-image', 3),
('converters', 'Converters', 'fa-exchange-alt', 4),
('tailwind', 'Tailwind Tools', 'fa-wind', 5);

INSERT INTO tools (slug, name, description, category_id, icon, is_featured) VALUES
('json-formatter', 'JSON Formatter', 'Validate, beautify, and minify your JSON data.', 'developer', 'fa-code', TRUE),
('word-counter', 'Word Counter', 'Counting words, characters, and reading time in real-time.', 'text', 'fa-font', TRUE),
('qr-generator', 'QR Code Generator', 'Generate custom QR codes with ease.', 'converters', 'fa-qrcode', TRUE),
('tailwind-shadow', 'Tailwind Shadow Gen', 'Interact with shadows and get Tailwind CSS classes.', 'tailwind', 'fa-wind', TRUE);
