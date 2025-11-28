$(document).ready(function() {
    buscar_lotes_riesgo();
    buscar_stock_bajo(); //

    function buscar_lotes_riesgo() {
        // Llamamos a la función especial del controlador
        $.post('../controlador/LoteController.php', { funcion: 'buscar_riesgo' }, (response) => {
            const lotes = JSON.parse(response);
            let template = '';
            
            lotes.forEach(lote => {
                // Usamos clases de Bootstrap para colorear las filas según el estado
                // table-danger (rojo), table-warning (amarillo), table-success (verde)
                let clase_fila = '';
                if(lote.estado == 'danger') {
                    clase_fila = 'table-danger';
                } else if(lote.estado == 'warning') {
                    clase_fila = 'table-warning';
                } else {
                    clase_fila = 'table-success';
                }

                template += `
                    <tr class="${clase_fila}">
                        <td>${lote.nombre} <small>(${lote.concentracion})</small></td>
                        <td>${lote.stock}</td>
                        <td>${lote.laboratorio}</td>
                        <td>${lote.presentacion}</td>
                        <td>${lote.proveedor}</td>
                        <td style="font-weight: bold;">${lote.mes}</td>
                        <td style="font-weight: bold;">${lote.dia}</td>
                    </tr>`;
            });
            $('#lotes_riesgo').html(template);
        });
    }


    function buscar_stock_bajo() {
        $.post('../controlador/ProductoController.php', { funcion: 'buscar_stock_bajo' }, (response) => {
            const productos = JSON.parse(response);
            let template = '';
            
            if(productos.length === 0) {
                template = `<tr><td colspan="6" class="text-center">¡Excelente! No hay productos con stock crítico.</td></tr>`;
            } else {
                productos.forEach(producto => {
                    template += `
                        <tr class="bg-warning disabled" style="color:black;"> <td>${producto.nombre} <span class="badge badge-secondary">${producto.concentracion}</span></td>
                            <td>${producto.presentacion}</td>
                            <td>${producto.laboratorio}</td>
                            
                            <td style="font-weight:bold; font-size: 1.2em;">
                                ${producto.stock}
                            </td>
                            
                            <td>
                                <span class="badge badge-danger">Min: ${producto.stock_minimo}</span>
                            </td>
                            
                            <td>
                                <button class="btn btn-sm btn-info" onclick="location.href='../vista/adm_lote.php?id=${producto.id}'" title="Hacer Pedido">
                                    <i class="fas fa-dolly"></i> Pedir
                                </button>
                            </td>
                        </tr>`;
                });
            }
            $('#lista-stock-bajo').html(template);
        });
    }

});