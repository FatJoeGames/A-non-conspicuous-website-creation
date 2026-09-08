<?php
// create_user.php (RUN ONCE, THEN DELETE)
require 'db.php';
$hash = password_hash('Password123!', PASSWORD_DEFAULT);
$pdo->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)")->execute(['test@zoneup.local', $hash]);
echo "User created.";
?>
