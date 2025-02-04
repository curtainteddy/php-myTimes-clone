<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'mytimes');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Create database if not exists
$db->query("CREATE DATABASE IF NOT EXISTS mytimes");
$db->select_db('mytimes');

// Create users table
$create_users_table = "
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$db->query($create_users_table);

// Create news table
$create_news_table = "
CREATE TABLE IF NOT EXISTS news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$db->query($create_news_table);

// Create notices table
$create_notices_table = "
CREATE TABLE IF NOT EXISTS notices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$db->query($create_notices_table);

// Create courses table
$create_courses_table = "
CREATE TABLE IF NOT EXISTS courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    duration VARCHAR(50),
    image VARCHAR(255)
)";
$db->query($create_courses_table);

// Create admin user if not exists
$admin_email = 'admin@admin.com';
$admin_password = password_hash('password', PASSWORD_DEFAULT);
$check_admin_exists = $db->query("SELECT * FROM users WHERE email = '$admin_email'");
if ($check_admin_exists->num_rows == 0) {
    $db->query("INSERT INTO users (full_name, email, password, role) VALUES ('Admin', '$admin_email', '$admin_password', 'admin')");
}

function sanitize($data) {
    global $db;
    return mysqli_real_escape_string($db, htmlspecialchars(trim($data)));
}
?>