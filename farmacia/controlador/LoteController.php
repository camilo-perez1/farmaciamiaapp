<?php
include '../modelo/Lote.php';
$lote = new Lote();

// CREAR LOTE
if ($_POST['funcion'] == 'crear') {
    $id_producto = $_POST['id_producto'];
    $proveedor = $_POST['proveedor'];
    $stock = $_POST['stock'];
    $vencimiento = $_POST['vencimiento'];
    
    $lote->crear($id_producto, $proveedor, $stock, $vencimiento);
}

// BUSCAR LOTES EN RIESGO (Para el Dashboard)
if ($_POST['funcion'] == 'buscar_riesgo') {
    $lote->buscar_lotes_riesgo();
    $json = array();
    date_default_timezone_set('America/Managua'); // Ajustado a tu zona horaria
    
    foreach ($lote->objetos as $objeto) {
        // --- LÓGICA DE SEMÁFORO ---
        $estado = 'light'; 
        $mes = "";
        $dia = "";
        
        if ($objeto->vencimiento == '0000-00-00') {
             $mes = "Sin fecha";
             $dia = "Sin fecha";
             $estado = 'secondary';
        } 
        else {
            if ($objeto->dias < 0) {
                $estado = 'danger'; // Rojo (Vencido)
                $mes = "Vencido";
                $dia = abs($objeto->dias) . " días pasados";
            } elseif ($objeto->meses <= 1) {
                $estado = 'danger'; // Rojo (Menos de 1 mes)
                $mes = $objeto->meses . " mes";
                $dia = $objeto->dias . " días";
            } elseif ($objeto->meses <= 2) {
                $estado = 'warning'; // Amarillo (1-2 meses)
                $mes = $objeto->meses . " meses";
                $dia = $objeto->dias . " días";
            } else {
                $estado = 'success'; // Verde (Más de 2 meses)
                $mes = $objeto->meses . " meses";
                $dia = $objeto->dias . " días";
            }
        }

        $json[] = array(
            'id' => $objeto->id_lote,
            'nombre' => $objeto->producto,
            'concentracion' => $objeto->concentracion,
            'adicional' => $objeto->adicional,
            'stock' => $objeto->stock,
            'laboratorio' => $objeto->laboratorio,
            'tipo' => $objeto->tipo,
            'presentacion' => $objeto->presentacion,
            'proveedor' => $objeto->proveedor,
            // CORRECCIÓN: Usamos una imagen por defecto ya que el producto no tiene foto
            'avatar' => '../img/prod/prod_default.png', 
            'vencimiento' => $objeto->vencimiento,
            'mes' => $mes,
            'dia' => $dia,
            'estado' => $estado 
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// BUSCAR LOTES POR PRODUCTO
if ($_POST['funcion'] == 'buscar') {
    $id_producto = $_POST['id_producto'];
    $lote->buscar($id_producto);
    $json = array();
    foreach ($lote->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id_lote,
            'stock' => $objeto->stock,
            'vencimiento' => $objeto->vencimiento,
            'proveedor' => $objeto->proveedor
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// BORRAR LOTE
if ($_POST['funcion'] == 'borrar') {
    $id = $_POST['id'];
    $lote->borrar($id);
}
?>