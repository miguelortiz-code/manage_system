<?php

// Requerimos el enrrutador, las vistas, controlador
require_once './routes/router.php';
require_once 'controllers/views/views.controller.php';
require_once 'controllers/users/user.controller.php';
require_once 'middleware/global.middleware.php';

// Creamos las instancias

$views = new ViewsContent();
$userController =  new UserController();
$middleware = new GlobalSession();



$router->get('/users', function () use($views, $middleware) {
    $middleware->checkAutentication(); // Verifica que el usuario está autenticado
    $views->render('views/users/user_read.php');
});

$router->get('/profile', function () use($views, $middleware) {
    $middleware->checkAutentication(); // Verifica que el usuario está autenticado
    $views->render('views/users/profile.php');
});

$router->get('/change-password', function () use($views, $middleware) {
    $middleware->checkAutentication(); // Verifica que el usuario está autenticado
    $views->render('views/pages/change.password.php');
});