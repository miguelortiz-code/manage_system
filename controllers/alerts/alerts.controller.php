<?php

class AlertsController {
    // Configura la alerta en la sesión
    public function setAlert($type, $message) {
        $_SESSION['alert'] = [
            'type' => htmlspecialchars($type, ENT_QUOTES, 'UTF-8'), // Sanitiza el tipo
            'message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8') // Sanitiza el mensaje
        ];
    }

    // Verifica si hay una alerta en la sesión y la retorna como HTML
    public function checkAlert() {
        if (!isset($_SESSION['alert'])) {
            return ''; // Si no hay alerta, devuelve un string vacío
        }

        // Obtiene los valores de la alerta desde la sesión
        $type = $_SESSION['alert']['type'];
        $message = $_SESSION['alert']['message'];

        // Limpia la alerta de la sesión antes de generar el HTML
        $this->clearAlert();

        // Genera el HTML para mostrar la alerta
        return $this->renderAlert($type, $message);
    }

    // Genera el HTML de la alerta
    private function renderAlert($type, $message) {
        return "
        <div class='alert alert-{$type}'>
            <p class='alert__message'>{$message}</p>
        </div>";
    }

    // Muestra la alerta automáticamente si existe
    public function showAlert() {
        echo $this->checkAlert(); // Reutiliza el método checkAlert
    }

    // Limpia la alerta de la sesión
    private function clearAlert() {
        unset($_SESSION['alert']);
    }
}