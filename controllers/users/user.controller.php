<?php

require_once 'models/users/user.model.php';
require_once 'controllers/alerts/alerts.controller.php';
require_once 'middleware/global.middleware.php';

class UserController
{
    private $model;
    private $alert;
    private $middleware;

    ## Constructor para la conexion a la base de datos e instancias
    public function __construct()
    {
        $this->model = new UserModel(); ## Instancia al modelo de usuarios
        $this->alert = new AlertsController(); ## Instancia de las alertas
        $this->middleware = new GlobalSession(); ## Instancia del middleware
        $this->middleware->session();  ## Verifica la sesión
    }

    ## Obtiene todos los usuarios
    public function getAllUsers()
    {
        try {
            ## Obtiene los usuarios del modelo
            $users = $this->model->getAllUsers();

            ## Almacena los usuarios en una variable global para que la vista los utilice
            global $usersData;
            $usersData = $users;
        } catch (PDOException $e) {
            ## En caso de error, muestra un mensaje de alerta
            $this->alert->setAlert('danger', 'Error al obtener usuarios: ' . $e->getMessage());
            header('Location: /dashboard');  ## Redirige si hay error
            exit;
        }
    }
    ## Guarda el id del usuario en una session
    public function setUserSession()
    {
        if (isset($_GET['id'])) {
            $_SESSION['id_user'] = intval($_GET['id']);
            header('Location: /users/update-user');
            exit;
        } else {
            $this->alert->setAlert('danger', 'Usuario no encontrado');
            header('Location: /users');
            exit;
        }
    }
    ## Obtiene el usuario por id
    public function getUserById()
    {
        if (isset($_SESSION['id_user'])) {
            $id_user = $_SESSION['id_user'];
            $user = $this->model->getUserById($id_user);
            global $userData;
            $userData = $user;
            ## Obtén los roles
            $this->getRoles();
            ## Se Obtienen los estados
            $this->getStates();
        } else {
            $this->alert->setAlert('danger', 'Usuario no encontrado.');
            header("Location: /users");
            exit;
        }
    }
    ## Obtiene los roles
    public function getRoles()
    {
        $roles = $this->model->getAllRoles();
        global $rolesData;
        $rolesData = $roles ?: [];
    }
    ## Obtiene los estados
    public function getStates()
    {
        $states = $this->model->getStates();
        global $statesData;
        $statesData = $states ?: [];
    }

