<?php
require_once __DIR__ . '/Database.php';

class Unit
{
    public static function all(): array
    {
        return Database::connect()->query('SELECT * FROM units ORDER BY name')->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connect()->prepare('SELECT * FROM units WHERE id = ?');
        $stmt->execute([$id]);
        $unit = $stmt->fetch();
        return $unit ?: null;
    }

    public static function validate(array $data): array
    {
        $errors = [];
        $name = trim($data['name'] ?? '');
        $rent = $data['rent_amount'] ?? '';
        $status = $data['status'] ?? '';

        if ($name === '' || mb_strlen($name) > 100) {
            $errors[] = 'Name is required (max 100 characters).';
        }
        if (!is_numeric($rent) || (float) $rent < 0) {
            $errors[] = 'Rent amount must be a number of 0 or more.';
        }
        if (!in_array($status, ['vacant', 'occupied'], true)) {
            $errors[] = 'Status must be vacant or occupied.';
        }
        return $errors;
    }

    public static function create(array $data): int
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('INSERT INTO units (name, rent_amount, status) VALUES (?, ?, ?)');
        $stmt->execute([trim($data['name']), $data['rent_amount'], $data['status']]);
        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $stmt = Database::connect()->prepare(
            'UPDATE units SET name = ?, rent_amount = ?, status = ? WHERE id = ?'
        );
        $stmt->execute([trim($data['name']), $data['rent_amount'], $data['status'], $id]);
    }
}