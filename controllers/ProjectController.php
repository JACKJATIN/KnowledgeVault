<?php
require_once 'models/Project.php';

class ProjectController {
    private $projectModel;

    public function __construct() {
        $this->projectModel = new Project();
    }

    // Add a new document record (only one file allowed per submission).
    public function addProject() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Auto-fill "author" from session; ensure session_start() is called in index.php.
            $data = [
                'section'              => (trim($_POST['category']) === 'Other' && !empty($_POST['custom_category']))
                                            ? trim($_POST['custom_category'])
                                            : trim($_POST['category'] ?? ''),
                'type_of_document'     => trim($_POST['type_of_document'] ?? ''),
                'source_of_information'=> trim($_POST['source_of_information'] ?? ''),
                'author'               => $_SESSION['username'] ?? '',  // Auto-filled from session.
                'description'          => trim($_POST['description'] ?? '')
            ];
            
            if (empty($data['section']) || empty($data['author'])) {
                $error = "Section and author are required.";
            }
            
            // Process file upload: only one file allowed.
            if (!$error && isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) {
                    if (!mkdir($uploadDir, 0777, true)) {
                        $error = "Failed to create uploads directory.";
                    }
                }
                $fileName = basename($_FILES['file']['name']);
                // Sanitize file name: replace spaces with underscores.
                $fileName = preg_replace('/\s+/', '_', $fileName);
                $uniqueFileName = uniqid() . "_" . $fileName;
                $filePath = $uploadDir . $uniqueFileName;
                
                if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                    $error = "Error uploading file: " . $fileName . " (Error Code: " . $_FILES['file']['error'] . ")";
                } elseif (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                    $error = "Error uploading file: " . $fileName;
                } else {
                    // File uploaded successfully; insert record.
                    $this->projectModel->addProject($data, $filePath);
                }
            } else {
                $error = "Please upload a file.";
            }
            
            if (empty($error)) {
                header("Location: index.php?action=list&success=1");
                exit;
            }
        }
        $page_title = "Add Document";
        ob_start();
        require 'views/add_project_template.php';
        $content = ob_get_clean();
        require 'views/layout.php';
    }

    // Display all document records with search and sorting.
    public function viewProjects() {
        $filters = [
            'search'   => $_GET['search'] ?? '',
            'section'  => $_GET['category'] ?? '',
            'author'   => $_GET['author'] ?? ''
        ];
        $sort_by = $_GET['sort_by'] ?? 'creation_date';
        $sort_order = $_GET['sort_order'] ?? 'DESC';
        
        $projects = $this->projectModel->getAllProjects($filters, $sort_by, $sort_order);
        $page_title = "Documents List";
        ob_start();
        require 'views/project_template.php';
        $content = ob_get_clean();
        require 'views/layout.php';
    }

    // Display a dedicated project page with details and comments.
    public function viewProjectDetails() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?action=list&error=Missing project ID");
            exit;
        }
        $projectId = $_GET['id'];
        $project = $this->projectModel->getProjectById($projectId);
        if (!$project) {
            header("Location: index.php?action=list&error=Project not found");
            exit;
        }
        require_once 'models/Comment.php';
        $commentModel = new Comment();
        $comments = $commentModel->getCommentsByProjectId($projectId);
        
        $page_title = "Project Details";
        ob_start();
        require 'views/project_details.php';
        $content = ob_get_clean();
        require 'views/layout.php';
    }

    // Update star rating for a document.
    // Expects a GET parameter "stars" (an integer from 1 to 5).
    public function updateRating($projectId, $stars) {
        $stars = (int)$stars;
        if ($stars < 1 || $stars > 5) {
            header("Location: index.php?action=list&error=Invalid star rating");
            exit;
        }
        if (!isset($_SESSION['voted_projects'])) {
            $_SESSION['voted_projects'] = [];
        }
        if (isset($_SESSION['voted_projects'][$projectId])) {
            $oldStar = $_SESSION['voted_projects'][$projectId];
            if ($oldStar == $stars) {
                header("Location: index.php?action=list&error=You have already given this rating");
                exit;
            } else {
                $this->projectModel->changeStarRating($projectId, $oldStar, $stars);
                $_SESSION['voted_projects'][$projectId] = $stars;
                header("Location: index.php?action=list&success=Rating updated successfully");
                exit;
            }
        } else {
            $this->projectModel->updateStarRating($projectId, $stars);
            $_SESSION['voted_projects'][$projectId] = $stars;
            header("Location: index.php?action=list&success=Rating recorded");
            exit;
        }
    }
}
