$(document).ready(function() {
    let funcion = "buscar";
    
    // Carga inicial
    buscar_historial();

    // Función Buscar
    function buscar_historial(consulta) {
        $.post('../controlador/VentaController.php', { consulta, funcion }, (response) => {
            const ventas = JSON.parse(response);
            let template = '';
            ventas.forEach(venta => {
                template += `
                    <tr ventaId="${venta.id}">
                        <td>${venta.id}</td>
                        <td>${venta.fecha}</td>
                        <td>${venta.cliente}</td>
                        <td>${venta.dni}</td>
                        <td>C$ ${venta.total}</td>
                        <td>${venta.vendedor}</td>
                        <td>
                            <button class="ver-detalle btn btn-info" title="Ver Detalles">
                                <i class="fas fa-print"></i>
                            </button>
                        </td>
                    </tr>`;
            });
            $('#registros_historial').html(template);
        });
    }

    // Buscador en tiempo real
    $(document).on('keyup', '#buscar-venta', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_historial(valor);
        } else {
            buscar_historial();
        }
    });
    
    // Aquí puedes agregar la lógica para el botón de imprimir más adelante
    $(document).on('click', '.ver-detalle', function() {
        let elemento = $(this).closest('tr');
        let id = elemento.attr('ventaId');
        // Por ahora solo mostramos el ID, luego podemos hacer que genere un PDF
        alert('Generar reporte de venta: ' + id);
    });




    // ... dentro de $(document).ready ...

    $(document).on('click', '.ver-detalle', function() {
        let elemento = $(this).closest('tr');
        let id = elemento.attr('ventaId');
        
        // Abrir la factura en una pestaña nueva
        window.open('../vista/factura.php?id=' + id, '_blank');
    });
});