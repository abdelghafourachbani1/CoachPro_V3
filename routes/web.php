<?php

require_once __DIR__ . '/../core/session.php';
require_once __DIR__ . '/../core/security.php';
require_once __DIR__ . '/../app/controllers/controller.php';
require_once __DIR__ . '/../app/controllers/homecontroller.php';
require_once __DIR__ . '/../app/controllers/Authcontroller.php';
require_once __DIR__ . '/../app/controllers/coachcontroller.php';
require_once __DIR__ . '/../app/controllers/sportifcontroller.php';

Session::start();

$url = $_GET['url'] ?? 'home/index';
$url = explode('/', $url);

$controllerName = ucfirst($url[0]) . 'Controller';
$method = $url[1] ?? 'index';

if (class_exists($controllerName)) {
    $controller = new $controllerName();
    
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Méthode $method introuvable";
    }
} else {
    echo "Controller $controllerName introuvable";
}
