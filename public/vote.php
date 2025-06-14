<?php
require_once '../controllers/ProjectController.php';
if (isset($_GET['id'], $_GET['vote_type'])) {
    $controller = new ProjectController();
    $controller->updateRating($_GET['id'], $_GET['vote_type']);
} else {
    header("Location: ../index.php?action=list&error=Missing parameters");
    exit;
}
