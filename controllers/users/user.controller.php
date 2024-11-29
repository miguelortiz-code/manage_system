<?php 

require_once 'controllers/alerts/alerts.controller.php';
require_once 'middleware/global.middleware.php';
// require_once 'models/users/user.models.php';
class UserController{
    private $model;
    private $alert;

    private $middleware;

    public function __construct(){
        $this->alert = new AlertsController();
        $this->middleware = new GlobalSession();
        $this->middleware->session();
    }
}