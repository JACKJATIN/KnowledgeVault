<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // First, check if a full DATABASE_URL is provided.
        $databaseUrl = getenv('DATABASE_URL');
        if ($databaseUrl) {
            // Example format: postgresql://user:pass@host:port/dbname
            $url = parse_url($databaseUrl);
            if ($url === false) {
                die("Invalid DATABASE_URL format.");
            }
            $host = $url["host"];
            $port = $url["port"] ?? 5432;
            $dbname = ltrim($url["path"], '/');
            $user = $url["user"];
            $pass = $url["pass"];
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        } else {
            // Fallback to individual environment variables.
            $host = getenv('DB_HOST') ?: 'dpg-cugonkij1k6c73b09big-a.singapore-postgres.render.com';
            $port = getenv('DB_PORT') ?: '5432';
            $dbname = getenv('DB_NAME') ?: 'holtec_db';
            $user = getenv('DB_USER') ?: 'project_user';
            $pass = getenv('DB_PASS') ?: 'lNci13DYkaJrg1VoSra8KF6Kx1z73p0B';
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        }

        try {
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
