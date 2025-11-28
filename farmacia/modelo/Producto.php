<?php
include_once 'Conexion.php';

class Producto {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    function crear($nombre, $concentracion, $adicional, $precio, $laboratorio, $tipo, $presentacion) {
        // Verificar si ya existe un producto idéntico
        $sql = "SELECT id_producto FROM producto WHERE nombre=:nombre AND concentracion=:concentracion AND adicional=:adicional AND prod_lab=:laboratorio";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':nombre' => $nombre,
            ':concentracion' => $concentracion,
            ':adicional' => $adicional,
            ':laboratorio' => $laboratorio
        ));
        $this->objetos = $query->fetchAll();
        
        if (!empty($this->objetos)) {
            echo 'noadd';
        } else {
            // Insertar sin avatar
            $sql = "INSERT INTO producto(nombre, concentracion, adicional, precio, prod_lab, prod_tip, prod_pre) 
                    VALUES (:nombre, :concentracion, :adicional, :precio, :laboratorio, :tipo, :presentacion)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(
                ':nombre' => $nombre,
                ':concentracion' => $concentracion,
                ':adicional' => $adicional,
                ':precio' => $precio,
                ':laboratorio' => $laboratorio,
                ':tipo' => $tipo,
                ':presentacion' => $presentacion
            ));
            echo 'add';
        }
    }

    function editar($id, $nombre, $concentracion, $adicional, $precio, $laboratorio, $tipo, $presentacion) {
        $sql = "UPDATE producto SET nombre=:nombre, concentracion=:concentracion, adicional=:adicional, precio=:precio, prod_lab=:laboratorio, prod_tip=:tipo, prod_pre=:presentacion WHERE id_producto=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':id' => $id,
            ':nombre' => $nombre,
            ':concentracion' => $concentracion,
            ':adicional' => $adicional,
            ':precio' => $precio,
            ':laboratorio' => $laboratorio,
            ':tipo' => $tipo,
            ':presentacion' => $presentacion
        ));
        echo 'edit';
    }

    function buscar() {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            // Se agrega SUM(lote.stock) as total y LEFT JOIN lote
            $sql = "SELECT id_producto, producto.nombre as nombre, concentracion, adicional, precio, 
                    laboratorio.nombre as laboratorio, tipo_producto.nombre as tipo, presentacion.nombre as presentacion,
                    prod_lab, prod_tip, prod_pre,
                    SUM(lote.stock) as total
                    FROM producto
                    JOIN laboratorio ON prod_lab = id_laboratorio
                    JOIN tipo_producto ON prod_tip = id_tip_prod
                    JOIN presentacion ON prod_pre = id_presentacion
                    LEFT JOIN lote ON producto.id_producto = lote.lote_id_prod
                    WHERE producto.nombre LIKE :consulta 
                    GROUP BY producto.id_producto
                    LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
        } else {
            // Misma lógica para cuando no hay búsqueda
            $sql = "SELECT id_producto, producto.nombre as nombre, concentracion, adicional, precio, 
                    laboratorio.nombre as laboratorio, tipo_producto.nombre as tipo, presentacion.nombre as presentacion,
                    prod_lab, prod_tip, prod_pre,
                    SUM(lote.stock) as total
                    FROM producto
                    JOIN laboratorio ON prod_lab = id_laboratorio
                    JOIN tipo_producto ON prod_tip = id_tip_prod
                    JOIN presentacion ON prod_pre = id_presentacion
                    LEFT JOIN lote ON producto.id_producto = lote.lote_id_prod
                    WHERE producto.nombre NOT LIKE '' 
                    GROUP BY producto.id_producto
                    ORDER BY producto.nombre LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
        }
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }
    function borrar($id) {
        $sql = "DELETE FROM producto WHERE id_producto=:id";
        $query = $this->acceso->prepare($sql);
        try {
            $query->execute(array(':id' => $id));
            if (!empty($query->rowCount())) {
                echo 'borrado';
            } else {
                echo 'noborrado';
            }
        } catch (PDOException $e) {
            echo 'noborrado';
        }
    }
}
?>