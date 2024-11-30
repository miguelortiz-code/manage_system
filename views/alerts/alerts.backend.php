<?php
require_once 'controllers/alerts/alerts.controller.php';

// Instancia el controlador de alertas y muestra cualquier alerta activa
$alertController = new AlertsController();
echo $alertController->showAlert(); // Muestra la alerta si existe