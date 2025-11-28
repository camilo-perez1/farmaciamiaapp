<?php
include '../modelo/Venta.php';
$venta = new Venta();

if ($_POST['funcion'] == 'registrar_venta') {
    $cliente = $_POST['cliente'];
    $dni = $_POST['dni'];
    $total = $_POST['total'];
    $vendedor = $_POST['vendedor'];
    
    $productos = json_decode($_POST['json']);
    
    $venta->crear($cliente, $dni, $total, $vendedor, $productos);
}



if ($_POST['funcion'] == 'buscar') {
    $venta->buscar();
    $json = array();
    foreach ($venta->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id_venta,
            'fecha' => $objeto->fecha,
            'cliente' => $objeto->cliente,
            'dni' => $objeto->dni,
            'total' => $objeto->total,
            'vendedor' => $objeto->vendedor
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// REPORTE DE VENTAS POR FECHAS
if ($_POST['funcion'] == 'reporte_ventas') {
    $inicio = $_POST['inicio'];
    $fin = $_POST['fin'];
    
    $venta->buscar_ventas_anual($inicio, $fin);
    
    $json = array();
    foreach ($venta->objetos as $objeto) {
        $json[] = array(
            'id_venta' => $objeto->id_venta,
            'fecha' => $objeto->fecha,
            'cliente' => $objeto->cliente,
            'dni' => $objeto->dni,
            'total' => $objeto->total,
            'vendedor' => $objeto->vendedor
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
?>