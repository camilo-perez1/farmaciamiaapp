$(document).ready(function() {
    var funcion;
    var edit = false;
    
    // Cargas iniciales
    buscar_producto();
    rellenar_laboratorios();
    rellenar_tipos();
    rellenar_presentaciones();

    // Función para llenar el Select de Laboratorios
    function rellenar_laboratorios() {
        funcion = "buscar";
        $.post('../controlador/LaboratorioController.php', { funcion }, (response) => {
            const laboratorios = JSON.parse(response); // OJO: Si tu controlador lab manda texto plano, ajusta esto
            let template = '';
            laboratorios.forEach(laboratorio => {
                template += `<option value="${laboratorio.id}">${laboratorio.nombre}</option>`;
            });
            $('#laboratorio').html(template);
        });
    }

    // Función para llenar el Select de Tipos
    function rellenar_tipos() {
        funcion = "buscar";
        $.post('../controlador/TipoController.php', { funcion }, (response) => {
            const tipos = JSON.parse(response);
            let template = '';
            tipos.forEach(tipo => {
                template += `<option value="${tipo.id}">${tipo.nombre}</option>`;
            });
            $('#tipo').html(template);
        });
    }

    // Función para llenar el Select de Presentaciones
    function rellenar_presentaciones() {
        funcion = "buscar";
        $.post('../controlador/PresentacionController.php', { funcion }, (response) => {
            const presentaciones = JSON.parse(response);
            let template = '';
            presentaciones.forEach(presentacion => {
                template += `<option value="${presentacion.id}">${presentacion.nombre}</option>`;
            });
            $('#presentacion').html(template);
        });
    }

    // Función Buscar Productos (Tabla)
    function buscar_producto(consulta) {
        funcion = "buscar";
        $.post('../controlador/ProductoController.php', { consulta, funcion }, (response) => {
            const productos = JSON.parse(response);
            let template = '';
            productos.forEach(producto => {
                template += `
                    <tr prodId="${producto.id}" prodNombre="${producto.nombre}" prodPrecio="${producto.precio}" 
                        prodConcentracion="${producto.concentracion}" prodAdicional="${producto.adicional}" 
                        prodLab="${producto.laboratorio_id}" prodTip="${producto.tipo_id}" prodPre="${producto.presentacion_id}">
                        <td>${producto.nombre}</td>
                        <td>${producto.concentracion}</td>
                        <td>${producto.adicional}</td>
                        <td>${producto.precio}</td>
                        <td>${producto.stock}</td>
                        <td>${producto.laboratorio}</td>
                        <td>${producto.tipo}</td>
                        <td>${producto.presentacion}</td>
                        <td>
                            <button class="editar btn btn-sm btn-success" title="Editar" data-toggle="modal" data-target="#crearproducto">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="borrar btn btn-sm btn-danger" title="Borrar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>`;
            });
            $('#productos').html(template);
        });
    }

    // Buscador
    $(document).on('keyup', '#buscar-producto', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_producto(valor);
        } else {
            buscar_producto();
        }
    });

    // Guardar (Crear o Editar)
    $('#form-crear-producto').submit(e => {
        e.preventDefault();
        let nombre = $('#nombre_producto').val();
        let concentracion = $('#concentracion').val();
        let adicional = $('#adicional').val();
        let precio = $('#precio').val();
        let laboratorio = $('#laboratorio').val();
        let tipo = $('#tipo').val();
        let presentacion = $('#presentacion').val();
        let id = $('#id_edit_prod').val(); // ID oculto

        if (edit == true) {
            funcion = "editar";
        } else {
            funcion = "crear";
        }

        $.post('../controlador/ProductoController.php', {
            funcion, id, nombre, concentracion, adicional, precio, laboratorio, tipo, presentacion
        }, (response) => {
            if (response == 'add') {
                $('#add').hide('slow').show(1000).hide(2000);
                $('#form-crear-producto').trigger('reset');
                buscar_producto();
            }
            if (response == 'edit') {
                $('#edit_prod').hide('slow').show(1000).hide(2000);
                $('#form-crear-producto').trigger('reset');
                buscar_producto();
            }
            if (response == 'noadd') {
                $('#noadd').hide('slow').show(1000).hide(2000);
                $('#form-crear-producto').trigger('reset');
            }
            edit = false;
        });
    });

    // Clic en Editar
    $(document).on('click', '.editar', function() {
        const elemento = $(this).closest('tr');
        
        // Rellenar formulario con datos actuales
        $('#id_edit_prod').val(elemento.attr('prodId'));
        $('#nombre_producto').val(elemento.attr('prodNombre'));
        $('#concentracion').val(elemento.attr('prodConcentracion'));
        $('#adicional').val(elemento.attr('prodAdicional'));
        $('#precio').val(elemento.attr('prodPrecio'));
        
        // Seleccionar los valores en los Selects
        $('#laboratorio').val(elemento.attr('prodLab'));
        $('#tipo').val(elemento.attr('prodTip'));
        $('#presentacion').val(elemento.attr('prodPre'));
        
        edit = true;
    });

    // Clic en Borrar
    $(document).on('click', '.borrar', function() {
        const elemento = $(this).closest('tr');
        const id = elemento.attr('prodId');
        const nombre = elemento.attr('prodNombre');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: { confirmButton: 'btn btn-success', cancelButton: 'btn btn-danger mr-1' },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: '¿Eliminar ' + nombre + '?',
            text: "No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, borrar!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                funcion = "borrar";
                $.post('../controlador/ProductoController.php', { funcion, id }, (response) => {
                    if (response == 'borrado') {
                        swalWithBootstrapButtons.fire('Borrado!', 'El producto ' + nombre + ' fue borrado.', 'success');
                        buscar_producto();
                    } else {
                        swalWithBootstrapButtons.fire('Error!', 'No se pudo borrar. Intenta más tarde.', 'error');
                    }
                });
            }
        });
    });
});