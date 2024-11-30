<?php
require_once './routes/router.php';
require_once 'controllers/auth/auth.controller.php';
require_once 'controllers/views/views.controller.php';
require_once 'middleware/global.middleware.php';

// Creamos las instancias
$views  = new ViewsContent();
$authController = new AuthController();


// Creamos rutas GET
$router->get('/', function () {
    include  'views/auth/login.php';
});

$router->get('/logout', function () use($authController) {
    $authController->logout();
 });

$router->get('/recover-password', function () {
   include 'views/pages/recover_password.php';
});

// Creamos rutas POST
$router->post('/login', function () use ($authController) {
    $authController->login();
});

$router->post('/recover-password', function () use ($authController) {
    $authController->recoverPassword();
});