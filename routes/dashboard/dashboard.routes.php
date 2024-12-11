<?php
require_once './routes/router.php';
require_once 'controllers/views/views.controller.php';
require_once 'middleware/global.middleware.php';

// Creamos las instancias
$views =  new ViewsContent();
$middleware = new GlobalSession();

// Creando rutas
$router->get('/dashboard', function () use($views, $middleware) {
    $middleware->checkAutentication(); // Verifica que el usuario está autenticado
    $views->render('views/dashboard/dashboard.php');
});

$router->get('/settings', function() use($views, $middleware){
    $middleware->checkAutentication(); // Verifica que el usuario está autenticado
    $views->render('views/pages/account.php');
});

$router->get('/permissions', function () use($views, $middleware){
    $middleware->checkAutentication(); // Verifica que el usuario está autenticado
    $views->render('views/dashboard/permission.php');
});

$router->get('/assign-permissions', function () use($views, $middleware){
    $middleware->checkAutentication(); // Verifica que el usuario está autenticado
    $views->render('views/dashboard/assign.permissions.php');
});