<?php
require_once 'db.php';

class User {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    // Create a new user (signup). Passwords are hashed.
    public function createUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword
        ]);
    }

    // Retrieve a user record by username.
    public function getUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
