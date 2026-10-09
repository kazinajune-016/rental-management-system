<?php
// Usage: php database/create_landlord.php "Name" email@example.com password
if (PHP_SAPI !== 'cli') {
    exit('Run this script from the command line.');
}
if ($argc !== 4) {
    exit("Usage: php database/create_landlord.php \"Name\" email password\n");
}

require __DIR__ . '/../src/Database.php';

[, $name, $email, $password] = $argv;

try {
    $pdo = Database::connect();
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
    $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
    echo "Landlord account created.\n";
} catch (PDOException $e) {
    echo "Could not create account. Does that email already exist?\n";
}