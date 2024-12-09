<?php
$host = 'localhost'; // Your database host
$dbname = 'itonga'; // Your database name
$username = 'sylo'; // Your database username
$password = 'sylogylo@003'; // Your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>