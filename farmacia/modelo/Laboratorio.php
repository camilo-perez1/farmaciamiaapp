<?php
include_once 'Conexion.php';

class Laboratorio
{
    var $objetos; // Corregido a plural para consistencia
    private $acceso;

    public function __construct()
    {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    function crear($nombre, $avatar)
    {
        $sql = "SELECT id_laboratorio FROM laboratorio where nombre=:nombre";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre' => $nombre));
        $this->objetos = $query->fetchAll();
        
        if (!empty($this->objetos)) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO laboratorio(nombre,avatar) values (:nombre,:avatar)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':nombre' => $nombre,
                ':avatar' => $avatar
            ));
            echo 'add';
        }
    }

    function buscar()
    {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT * FROM laboratorio where nombre LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        } else {
            $sql = "SELECT * FROM laboratorio where nombre NOT LIKE '' ORDER BY id_laboratorio LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        }
    }

    function cambiar_logo($id, $nombre)
    {
        $sql = "SELECT avatar FROM laboratorio WHERE id_laboratorio=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id));
        $this->objetos = $query->fetchAll();

        $sql = "UPDATE laboratorio SET avatar=:nombre WHERE id_laboratorio=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id, ':nombre' => $nombre));
        
        return $this->objetos;
    }
    function editar($nombre, $id_editado)
    {
        $sql = "UPDATE laboratorio SET nombre=:nombre WHERE id_laboratorio=:id";
        $query = $this->acceso->prepare($sql);
        $resultado = $query->execute(array(':nombre' => $nombre, ':id' => $id_editado));
        echo 'edit';
        return $resultado;
    }

    //nuevas funciones
    // Función para eliminar laboratorio............................................................................................
    function borrar($id)
    {
        $sql = "DELETE FROM laboratorio WHERE id_laboratorio=:id";
        $query = $this->acceso->prepare($sql);
        $resultado = $query->execute(array(':id' => $id));
        
        // Verificamos si se borró al menos una fila
        if ($query->rowCount() > 0) {
            echo 'borrado';
            return $resultado;
        } else {
            echo 'noborrado';
        }
    }
}
?>