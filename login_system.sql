
CREATE DATABASE IF NOT EXISTS login_system;
USE login_system;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL
);

-- Demo accounts use the password: BlueSky@2026
INSERT INTO users (email, password, role)
VALUES
(
    'admin@example.com',
    '$2y$10$cq7D61Sj5HaMwYjOag/LHuru.4ND93kSJ0HefHC5We3YSWgZH28tq',
    'admin'
),
(
    'staff@example.com',
    '$2y$10$cq7D61Sj5HaMwYjOag/LHuru.4ND93kSJ0HefHC5We3YSWgZH28tq',
    'staff'
);
