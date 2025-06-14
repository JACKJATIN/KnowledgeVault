<?php
require_once 'db.php';

class Comment {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    
    // Add a comment to a project/document.
    public function addComment($projectId, $username, $comment) {
        $sql = "INSERT INTO comments (project_id, username, comment, creation_date)
                VALUES (:project_id, :username, :comment, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':project_id' => $projectId,
            ':username'   => $username,
            ':comment'    => $comment
        ]);
    }
    
    // Retrieve all comments for a given project/document.
    public function getCommentsByProjectId($projectId) {
        $sql = "SELECT * FROM comments WHERE project_id = :project_id ORDER BY creation_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':project_id' => $projectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
