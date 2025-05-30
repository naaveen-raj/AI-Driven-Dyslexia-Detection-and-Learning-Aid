<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST, OPTIONS');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit(); }
header('Content-Type: application/json');
include 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'] ?? null;
$game_name = $data['game_name'] ?? '';
$level = $data['level'] ?? 1;
$score = $data['score'] ?? 0;

if (!$user_id || !$game_name) {
    echo json_encode(['error' => 'Missing user_id or game_name']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO game_progress (user_id, game_name, level, score)
    VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE level = VALUES(level), score = VALUES(score), updated_at = CURRENT_TIMESTAMP");
$stmt->execute([$user_id, $game_name, $level, $score]);
echo json_encode(['success' => true]);
?>