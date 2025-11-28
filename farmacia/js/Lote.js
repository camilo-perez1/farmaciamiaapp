$(document).ready(function() {
    var funcion;

    // Cargas iniciales
    buscar_lote();
    rellenar_productos();
    rellenar_proveedores();

    // 1. Rellenar Select de Productos
    // En farmacia/js/Lote.js

    // 1. Rellenar Select de Productos (MODIFICADO)
    function rellenar_productos() {
        funcion = "buscar";
        $.post('../controlador/ProductoController.php', { funcion }, (response) => {
            const productos = JSON.parse(response);
            let template = '';
            productos.forEach(producto => {
                template += `<option value="${producto.id}">${producto.nombre} - ${producto.concentracion} (${producto.adicional})</option>`;
            });
            $('#producto_lote').html(template);

            // --- NUEVO CÓDIGO: AUTO-SELECCIÓN ---
            // 1. Buscamos si hay un "?id=..." en la URL
            const urlParams = new URLSearchParams(window.location.search);
            const id_prod = urlParams.get('id');
            
            // 2. Si existe, seleccionamos el producto en el Select
            if(id_prod){
                $('#producto_lote').val(id_prod);
                
                // (Opcional) Hacer scroll suave hasta el formulario para que el usuario lo vea
                $('html, body').animate({
                    scrollTop: $("#form-crear-lote").offset().top
                }, 500);
            }
            // -------------------------------------
        });
    }

    // 2. Rellenar Select de Proveedores
    function rellenar_proveedores() {
        funcion = "buscar";
        $.post('../controlador/ProveedorController.php', { funcion }, (response) => {
            const proveedores = JSON.parse(response);
            let template = '';
            proveedores.forEach(proveedor => {
                template += `<option value="${proveedor.id}">${proveedor.nombre}</option>`;
            });
            $('#proveedor_lote').html(template);
        });
    }

    // 3. Crear Lote
    $('#form-crear-lote').submit(e => {
        e.preventDefault();
        let id_producto = $('#producto_lote').val();
        let proveedor = $('#proveedor_lote').val();
        let stock = $('#stock_lote').val();
        let vencimiento = $('#vencimiento_lote').val();
        
        funcion = 'crear';

        $.post('../controlador/LoteController.php', {
            funcion, id_producto, proveedor, stock, vencimiento
        }, (response) => {
            if (response.trim() == 'add') {
                $('#add-lote').hide('slow').show(1000).hide(2000);
                $('#form-crear-lote').trigger('reset');
                buscar_lote();
            } else {
                alert('No se pudo agregar el lote');
            }
        });
    });

    // 4. Buscar Lotes
    function buscar_lote(consulta) {
        funcion = "buscar_riesgo"; // Reutilizamos la función del dashboard que trae todos los datos bonitos
        $.post('../controlador/LoteController.php', { consulta, funcion }, (response) => {
            const lotes = JSON.parse(response);
            let template = '';
            lotes.forEach(lote => {
                template += `
                    <tr loteId="${lote.id}">
                        <td>${lote.nombre}</td>
                        <td>${lote.stock}</td>
                        <td>${lote.vencimiento}</td>
                        <td>${lote.laboratorio}</td>
                        <td>${lote.proveedor}</td>
                        <td>
                            <button class="borrar btn btn-sm btn-danger" title="Borrar Lote">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>`;
            });
            $('#lotes').html(template);
        });
    }

    // 5. Buscador
    $(document).on('keyup', '#buscar-lote', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_lote(valor);
        } else {
            buscar_lote();
        }
    });

    // 6. Borrar Lote
    $(document).on('click', '.borrar', function() {
        const elemento = $(this).closest('tr');
        const id = elemento.attr('loteId');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: { confirmButton: 'btn btn-success', cancelButton: 'btn btn-danger mr-1' },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: '¿Eliminar Lote?',
            text: "Se borrará el stock asociado. ¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, borrar!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                funcion = "borrar";
                $.post('../controlador/LoteController.php', { funcion, id }, (response) => {
                    if (response.trim() == 'borrado') {
                        swalWithBootstrapButtons.fire('Borrado!', 'El lote ha sido eliminado.', 'success');
                        buscar_lote();
                    } else {
                        swalWithBootstrapButtons.fire('Error!', 'No se pudo borrar.', 'error');
                    }
                });
            }
        });
    });
});