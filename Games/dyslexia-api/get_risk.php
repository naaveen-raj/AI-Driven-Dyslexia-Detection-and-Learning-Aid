<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, OPTIONS');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json');

// Include your database connection file
include 'config.php'; // Make sure this path is correct

// Get user_id from the query string
$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['error' => 'User ID required']);
    exit;
}

try {
    // Prepare and execute the query to get the latest risk_level for the user
    $stmt = $pdo->prepare("
        SELECT risk_level 
        FROM dyslexia_quiz 
        WHERE user_id = ? 
        ORDER BY submitted_at DESC 
        LIMIT 1
    ");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['risk_level']) {
        echo json_encode(['risk_level' => $result['risk_level']]);
    } else {
        echo json_encode(['risk_level' => null]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>