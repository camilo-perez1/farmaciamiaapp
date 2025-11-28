<?php
session_start();
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 3 || $_SESSION['us_tipo'] == 2) {
    include_once '../modelo/Venta.php';
    $venta = new Venta();
    
    // Obtener ID de la venta desde la URL
    $id_venta = $_GET['id'];
    
    // Buscar datos
    $datos_venta = $venta->buscar_id($id_venta);
    $detalle_venta = $venta->buscar_venta_detalle($id_venta);

    // Si no existe la venta, redirigir
    if(empty($datos_venta)){
        echo "Venta no encontrada";
        exit;
    }

    $cabecera = $datos_venta[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Venta #<?php echo $cabecera->id_venta; ?></title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; background-color: #f2f2f2; }
        .factura-container {
            max-width: 400px; /* Ancho tipo ticket */
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px dashed #333; padding-bottom: 10px; }
        .info-cliente { margin-bottom: 10px; font-size: 14px; }
        .tabla-productos { width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 15px; }
        .tabla-productos th { text-align: left; border-bottom: 1px solid #333; }
        .tabla-productos td { padding: 5px 0; }
        .total { text-align: right; font-size: 18px; font-weight: bold; border-top: 1px dashed #333; padding-top: 10px; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; }
        
        /* Ocultar botón de imprimir al imprimir */
        @media print {
            .no-print { display: none; }
            body { background-color: #fff; }
            .factura-container { box-shadow: none; margin: 0; width: 100%; }
        }
    </style>
</head>
<body> <div class="factura-container">
        <div class="header">
            <h2>FARMACIA MIA</h2>
            <p>RUC: J031000000000</p>
            <p>Dirección: Terminal 118, 4 cuadras al sur, 1 cuadra y media abajo. Managua, Nicaragua</p>
            <p>Tel: 8235-1430</p>
            <p>--------------------------------</p>
            <p><b>Factura N°: <?php echo $cabecera->id_venta; ?></b></p>
            <p>Fecha: <?php echo $cabecera->fecha; ?></p>
            <p>Atendido por: <?php echo $cabecera->vendedor; ?></p>
        </div>

        <div class="info-cliente">
            <p><b>Cliente:</b> <?php echo $cabecera->cliente; ?></p>
            <p><b>ID Empleador:</b> <?php echo $cabecera->dni; ?></p>
        </div>

        <table class="tabla-productos">
            <thead>
                <tr>
                    <th>Cant</th>
                    <th>Producto</th>
                    <th>P.Unit</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalle_venta as $det) { ?>
                <tr>
                    <td><?php echo $det->cantidad; ?></td>
                    <td><?php echo $det->nombre . ' ' . $det->concentracion; ?></td>
                    <td><?php echo number_format($det->precio, 2); ?></td>
                    <td><?php echo number_format($det->subtotal, 2); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="total">
            Total a Pagar: C$ <?php echo number_format($cabecera->total, 2); ?>
        </div>

        <div class="footer">
            <p>¡Gracias por su compra!</p>
            
        </div>
        
        <div class="no-print" style="text-align: center; margin-top: 20px;">
            <button onclick="window.print()" style="padding: 10px 20px; background: #28a745; color: #fff; border: none; cursor: pointer;">IMPRIMIR</button>
        </div>
    </div>

</body>
</html>
<?php
} else {
    header('Location: ../index.php');
}
?>