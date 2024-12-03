<?php

require_once 'models/auth/auth.model.php';
require_once 'controllers/alerts/alerts.controller.php';
require_once 'middleware/global.middleware.php';

class AuthController
{
    private $model;
    private $alert;
    private $middleware;

    public function __construct()
    {
        $this->model = new AuthModel();
        $this->alert = new AlertsController();
        $this->middleware = new GlobalSession();
        $this->middleware->session();

        // Genera un token CSRF si no está en la sesión
        if (!isset($_SESSION['csfr_token']) || !isset($_POST['csfr_token'])) {
            $_SESSION['csfr_token'] = $this->model->generateTokenCSFR();
        }

        // Configurar zona horaria
        date_default_timezone_set('America/Bogota');
    }

    public function login()
    {
        if (isset($_POST['submit'])) {
            if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['csfr_token'])) {
                $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
                $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8');
                $token = $_POST['csfr_token'];
                $rememberMe = isset($_POST['checkbox']); // Verificar si el checkbox está marcado

                // Validar token CSRF
                if (!$this->validateCSRFToken($token)) {
                    $this->alert->setAlert('danger', 'Token CSRF inválido o expirado.');
                    header('Location: /');
                    exit;
                }

                // Validar campos
                if (empty($email) || empty($password)) {
                    $this->alert->setAlert('danger', 'Todos los campos son obligatorios.');
                    header('Location: /');
                    exit;
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->alert->setAlert('danger', 'El correo electrónico no es válido.');
                    header('Location: /');
                    exit;
                }

                // Obtener usuario
                $user = $this->model->getUserByEmail($email);
                // Destruir cualquier posible sesión previa para evitar retroceso
                session_regenerate_id(true); // Regenerar el ID de sesión
                if (!$user) {
                    $this->alert->setAlert('danger', 'El usuario no existe.');
                    header('Location: /');
                    exit;
                }

                // Validar estado del usuario
                if ($user['id_state'] == 0) {
                    $this->alert->setAlert('danger', 'Tu cuenta está bloqueada. Contacta al administrador.');
                    header('Location: /');
                    exit;
                }

                // Validar bloqueo por intentos fallidos
                if ($user['account_locked_until'] && strtotime($user['account_locked_until']) > time()) {
                    $this->alert->setAlert(
                        'danger',
                        'Tu cuenta está temporalmente bloqueada. Intenta nuevamente a las ' . date('H:i:s', strtotime($user['account_locked_until']))
                    );
                    header('Location: /');
                    exit;
                }

                // Verificar contraseña
                if (!password_verify($password, $user['password_user'])) {
                    $this->handleFailedLogin($user);
                    exit;
                }

                // Manejo de la cookie "recordar correo electrónico"
                if ($rememberMe) {
                    setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), "/"); // Guardar por 30 días
                } else {
                    if (isset($_COOKIE['remember_email'])) {
                        setcookie('remember_email', '', time() - 3600, "/"); // Eliminar cookie
                    }
                }

                // Iniciar sesión
                $this->handleSuccessfulLogin($user);
            }
        }
    }

    private function validateCSRFToken($token)
    {
        return $this->model->validateTokenCSFR($_SESSION['csfr_token'], $token);
    }

    private function handleFailedLogin($user)
    {
        $attempts = $user['login_attempts'] + 1;

        // Validar si debe bloquear la cuenta después de 10 intentos fallidos
        if ($attempts >= 10) {
            $this->model->desactivateUser($user['id_user']); // Bloquea la cuenta
            $this->alert->setAlert(
                'danger',
                'Tu cuenta ha sido bloqueada por múltiples intentos fallidos. Contacta al administrador.'
            );
        } else {
            // Bloqueo progresivo en función de los intentos fallidos
            if ($attempts % 3 == 0) { // Intentos 3, 6, 9, etc.
                $additionalSeconds = ($attempts == 3) ? 5 : (($attempts == 6) ? 10 : 15);
                $unlockTime = date('Y-m-d H:i:s', time() + $additionalSeconds);
                $this->model->incrementLoginAttempts($user['id_user'], $attempts, $unlockTime);
                $this->alert->setAlert('danger', "Demasiados intentos fallidos. Intenta nuevamente a las {$unlockTime}.");
            } else {
                $this->alert->setAlert('danger', 'Error de usuario o contraseña. Intenta nuevamente.');
            }
        }

        // Registrar el intento fallido
        $this->model->incrementLoginAttempts($user['id_user'], $attempts);
        $this->model->logLoginAttempt($user['id_user'], $_SERVER['REMOTE_ADDR'], false);

        header('Location: /');
        exit;
    }

    private function handleSuccessfulLogin($user)
    {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_name'] = $user['fullname_user'];
        $_SESSION['user_lastname'] = $user['lastname_user'];
        $_SESSION['user_image'] = $user['image_user'];
        $_SESSION['csfr_token'] = $this->model->generateTokenCSFR();

        // Reiniciar intentos fallidos
        $this->model->resetLoginAttempts($user['id_user']);

        // Registrar inicio de sesión exitoso
        $this->model->logLoginAttempt($user['id_user'], $_SERVER['REMOTE_ADDR'], true);

        $this->alert->setAlert('success', '¡Inicio de sesión exitoso! Bienvenido ' . $user['fullname_user']);
        header('Location: /dashboard');
        exit;
    }

    public function recoverPassword()
    {
        if (isset($_POST['submit'])) {
            if (isset($_POST['email'])) {
                $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
                // echo "El correo para la recuperacion de contraseña es: $email";

                if (empty($email)) {
                    $this->alert->setAlert('danger', 'El correo electronico es obligatorio');
                    header('Location: /recover-password');
                    exit;
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->alert->setAlert('danger', 'El correo ingresado no es válido');
                    header('Location: /recover-password');
                    exit;
                }
            }
        }
    }

    public function logout()
    {
        // Primero destruir la sesión
        session_unset();  // Elimina todas las variables de la sesión
        session_destroy();  // Destruye la sesión

        // Redirigir a la página de inicio
        header('Location: /');
        exit;
    }

}