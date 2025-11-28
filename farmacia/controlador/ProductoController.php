<?php
include '../modelo/Producto.php';
$producto = new Producto();

// CREAR
if ($_POST['funcion'] == 'crear') {
    $nombre = $_POST['nombre'];
    $concentracion = $_POST['concentracion'];
    $adicional = $_POST['adicional'];
    $precio = $_POST['precio'];
    $laboratorio = $_POST['laboratorio'];
    $tipo = $_POST['tipo'];
    $presentacion = $_POST['presentacion'];
    
    $producto->crear($nombre, $concentracion, $adicional, $precio, $laboratorio, $tipo, $presentacion);
}

// EDITAR
if ($_POST['funcion'] == 'editar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $concentracion = $_POST['concentracion'];
    $adicional = $_POST['adicional'];
    $precio = $_POST['precio'];
    $laboratorio = $_POST['laboratorio'];
    $tipo = $_POST['tipo'];
    $presentacion = $_POST['presentacion'];
    
    $producto->editar($id, $nombre, $concentracion, $adicional, $precio, $laboratorio, $tipo, $presentacion);
}

// BUSCAR
// BUSCAR
if ($_POST['funcion'] == 'buscar') {
    $producto->buscar();
    $json = array();
    foreach ($producto->objetos as $objeto) {
        // Validamos si total es null (cuando no hay lotes) para poner 0
        $total = $objeto->total;
        if ($total == null) {
            $total = 0;
        }

        $json[] = array(
            'id' => $objeto->id_producto,
            'nombre' => $objeto->nombre,
            'concentracion' => $objeto->concentracion,
            'adicional' => $objeto->adicional,
            'precio' => $objeto->precio,
            'stock' => $total, // AQUI EL CAMBIO: Usamos la variable $total
            'laboratorio' => $objeto->laboratorio,
            'tipo' => $objeto->tipo,
            'presentacion' => $objeto->presentacion,
            'laboratorio_id' => $objeto->prod_lab,
            'tipo_id' => $objeto->prod_tip,
            'presentacion_id' => $objeto->prod_pre,
            'avatar' => '../img/prod/prod_default.png' // Agregamos avatar por defecto por si acaso
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// BORRAR
if ($_POST['funcion'] == 'borrar') {
    $id = $_POST['id'];
    $producto->borrar($id);
}
// BUSCAR PRODUCTOS CON BAJO STOCK (ALERTA PERSONALIZADA)
if ($_POST['funcion'] == 'buscar_stock_bajo') {
    $producto->buscar(); // Usamos el método buscar() que ya trae el stock total sumado
    $json = array();
    
    foreach ($producto->objetos as $objeto) {
        $total = $objeto->total; // Stock total calculado en el modelo
        if ($total == null) { $total = 0; } // Si no hay lotes, es 0

        $presentacion = $objeto->presentacion; // Nombre de la presentacion (ej: Tableta, Jarabe)
        $stock_minimo = 0;
        $alerta = false;

        // --- REGLAS DE NEGOCIO POR PRESENTACIÓN ---
        // Convertimos a minúsculas para evitar errores de mayúsculas/minúsculas
        $pres_lower = strtolower($presentacion); 

        // 1. Grupo ALTO VOLUMEN (Tabletas, Capsulas, Pildoras) - Alerta si < 50
        if (strpos($pres_lower, 'tableta') !== false || 
            strpos($pres_lower, 'capsula') !== false || 
            strpos($pres_lower, 'pildora') !== false) {
            $stock_minimo = 50;
        } 
        // 2. Grupo MEDIO VOLUMEN (Gotas, Suspension en polvo, Paquete) - Alerta si < 10
        elseif (strpos($pres_lower, 'gota') !== false || 
                strpos($pres_lower, 'suspension') !== false || 
                strpos($pres_lower, 'paquete') !== false ||
                strpos($pres_lower, 'crema') !== false ||
                strpos($pres_lower, 'envase') !== false) {
            $stock_minimo = 10;
        }
        // 3. Grupo BAJO VOLUMEN (Inyeccion, Jarabe) - Alerta si < 5
        elseif (strpos($pres_lower, 'inyeccion') !== false || 
                strpos($pres_lower, 'jarabe') !== false) {
            $stock_minimo = 5;
        }
        // 4. Default (por si creas una presentación nueva y olvidas ponerla aquí)
        else {
            $stock_minimo = 5; 
        }

        // --- VERIFICACIÓN ---
        if ($total <= $stock_minimo) {
            $json[] = array(
                'id' => $objeto->id_producto,
                'nombre' => $objeto->nombre,
                'concentracion' => $objeto->concentracion,
                'adicional' => $objeto->adicional,
                'precio' => $objeto->precio,
                'stock' => $total,
                'stock_minimo' => $stock_minimo, // Para mostrarlo en la tabla si quieres
                'laboratorio' => $objeto->laboratorio,
                'tipo' => $objeto->tipo,
                'presentacion' => $objeto->presentacion,
                'avatar' => '../img/prod/prod_default.png'
            );
        }
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
?>