    ## Crea un nuevo usuario
    public function createUser()
    {


        ## Se Obtienen los roles
        $this->getRoles();

        if (isset($_POST['submit'])) {
            ## DEBUGGING  echo "enviando datos";
            if (
                isset($_POST['full_name']) && isset($_POST['last_name']) && isset($_POST['phone']) && isset($_POST['address'])
                && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['super__root'])
                && isset($_POST['admin_parent']) && isset($_POST['rol'])
            ) {
                $full_name = htmlspecialchars(trim($_POST['full_name']), ENT_QUOTES, 'UTF-8');
                $last_name = htmlspecialchars(trim($_POST['last_name']), ENT_QUOTES, 'UTF-8');
                $phone = htmlspecialchars(trim($_POST['phone']), ENT_QUOTES, 'UTF-8');
                $address = htmlspecialchars(trim($_POST['address']), ENT_QUOTES, 'UTF-8');
                $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
                $rol = htmlspecialchars(trim($_POST['rol']), ENT_QUOTES, 'UTF-8');
                $super_root = htmlspecialchars(trim($_POST['super__root']), ENT_QUOTES, 'UTF-8');
                $admin_parent = htmlspecialchars(trim($_POST['admin_parent']), ENT_QUOTES, 'UTF-8');
                $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8');
                $confirm_password = htmlspecialchars(trim($_POST['confirm_password']), ENT_QUOTES, 'UTF-8');


                ## Validación de campos vacios
                if (empty($full_name) || empty($last_name) || empty($email)) {
                    $this->alert->setAlert('danger', 'Todos los campos son obligatorios.');
                    header('Location: /users/create-user');
                    exit;
                }
                ## Validacion de formato del correo electrónico
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->alert->setAlert('danger', 'El formato del correo electrónico no es válido: ' . $email);
                    header('Location: /users/create-user');
                    exit;
                }
                ## Validación que las contraseñas coincidan
                if ($password != $confirm_password) {
                    $this->alert->setAlert('danger', 'Las contraseñas no coinciden.');
                    header('Location: /users/create-user');
                    exit;
                }

                ## Verificar si el correo ya existe en la base de datos
                $emailExist = $this->model->checkEmail($email);
                if ($emailExist) {
                    $this->alert->setAlert('danger', 'El correo electrónico ya se encuentra registrado con el usuario ' . $full_name);
                    header('Location: /users/create-user');
                    exit;
                }

                ## Encriptar la contraseña
                $password_hash = password_hash($password, PASSWORD_BCRYPT);

                $result = $this->model->insertUser($full_name, $last_name, $phone, $address, $email, $password_hash, $rol, $super_root, $admin_parent);
                try {
                    if ($result) {
                        $this->alert->setAlert('success', 'Usuario creado correctamente');
                        header('Location: /users');
                        exit;
                    }
                } catch (PDOException $e) {
                    $this->alert->setAlert('danger', 'Error al crear el usuario: ' . $e->getMessage());
                    header('Location: /users/create-user');
                    exit;
                }
            }
        }
    }
    ## Editar al usuario
    public function editUser()
    {
        if (isset($_POST['submit'])) {
            if (
                isset($_POST['id_user']) && isset($_POST['full_name']) && isset($_POST['last_name']) &&
                isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['email']) &&
                isset($_POST['super__root']) && isset($_POST['admin_parent']) && isset($_POST['rol']) && isset($_POST['state'])
            ) {
                // Sanitizar entradas
                $id_user = intval($_POST['id_user']);
                $full_name = htmlspecialchars(trim($_POST['full_name']), ENT_QUOTES, 'UTF-8');
                $last_name = htmlspecialchars(trim($_POST['last_name']), ENT_QUOTES, 'UTF-8');
                $phone = htmlspecialchars(trim($_POST['phone']), ENT_QUOTES, 'UTF-8');
                $address = htmlspecialchars(trim($_POST['address']), ENT_QUOTES, 'UTF-8');
                $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
                $rol = htmlspecialchars(trim($_POST['rol']), ENT_QUOTES, 'UTF-8');
                $state = htmlspecialchars(trim($_POST['state']), ENT_QUOTES, 'UTF-8');
                $super_root = htmlspecialchars(trim($_POST['super__root']), ENT_QUOTES, 'UTF-8');
                $admin_parent = htmlspecialchars(trim($_POST['admin_parent']), ENT_QUOTES, 'UTF-8');
                // Validación del formato de email
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->alert->setAlert('danger', 'El formato del correo electrónico no es válido.');
                    header('Location: /users/update-user');
                    exit;
                }

                // Verifica si hay contraseñas y si coinciden
                $password_hash = null;
                if (!empty($_POST['password']) && !empty($_POST['confirm_password'])) {
                    $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8');
                    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']), ENT_QUOTES, 'UTF-8');

                    if ($password !== $confirm_password) {
                        $this->alert->setAlert('danger', 'Las contraseñas no coinciden.');
                        header('Location: /users/update-user');
                        exit;
                    }

                    // Si no están vacías, encripta la contraseña
                    $password_hash = password_hash($password, PASSWORD_BCRYPT);
                }

                try {
                    // Actualiza el usuario
                    $result = $this->model->updateUser(
                        $id_user,
                        $full_name,
                        $last_name,
                        $phone,
                        $address,
                        $email,
                        $password_hash,
                        $super_root,
                        $admin_parent,
                        $rol,
                        $state
                    );

                    if ($result) {
                        $this->alert->setAlert('success', 'Usuario actualizado correctamente.');
                        header('Location: /users');
                        exit;
                    } else {
                        throw new Exception("No se pudo actualizar el usuario.");
                    }
                } catch (Exception $e) {
                    $this->alert->setAlert('danger', 'Error al actualizar el usuario: ' . $e->getMessage());
                    header('Location: /users/update-user');
                    exit;
                }
            } else {
                $this->alert->setAlert('danger', 'Faltan datos para actualizar el usuario.');
                header('Location: /users/update-user');
                exit;
            }
        }
    }

    public function deactivateUser()
    {
 
        if (isset($_GET['id'])) {
            $id_user = intval($_GET['id']);
            try {
                $result = $this->model->deactivateUser($id_user);
                if ($result) {
                    header('Location: /users');
                    $this->alert->setAlert('success', 'Usuario desactivado correctamente.');
                    exit;
                } else {
                    throw new Exception('No se pudo desactivar el usuario.');
                }
            } catch (Exception $e) {
                $this->alert->setAlert('danger', 'Error al desactivar el usuario: ' . $e->getMessage());
                header('Location: /users');
                exit;
            }
        } else {
            $this->alert->setAlert('danger', 'ID de usuario no especificado.');
            header('Location: /users');
            exit;
        }
    }

    public function deleteUser()
    {
        if (isset($_GET['id'])) {
            $id_user = intval($_GET['id']);
            try {
                $result = $this->model->deleteUser($id_user);
                if ($result) {
                    $this->alert->setAlert('success', 'Usuario eliminado correctamente.');
                    header('Location: /users');
                    exit;
                } else {
                    throw new Exception('No se pudo eliminar el usuario.');
                }
            } catch (Exception $e) {
                $this->alert->setAlert('danger', 'Error al eliminar el usuario: ' . $e->getMessage());
                header('Location: /users');
                exit;
            }
        } else {
            $this->alert->setAlert('danger', 'ID de usuario no especificado.');
            header('Location: /users');
            exit;
        }
    }
 }
