<?php
include_once 'Conexion.php';

class Tipo {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    function crear($nombre) {
        $sql = "SELECT id_tip_prod FROM tipo_producto WHERE nombre=:nombre";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre' => $nombre));
        $this->objetos = $query->fetchAll();
        
        if (!empty($this->objetos)) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO tipo_producto(nombre) VALUES (:nombre)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nombre' => $nombre));
            echo 'add';
        }
    }

    function buscar() {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT * FROM tipo_producto WHERE nombre LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
        } else {
            $sql = "SELECT * FROM tipo_producto WHERE nombre NOT LIKE '' ORDER BY id_tip_prod LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
        }
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    function borrar($id) {
        $sql = "DELETE FROM tipo_producto WHERE id_tip_prod=:id";
        $query = $this->acceso->prepare($sql);
        $resultado = $query->execute(array(':id' => $id));
        
        if (!empty($query->rowCount())) {
            echo 'borrado';
            return $resultado;
        } else {
            echo 'noborrado';
        }
    }

    function editar($nombre, $id_editado) {
        $sql = "UPDATE tipo_producto SET nombre=:nombre WHERE id_tip_prod=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre' => $nombre, ':id' => $id_editado));
        echo 'edit';
    }
}
?>