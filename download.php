<?php
// download.php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) exit;

$stmt = $pdo->prepare("SELECT original_name, storage_name FROM files WHERE id = ? AND user_id = ?");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);
$file = $stmt->fetch();

if ($file && file_exists($path = 'uploads/' . $file['storage_name'])) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file['original_name']) . '"');
    header('Content-Length: ' . filesize($path));
    readfile($path);
}
?>
