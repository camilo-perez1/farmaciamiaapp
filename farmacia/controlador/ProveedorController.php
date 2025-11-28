<?php
include '../modelo/Proveedor.php';
$proveedor = new Proveedor();

if ($_POST['funcion'] == 'crear') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    
    $proveedor->crear($nombre, $telefono, $correo, $direccion);
}

if ($_POST['funcion'] == 'editar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    
    $proveedor->editar($id, $nombre, $telefono, $correo, $direccion);
}

if ($_POST['funcion'] == 'buscar') {
    $proveedor->buscar();
    $json = array();
    foreach ($proveedor->objetos as $objeto) {
        $json[] = array(
            'id' => $objeto->id_proveedor,
            'nombre' => $objeto->nombre,
            'telefono' => $objeto->telefono,
            'correo' => $objeto->correo,
            'direccion' => $objeto->direccion,
            'avatar' => '../img/prov_default.png' // Puedes poner una imagen por defecto o agregar avatar después
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'borrar') {
    $id = $_POST['id'];
    $proveedor->borrar($id);
}
?>