<?php
// Database configuration
const DB_HOST = 'localhost';       // Replace with your host name
const DB_USERNAME = 'root';        // Replace with your database username
const DB_PASSWORD = '';            // Replace with your database password
const DB_NAME = 'minipos';         // Replace with your database name

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, display error message
    die('Connection failed: ' . $e->getMessage());
}
?>
