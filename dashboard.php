<?php
// dashboard.php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit; }
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['file'];
    $original_name = basename($file['name']);
    $storage_name = bin2hex(random_bytes(16)) . '.' . pathinfo($original_name, PATHINFO_EXTENSION); 
    
    if (move_uploaded_file($file['tmp_name'], 'uploads/' . $storage_name)) {
        $pdo->prepare("INSERT INTO files (user_id, original_name, storage_name, file_size) VALUES (?, ?, ?, ?)")
            ->execute([$user_id, $original_name, $storage_name, $file['size']]);
        $msg = "Uploaded.";
    }
}
$files = $pdo->prepare("SELECT id, original_name, file_size, upload_date FROM files WHERE user_id = ? ORDER BY upload_date DESC");
$files->execute([$user_id]);
?>
<!DOCTYPE html>
<html><body>
    <h2>Dashboard | <a href="logout.php">Logout</a></h2>
    <?php if(isset($msg)) echo "<p>$msg</p>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required> <button type="submit">Upload</button>
    </form>
    <table border="1">
        <tr><th>Name</th><th>Size</th><th>Actions</th></tr>
        <?php foreach ($files->fetchAll() as $f): ?>
        <tr>
            <td><?= htmlspecialchars($f['original_name']) ?></td>
            <td><?= $f['file_size'] ?></td>
            <td>
                <a href="download.php?id=<?= $f['id'] ?>">Download</a> | 
                <a href="delete.php?id=<?= $f['id'] ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body></html>
