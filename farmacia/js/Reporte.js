$(document).ready(function() {
    
    // Al hacer clic en el botón "Generar Reporte"
    $('#form-reporte').submit(function(e) {
        e.preventDefault();
        
        let inicio = $('#fecha_inicio').val();
        let fin = $('#fecha_fin').val();
        
        if(inicio > fin){
            Swal.fire('Error', 'La fecha de inicio no puede ser mayor a la final', 'error');
            return;
        }

        $.post('../controlador/VentaController.php', { funcion: 'reporte_ventas', inicio, fin }, (response) => {
            const ventas = JSON.parse(response);
            let template = '';
            let total_ventas = 0;

            ventas.forEach(venta => {
                total_ventas += parseFloat(venta.total);
                template += `
                    <tr>
                        <td>${venta.id_venta}</td>
                        <td>${venta.fecha}</td>
                        <td>${venta.cliente}</td>
                        <td>${venta.dni}</td>
                        <td>${venta.vendedor}</td>
                        <td>C$ ${venta.total}</td>
                    </tr>`;
            });
            
            $('#lista-reporte').html(template);
            $('#total-venta-reporte').html('C$ ' + total_ventas.toFixed(2));
        });
    });
});