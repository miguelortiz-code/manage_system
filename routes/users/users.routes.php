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



$router->get('/users', function () use($views, $middleware, $userController) {
    $middleware->checkAutentication(); // Verifica que el usuario está autenticado
    $userController->getAllUsers();
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

$router->get('/users/create-user', function() use($views, $middleware, $userController){
    $middleware->checkAutentication();
    $userController->getRoles();
    $views->render('views/users/user_create.php');
});

$router->get('/users/set-user-session', function() use($userController){
    $userController->setUserSession();
});


$router->get('/users/update-user', function() use($views, $middleware, $userController){
    $middleware->checkAutentication();
    $userController->getUserById();
    $userController->getRoles();
    $views->render('views/users/user_update.php');
});


$router->get('/users/delete-user', function() use($middleware, $userController){
    $middleware->checkAutentication();
    $userController->deactivateUser();
    $userController->deleteUser();
});
// Ruta para la método POST
$router->post('/create-user', function () use($middleware, $userController) {
    $middleware->checkAutentication();
    $userController->createUser();
});

// Ruta para actualizar usuarios
$router->post('/update-user', function() use($middleware, $userController){
    $middleware->checkAutentication();
    $userController->editUser();
});