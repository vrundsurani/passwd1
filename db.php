<?php
// db.php
try {
    $pdo = new PDO('sqlite:apps.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Create table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS apps (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        description TEXT,
        icon TEXT,
        file TEXT
    )");
} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}
?>
