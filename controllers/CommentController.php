<?php
require_once 'models/Comment.php';

class CommentController {
    private $commentModel;
    
    public function __construct() {
        $this->commentModel = new Comment();
    }
    
    public function addComment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectId = $_POST['project_id'] ?? null;
            $commentText = trim($_POST['comment'] ?? '');
            $username = $_SESSION['username'] ?? '';
            
            if (!$projectId || empty($username) || empty($commentText)) {
                header("Location: index.php?action=project&id=" . $projectId . "&error=Missing comment or project ID");
                exit;
            }
            
            $this->commentModel->addComment($projectId, $username, $commentText);
            header("Location: index.php?action=project&id=" . $projectId . "&success=Comment added successfully");
            exit;
        }
    }
}
