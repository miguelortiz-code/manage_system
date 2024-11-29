<?php

// Requerimos el enrrutador, las vistas, controlador
require_once './routes/router.php';
require_once 'controllers/views/views.controller.php';
require_once 'controllers/users/user.controller.php';

// Creamos las instancias

$views = new ViewsContent();
$userController =  new UserController();



$router->get('/users', function () use ($views) {
    $views->render('views/users/user_read.php');
});