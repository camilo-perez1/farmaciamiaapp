<?php
include_once 'Conexion.php';

class Presentacion {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    function crear($nombre) {
        $sql = "SELECT id_presentacion FROM presentacion WHERE nombre=:nombre";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre' => $nombre));
        $this->objetos = $query->fetchAll();
        
        if (!empty($this->objetos)) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO presentacion(nombre) VALUES (:nombre)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nombre' => $nombre));
            echo 'add';
        }
    }

    function buscar() {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT * FROM presentacion WHERE nombre LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
        } else {
            $sql = "SELECT * FROM presentacion WHERE nombre NOT LIKE '' ORDER BY id_presentacion LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
        }
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    function borrar($id) {
        $sql = "DELETE FROM presentacion WHERE id_presentacion=:id";
        $query = $this->acceso->prepare($sql);
        
        try {
            $query->execute(array(':id' => $id));
            if (!empty($query->rowCount())) {
                echo 'borrado';
            } else {
                echo 'noborrado';
            }
        } catch (PDOException $e) {
            // Atrapa el error si está en uso por un producto
            echo 'noborrado';
        }
    }

    function editar($nombre, $id_editado) {
        $sql = "UPDATE presentacion SET nombre=:nombre WHERE id_presentacion=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre' => $nombre, ':id' => $id_editado));
        echo 'edit';
    }
}
?>