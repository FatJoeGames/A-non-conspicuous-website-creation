<?php
// db.php
$dsn = "mysql:host=127.0.0.1;dbname=ht_db_sec;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, 'ht_db_usr', 'ht_db_sec2026!', $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
