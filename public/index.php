<?php
require __DIR__ . '/../src/Database.php';

try {
    $pdo = Database::connect();
    echo 'Database connection works.';
} catch (PDOException $e) {
    echo 'Connection failed.';
}