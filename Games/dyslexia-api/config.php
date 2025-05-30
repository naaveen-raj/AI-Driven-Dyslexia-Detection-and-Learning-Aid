<?php
$host = 'localhost';
$dbname = 'dyslexia_detection';
$username = 'root';
$password = ''; // Use your MySQL password if you have set one

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit;
}
?>