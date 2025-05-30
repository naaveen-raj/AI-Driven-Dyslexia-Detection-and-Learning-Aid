<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, OPTIONS');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
header('Content-Type: application/json');
include 'config.php';

$user_id = $_GET['user_id'] ?? null;
$game_name = $_GET['game_name'] ?? '';

if (!$user_id || !$game_name) {
    echo json_encode(['error' => 'Missing user_id or game_name']);
    exit;
}

$stmt = $pdo->prepare("SELECT level, score FROM game_progress WHERE user_id = ? AND game_name = ?");
$stmt->execute([$user_id, $game_name]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo json_encode($result);
} else {
    echo json_encode(['level' => 1, 'score' => 0]);
}
?>