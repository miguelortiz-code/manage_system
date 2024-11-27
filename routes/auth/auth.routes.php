<?php
require_once './routes/router.php'; // Requerimos el enrrutador
require_once 'controllers/auth/auth.controller.php';
require_once 'controllers/views/views.controller.php';

$views  = new ViewsContent();
$authController = new AuthController(); //Instancia del controlador




// MÉTODOS GET
$router->get('/', function () {
    include  'views/auth/login.php';
});

$router->get('/users', function () use ($views) {
    $views->render('views/users/user_read.php');
});

$router->get('/account', function () use ($views) {
    $views->render('views/pages/account.php');
});

$router->get('/dashboard', function () use ($views) {
    $views->render('views/pages/dashboard.php');
});

$router->get('/recover-password', function () {
   include 'views/pages/recover_password.php';
});

// MÉTODOS POST
$router->post('/login', function () use ($authController) {
    $authController->login();
});

$router->post('/recover-password', function () use ($authController) {
    $authController->recoverPassword();
});
