<?php 

class Router{
    private $routes  = [];
    
    // Definir las rutas de método GET
    public function get($path, $callback){
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path,$callback){
        $this->routes['POST'][$path] = $callback;
    }

    // Manejar la ruta de acuerdo con el método de la solicitud
    public function dispatch(){
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        
        // Elliminar la parte del dominio de la URI (Si es necesario)
        $uri = parse_url($uri, PHP_URL_PATH);

    
        // Si existe la ruta se ejecutara
        if(isset($this->routes[$method][$uri])){
            call_user_func($this->routes[$method][$uri]);
        }else{
            // Si no encuentra la ruta, mostrará la página de error 404
            include 'views/pages/error404.php';
        }
    }
}

$router = new Router(); // Creando la instancia del enrrutador

require_once 'auth/auth.routes.php';
require_once 'users/users.routes.php';
require_once 'dashboard/dashboard.routes.php';