<?php
class Conexion {
    public $pdo;

    public function __construct() {
        // Intentamos leer variables de entorno (Nube), si no existen, usa valores locales
        $host = getenv('DB_HOST') ?: 'localhost';
        $dbName = getenv('DB_NAME') ?: 'farmaciasistema';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';
        $port = getenv('DB_PORT') ?: '3306';

        try {
            // Cadena de conexión dinámica
            $this->pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbName};charset=utf8", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}
?>