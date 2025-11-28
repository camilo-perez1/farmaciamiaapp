<?php
include_once 'Conexion.php';

class Lote {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    // 1. Crear un nuevo lote (Registrar Compra)
    function crear($id_producto, $proveedor, $stock, $vencimiento) {
        $sql = "INSERT INTO lote(stock, vencimiento, lote_id_prod, lote_id_prov) 
                VALUES (:stock, :vencimiento, :id_producto, :id_proveedor)";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':stock' => $stock,
            ':vencimiento' => $vencimiento,
            ':id_producto' => $id_producto,
            ':id_proveedor' => $proveedor
        ));
        echo 'add';
    }

    // 2. Buscar lotes para el Dashboard (Cálculo de riesgo de vencimiento)
    // 2. Buscar lotes para el Dashboard
    function buscar_lotes_riesgo() {
        // Hacemos JOIN con todas las tablas
        // CORRECCIÓN: Se eliminó 'p.avatar' porque esa columna no existe en la tabla producto
        $sql = "SELECT l.id_lote, p.nombre as producto, p.concentracion, p.adicional, l.stock, 
                lab.nombre as laboratorio, tip.nombre as tipo, pre.nombre as presentacion, 
                prov.nombre as proveedor, l.vencimiento,
                TIMESTAMPDIFF(MONTH, NOW(), l.vencimiento) as meses,
                DATEDIFF(l.vencimiento, NOW()) as dias
                FROM lote l
                JOIN producto p ON l.lote_id_prod = p.id_producto
                JOIN laboratorio lab ON p.prod_lab = lab.id_laboratorio
                JOIN tipo_producto tip ON p.prod_tip = tip.id_tip_prod
                JOIN presentacion pre ON p.prod_pre = pre.id_presentacion
                JOIN proveedor prov ON l.lote_id_prov = prov.id_proveedor
                ORDER BY l.vencimiento ASC";
        
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }
    
    // 3. Buscar lotes de un producto específico (para ver detalle)
    function buscar($id_producto) {
        $sql = "SELECT l.id_lote, l.stock, l.vencimiento, 
                prov.nombre as proveedor
                FROM lote l
                JOIN proveedor prov ON l.lote_id_prov = prov.id_proveedor
                WHERE l.lote_id_prod = :id_producto";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_producto' => $id_producto));
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }
    
    // 4. Borrar lote
    function borrar($id) {
        $sql = "DELETE FROM lote WHERE id_lote=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id));
        if (!empty($query->rowCount())) {
            echo 'borrado';
        } else {
            echo 'noborrado';
        }
    }
}
?>