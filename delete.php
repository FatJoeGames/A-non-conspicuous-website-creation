<?php
// delete.php
session_start();
require 'db.php';
if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT storage_name FROM files WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
    if ($file = $stmt->fetch()) {
        if (file_exists($path = 'uploads/' . $file['storage_name'])) unlink($path);
        $pdo->prepare("DELETE FROM files WHERE id = ?")->execute([$_GET['id']]);
    }
}
header("Location: dashboard.php");
?>
