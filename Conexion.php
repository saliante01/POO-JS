<?php

class ConexionBD {
    
    private static $instancia;
    private $conexion;

    private function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "testDataBase");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new ConexionBD();
        }
        return self::$instancia;
    }

    public function obtenerConexion() {
        return $this->conexion;
    }

    private function __clone() {}
    private function __wakeup() {}
}

?>
