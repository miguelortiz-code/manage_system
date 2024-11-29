<?php
require_once './routes/router.php';
require_once 'controllers/views/views.controller.php';

$views =  new ViewsContent();

$router->get('/dashboard', function () use ($views) {
    $views->render('views/pages/dashboard.php');
});

$router->get('/settings', function() use($views){
    $views->render('views/pages/account.php');
});
