<?php
require_once 'config/database.php';

class UserModel
{
    private $pdo;

    public function __construct()
    {
        $db = new Database(); ## Crea la instancia de la base de datos
        $this->pdo = $db->getConnection();
    }

    ## Obtener los datos por usuario
    public function getUserById($id_user)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT u.id_user, u.fullname_user, u.lastname_user, u.phone_user, u.address_user, u.email_user, u.super_root, u.admin_parent, u.id_rol, u.id_state, s.state 
                FROM users u  
                JOIN states s ON u.id_state = s.id_state
                JOIN roles r on u.id_rol = r.id_rol
                WHERE u.id_user = :id_user");
            $stmt->bindParam(':id_user', $id_user);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener el usuario por id: ' . $e->getMessage());
            return false;
        }
    }

    ## Obtiene todos los usuarios
    public function getAllUsers()
    {
        try {
            $stmt = $this->pdo->prepare(" SELECT u.id_user, u.fullname_user, u.lastname_user, u.phone_user, u.address_user, u.email_user, u.super_root, u.admin_parent, s.state 
                FROM users u 
                JOIN states s ON u.id_state = s.id_state ORDER BY u.fullname_user ASC ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  ## Devuelve los resultados
        } catch (PDOException $e) {
            error_log('Error al obtener los usuarios: ' . $e->getMessage());
            return false;
        }
    }

    ## Obtiene todos los roles disponibles
    public function getAllRoles()
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM roles'); ## Asegúrate de que "roles" existe y tiene datos
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener los roles: ' . $e->getMessage());
            return false;
        }
    }

    public function getStates()
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM states');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener los estados: ' . $e->getMessage());
            return false;
        }
    }
    ## Verifica si el correo ya se encuentra registrado en la base de datos
    public function checkEmail($email)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT id_user FROM users WHERE email_user = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al verificar el correo: ' . $e->getMessage());
            return false;
        }
    }

    ## Inserta un nuevo usuario en la base de datos
    public function insertUser($full_name, $last_name, $phone, $address, $email, $password_hash, $rol, $super_root, $admin_parent)
    {
        try {
            $stmt = $this->pdo->prepare(" INSERT INTO users 
            ( fullname_user, lastname_user, address_user, phone_user, email_user, password_user, super_root, admin_parent, id_rol
            ) VALUES (
                    :fullname, :lastname, :address, :phone, :email, :password, :super_root, :admin_parent, :id_rol
                )
            ");
            $stmt->execute([
                ':fullname' => $full_name,
                ':lastname' => $last_name,
                ':address' => $address,
                ':email' => $email,
                ':phone' => $phone,
                ':password' => $password_hash,
                ':super_root' => $super_root,
                ':admin_parent' => $admin_parent,
                ':id_rol' => $rol,
            ]);
            return true;  ## Devuelve verdadero si se insertó correctamente
        } catch (PDOException $e) {
            error_log('Error al insertar el usuario: ' . $e->getMessage());
            return false;
        }
    }

    ## Actualiza los datos de un usuario en la base de datos
    public function updateUser($id_user, $full_name, $last_name, $phone, $address, $email, $password_hash, $super_root, $admin_parent, $rol, $state)
    {
        try {
            $sql = "UPDATE users SET 
                        fullname_user = :full_name, 
                        lastname_user = :last_name, 
                        phone_user = :phone, 
                        address_user = :address, 
                        email_user = :email, 
                        id_rol = :rol, 
                        id_state = :state,
                        super_root = :super_root, 
                        admin_parent = :admin_parent";

            // Actualiza la contraseña solo si está definida
            if ($password_hash) {
                $sql .= ", password_user = :password ";
            }
            $sql .= " WHERE id_user = :id_user";

            $stmt = $this->pdo->prepare($sql);

            // Asigna parámetros
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':super_root', $super_root);
            $stmt->bindParam(':admin_parent', $admin_parent);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

            if ($password_hash) {
                $stmt->bindParam(':password', $password_hash);
            }

            // Ejecuta la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                $error = $stmt->errorInfo();
                throw new Exception("Error en la consulta: " . $error[2]);
            }
        } catch (PDOException $e) {
            throw new Exception("Error de base de datos: " . $e->getMessage());
        }
    }

    public function deactivateUser($id_user)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET id_state = 0 WHERE id_user = :id_user");
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al desactivar el usuario: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser($id_user)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id_user = :id_user");
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar el usuario: " . $e->getMessage());
            return false;
        }
    }
}
