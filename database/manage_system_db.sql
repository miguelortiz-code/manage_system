CREATE DATABASE manage_system_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE manage_system_db;

-- Tabla de los roles
CREATE TABLE roles(
    id_rol INT NOT NULL AUTO_INCREMENT,
    rol VARCHAR(100),
    PRIMARY KEY (id_rol)
);

INSERT INTO roles (id_rol, rol) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- Tabla de los estados
CREATE TABLE states(
    id_state INT NOT NULL AUTO_INCREMENT,
    state VARCHAR(100),
    PRIMARY KEY (id_state)
);

INSERT INTO states (id_state, state) VALUES
(0, 'Inactivo'),
(1, 'Activo');

-- Tabla de los usuarios
CREATE TABLE users(
    id_user INT NOT NULL AUTO_INCREMENT,
    fullname_user VARCHAR(200),
    lastname_user VARCHAR(200),
    phone_user VARCHAR(100),
    email_user VARCHAR(200) UNIQUE,
    password_user VARCHAR(200),
    image_user VARCHAR(255) DEFAULT 'public/assets/images/user.png',
    date_created_user TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_update_user TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    login_attempts INT DEFAULT 0,
    last_attempt_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    account_locked_until DATETIME DEFAULT NULL,
    id_state INT DEFAULT 1,
    id_rol INT,
    super_root INT NOT NULL DEFAULT 0,
    admin_parent INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id_user),
    FOREIGN KEY (id_state) REFERENCES states (id_state),
    FOREIGN KEY (id_rol) REFERENCES roles (id_rol)
);

INSERT INTO users (fullname_user, lastname_user, email_user, phone_user, password_user, id_state, id_rol, super_root, admin_parent) 
VALUES
('Admin', 'Admin', 'admin@gmail.com', '5555555', '$2b$12$9QNDkMSIWf/Q4Bt6SQmeh.1imIr8PLuHtQiQw88Y2mL9.ELOR3wDu', 1, 1, 1, 0),
('Usuario', 'Usuario', 'usuario@gmail.com', '5555555', '$2b$12$9QNDkMSIWf/Q4Bt6SQmeh.1imIr8PLuHtQiQw88Y2mL9.ELOR3wDu', 1, 2, 0, 1);

-- Tabla logs para las acciones del usuario
CREATE TABLE logs(
    id_log INT NOT NULL AUTO_INCREMENT,
    id_user INT,
    action VARCHAR(255),
    ip_address VARCHAR(50),
    log_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    session_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    session_end TIMESTAMP DEFAULT CURRENT_TIMESTAMP,    
    PRIMARY KEY (id_log),
    FOREIGN KEY (id_user) REFERENCES users (id_user)
);

-- Tabla logs details para los detalles de la accion del usuario
CREATE TABLE logs_details(
    id INT NOT NULL AUTO_INCREMENT,
    id_log INT,
    page VARCHAR(255),
    query_params VARCHAR(100),
    PRIMARY KEY(id),
    FOREIGN KEY (id_log) REFERENCES logs (id_log)
);

-- Tabla modulos para el sidebar
CREATE TABLE modules(
    id_module INT NOT NULL AUTO_INCREMENT,
    name_module VARCHAR(100) NOT NULL,
    url_module VARCHAR(255),
    PRIMARY KEY (id_module)
);