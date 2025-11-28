<?php
include_once 'Conexion.php';

class Venta {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }
    function crear($cliente, $dni, $total, $vendedor, $productos) {
        // 1. Insertar la Cabecera de la Venta
        // CAMBIO: En lugar de usar :dni (que era del cliente), usamos una subconsulta 
        // para obtener el 'dni_us' de la tabla 'usuario' basándonos en el id del vendedor.
        $sql = "INSERT INTO venta(fecha, cliente, dni, total, vendedor) 
                VALUES (NOW(), :cliente, (SELECT dni_us FROM usuario WHERE id_usuario = :id_vendedor_sub), :total, :vendedor)";
        
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':cliente' => $cliente,
            ':id_vendedor_sub' => $vendedor, // Usamos el ID para buscar el DNI
            ':total' => $total,
            ':vendedor' => $vendedor         // Usamos el ID para registrar quién vendió
        ));
        
        // 2. Obtener el ID de la venta recién creada
        $id_venta_last = $this->acceso->lastInsertId();

        // 3. Procesar cada producto: Insertar detalle y DESCONTAR STOCK (Lógica FIFO)
        foreach ($productos as $producto) {
            // A) Insertar en venta_producto (Historial)
            $sql_det = "INSERT INTO venta_producto(cantidad, subtotal, producto_id_producto, venta_id_venta) 
                        VALUES (:cantidad, :subtotal, :id_producto, :id_venta)";
            $query_det = $this->acceso->prepare($sql_det);
            $query_det->execute(array(
                ':cantidad' => $producto->cantidad,
                ':subtotal' => $producto->subtotal,
                ':id_producto' => $producto->id,
                ':id_venta' => $id_venta_last
            ));

            // B) DESCONTAR STOCK
            // Traemos los lotes con stock > 0, ordenados por fecha de vencimiento
            $sql_lote = "SELECT id_lote, stock FROM lote WHERE lote_id_prod=:id AND stock > 0 ORDER BY vencimiento ASC";
            $query_lote = $this->acceso->prepare($sql_lote);
            $query_lote->execute(array(':id' => $producto->id));
            $lotes = $query_lote->fetchAll();

            $cantidad_por_descontar = $producto->cantidad;

            foreach ($lotes as $lote) {
                if ($cantidad_por_descontar > 0) {
                    if ($lote->stock >= $cantidad_por_descontar) {
                        $nuevo_stock = $lote->stock - $cantidad_por_descontar;
                        $sql_update = "UPDATE lote SET stock=:stock WHERE id_lote=:id";
                        $update = $this->acceso->prepare($sql_update);
                        $update->execute(array(':stock' => $nuevo_stock, ':id' => $lote->id_lote));
                        $cantidad_por_descontar = 0;
                    } else {
                        $cantidad_por_descontar = $cantidad_por_descontar - $lote->stock;
                        $sql_update = "UPDATE lote SET stock=0 WHERE id_lote=:id";
                        $update = $this->acceso->prepare($sql_update);
                        $update->execute(array(':id' => $lote->id_lote));
                    }
                } else {
                    break;
                }
            }
        }
        echo 'add';
    }
    // ... (Tu función crear está aquí arriba) ...

    function buscar() {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT id_venta, fecha, cliente, dni, total, CONCAT(usuario.nombre_us, ' ', usuario.apellidos_us) as vendedor
                    FROM venta
                    JOIN usuario ON vendedor = id_usuario
                    WHERE cliente LIKE :consulta OR usuario.nombre_us LIKE :consulta
                    ORDER BY fecha DESC"; // Ordenar por fecha más reciente
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
        } else {
            $sql = "SELECT id_venta, fecha, cliente, dni, total, CONCAT(usuario.nombre_us, ' ', usuario.apellidos_us) as vendedor
                    FROM venta
                    JOIN usuario ON vendedor = id_usuario
                    ORDER BY fecha DESC LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
        }
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    function buscar_id($id_venta) {
        $sql = "SELECT v.id_venta, v.fecha, v.cliente, v.dni, v.total, 
                CONCAT(u.nombre_us, ' ', u.apellidos_us) as vendedor
                FROM venta v
                JOIN usuario u ON v.vendedor = u.id_usuario
                WHERE v.id_venta = :id_venta";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_venta' => $id_venta));
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    function buscar_venta_detalle($id_venta) {
        $sql = "SELECT vp.cantidad, vp.subtotal, p.nombre, p.concentracion, p.adicional, p.precio,
                l.nombre as laboratorio
                FROM venta_producto vp
                JOIN producto p ON vp.producto_id_producto = p.id_producto
                JOIN laboratorio l ON p.prod_lab = l.id_laboratorio
                WHERE vp.venta_id_venta = :id_venta";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_venta' => $id_venta));
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    // BUSCAR VENTAS POR FECHA
    function buscar_ventas_anual($inicio, $fin) {
        $sql = "SELECT id_venta, fecha, cliente, dni, total, CONCAT(u.nombre_us, ' ', u.apellidos_us) as vendedor 
                FROM venta
                JOIN usuario u ON vendedor = id_usuario
                WHERE DATE(fecha) BETWEEN :inicio AND :fin";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ':inicio' => $inicio,
            ':fin' => $fin
        ));
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }
}
?>