<?php
require_once __DIR__ . '/Database.php';

class Auth
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function attempt(string $email, string $password): bool
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT id, name, password_hash FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        self::start();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        return true;
    }

    public static function check(): bool
    {
        self::start();
        return isset($_SESSION['user_id']);
    }

    public static function requireLogin(string $loginUrl = 'login.php'): void
    {
        if (!self::check()) {
            header('Location: ' . $loginUrl);
            exit;
        }
    }

    public static function logout(): void
    {
        self::start();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }
}