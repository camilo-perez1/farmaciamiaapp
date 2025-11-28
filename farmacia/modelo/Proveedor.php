<?php
include_once 'Conexion.php';

class Proveedor {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    function crear($nombre, $telefono, $correo, $direccion) {
        // Verificar si ya existe un proveedor con ese nombre
        $sql = "SELECT id_proveedor FROM proveedor WHERE nombre=:nombre";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre' => $nombre));
        $this->objetos = $query->fetchAll();
        
        if (!empty($this->objetos)) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO proveedor(nombre, telefono, correo, direccion) VALUES (:nombre, :telefono, :correo, :direccion)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':nombre' => $nombre,
                ':telefono' => $telefono,
                ':correo' => $correo,
                ':direccion' => $direccion
            ));
            echo 'add';
        }
    }

    function buscar() {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT * FROM proveedor WHERE nombre LIKE :consulta ORDER BY nombre ASC";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
        } else {
            $sql = "SELECT * FROM proveedor WHERE nombre NOT LIKE '' ORDER BY nombre ASC LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
        }
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    function editar($id, $nombre, $telefono, $correo, $direccion) {
        $sql = "UPDATE proveedor SET nombre=:nombre, telefono=:telefono, correo=:correo, direccion=:direccion WHERE id_proveedor=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id' => $id,
            ':nombre' => $nombre,
            ':telefono' => $telefono,
            ':correo' => $correo,
            ':direccion' => $direccion
        ));
        echo 'edit';
    }

    function borrar($id) {
        $sql = "DELETE FROM proveedor WHERE id_proveedor=:id";
        $query = $this->acceso->prepare($sql);
        try {
            $query->execute(array(':id' => $id));
            if (!empty($query->rowCount())) {
                echo 'borrado';
            } else {
                echo 'noborrado';
            }
        } catch (PDOException $e) {
            // Error si el proveedor tiene lotes de productos asociados
            echo 'noborrado';
        }
    }
}
?>