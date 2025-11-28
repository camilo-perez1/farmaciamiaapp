<?php 

include '../modelo/Laboratorio.php';

$laboratorio=new Laboratorio();
if($_POST['funcion']=='crear'){
    $nombre=$_POST['nombre_laboratorio'];
    $avatar='lab_default.png';
    $laboratorio->crear($nombre,$avatar);
    
}

$laboratorio=new Laboratorio();
if($_POST['funcion']=='editar'){
    $nombre=$_POST['nombre_laboratorio'];
    $id_editado=$_POST['id_editado'];
    $laboratorio->editar($nombre,$id_editado);
    
}
if($_POST['funcion']=='buscar'){
   $laboratorio->buscar();
    $json=array();
    foreach ($laboratorio->objetos as $objeto) {
        $json[]=array(
            'id'=>$objeto->id_laboratorio,
            'nombre'=>$objeto->nombre,
            'avatar'=>'../img/lab/'.$objeto->avatar
        );
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
    
}
if($_POST['funcion']=='cambiar_logo'){
    $id=$_POST['id_logo_lab'];
    if (($_FILES['photo']['type'] == 'image/jpeg' || $_FILES['photo']['type'] == 'image/png' || $_FILES['photo']['type'] == 'image/gif')) {
        // CORREGIDO: $_FILES en lugar de $_file
        $nombre = uniqid().'-'.$_FILES['photo']['name'];
        $ruta = '../img/lab/'.$nombre;
        
        // CORREGIDO: $_FILES en lugar de $_file
        move_uploaded_file($_FILES['photo']['tmp_name'], $ruta);
        
        // Obtener avatar actual antes de actualizar
        $laboratorio->cambiar_logo($id, $nombre);
        
        foreach ($laboratorio->objetos as $objeto) {
            // Solo eliminar si no es el avatar por defecto

            if ($objeto->avatar != 'lab_default.png' && file_exists('../img/'.$objeto->avatar)) {
                
                unlink('../img/lab/'.$objeto->avatar);
            }
        }
        
        $json = array();
        $json[] = array(
            'ruta' => $ruta,
            'alert' => 'edit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    } else {
        $json = array();
        $json[] = array(
            'alert' => 'noedit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
        
    }
    
}

// Bloque para manejar el borrado
    if($_POST['funcion'] == 'borrar'){
        $id = $_POST['id'];
        $laboratorio->borrar($id);
    }
?>