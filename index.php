<?php
require_once 'db.php';

$controllerName = $_GET['controller'] ?? 'album';
$action = $_GET['action'] ?? 'index';

switch ($controllerName) {
    case 'album':
        require_once 'controllers/AlbumController.php';
        $controller = new AlbumController($db);
        break;
    case 'photo':
        require_once 'controllers/PhotoController.php';
        $controller = new PhotoController($db);
        break;
    default:
        http_response_code(404);
        include '404.php';
        exit;
}

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    http_response_code(404);
    include '404.php';
}
