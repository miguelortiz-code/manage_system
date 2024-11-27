<?php

class Database{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'manage_system_db';
    private $pdo;

    public function __construct(){
        $this->connect();
    }

    private function connect(){
        try{            // Crear la conexion a la base de datos
            $this->pdo = new PDO("mysql:host={$this->host}; dbname={$this->database}; charset=utf8",
            $this->user, $this->password);

            // Configurar el modo de errores para lanzar exepciones
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            error_log('Error de conexion: ' . $e->getMessage());
        }
    }

    public function getConnection(){
        return $this->pdo;
    }
}