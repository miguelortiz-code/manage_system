<?php 

class ViewsContent {
    // Renderizar la vista
    public function render($viewPath, $localData = []) {
        // Extrae las variables locales para usarlas en la vista
        extract($localData);

        // Define la variable $views para ser usada en el template
        $views = $viewPath;

        // Carga la plantilla principal
        $views = include  'views/includes/template.dashboard.php';
    }
}