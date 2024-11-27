<?php 

require_once 'config/database.php';

class AuthModel {
    private $pdo;

    public function __construct() {
        $db = new Database(); // Crea la instancia de la base de datos
        $this->pdo = $db->getConnection();
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT id_user, email_user, fullname_user, lastname_user, password_user, 
                image_user, login_attempts, id_state, account_locked_until 
                FROM users WHERE email_user = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function generateTokenCSFR() {
        return bin2hex(random_bytes(32));
    }

    public function validateTokenCSFR($sessionToken, $postToken) {
        return $sessionToken && $postToken && hash_equals($sessionToken, $postToken);
    }

    public function resetLoginAttempts($user_id) {
        $stmt = $this->pdo->prepare('UPDATE users SET login_attempts = 0, account_locked_until = NULL WHERE id_user = :id');
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function incrementLoginAttempts($user_id, $attempts, $unlockTime = null) {
        $stmt = $this->pdo->prepare("UPDATE users 
                                     SET login_attempts = :attempts, account_locked_until = :unlock_time 
                                     WHERE id_user = :id_user");
        $stmt->bindParam(':attempts', $attempts, PDO::PARAM_INT);
        $stmt->bindParam(':unlock_time', $unlockTime, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function desactivateUser($user_id) {
        $stmt = $this->pdo->prepare('UPDATE users SET id_state = 0 WHERE id_user = :id');
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function logLoginAttempt($user_id, $ipAddress, $successful) {
        $stmt = $this->pdo->prepare("INSERT INTO logs (id_user, action, ip_address, log_created_at) 
                                     VALUES (:id_user, :action, :ip_address, NOW())");
        $action = $successful ? 'Login exitoso' : 'Intento de login fallido';
        $stmt->bindParam(':id_user', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':action', $action, PDO::PARAM_STR);
        $stmt->bindParam(':ip_address', $ipAddress, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function logSessionTimes($log_id, $start_time, $end_time = null) {
        $stmt = $this->pdo->prepare("UPDATE logs 
                                     SET session_start = :start_time, session_end = :end_time 
                                     WHERE id_log = :log_id");
        $stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
        $stmt->bindParam(':end_time', $end_time, PDO::PARAM_STR);
        $stmt->bindParam(':log_id', $log_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
