<?php
session_start();

require_once 'controllers/ProjectController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/CommentController.php';

$action = $_GET['action'] ?? 'list';

// If the user is not logged in and action is not login or signup, force redirect to login.
if (!isset($_SESSION['username']) && !in_array($action, ['login', 'signup'])) {
    header("Location: index.php?action=login");
    exit;
}

switch ($action) {
    case 'add':
        $controller = new ProjectController();
        $controller->addProject();
        break;
    case 'list':
        $controller = new ProjectController();
        $controller->viewProjects();
        break;
    case 'project':
        $controller = new ProjectController();
        $controller->viewProjectDetails();
        break;
    case 'addcomment':
        $controller = new CommentController();
        $controller->addComment();
        break;
    case 'rate':
        if (isset($_GET['id'], $_GET['stars'])) {
            $controller = new ProjectController();
            $controller->updateRating($_GET['id'], $_GET['stars']);
        } else {
            header("Location: index.php?action=list&error=Missing parameters");
            exit;
        }
        break;
    case 'signup':
        $controller = new UserController();
        $controller->signup();
        break;
    case 'login':
        $controller = new UserController();
        $controller->login();
        break;
    case 'logout':
        $controller = new UserController();
        $controller->logout();
        break;
    default:
        $controller = new ProjectController();
        $controller->viewProjects();
        break;
}