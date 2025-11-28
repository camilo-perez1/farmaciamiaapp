$(document).ready(function() {
    buscar_Presentacion();
    var funcion;
    var edit = false;

    $('#form-crear-presentacion').submit(e => {
        e.preventDefault();
        let nombre_presentacion = $('#nombre-presentacion').val();
        let id_editado = $('#id_editar_presentacion').val();
        
        if (edit == false) {
            funcion = 'crear';
        } else {
            funcion = 'editar';
        }

        $.post('../controlador/PresentacionController.php', { nombre_presentacion, id_editado, funcion }, (response) => {
            // CORRECCIÓN 1: Usar trim() para limpiar la respuesta de texto
            if (response.trim() == 'add') {
                $('#add-pre').hide('slow').show(1000).hide(2000);
                $('#form-crear-presentacion').trigger('reset');
                buscar_Presentacion();
            }
            if (response.trim() == 'noadd') {
                $('#noadd-pre').hide('slow').show(1000).hide(2000);
                $('#form-crear-presentacion').trigger('reset');
            }
            if (response.trim() == 'edit') {
                $('#edit-pre').hide('slow').show(1000).hide(2000);
                $('#form-crear-presentacion').trigger('reset');
                buscar_Presentacion();
            }
            edit = false;
        });
    });

    function buscar_Presentacion(consulta) {
        funcion = 'buscar';
        $.post('../controlador/PresentacionController.php', { consulta, funcion }, (response) => {
            
            // CORRECCIÓN 2: Parsear el JSON manualmente (como en Laboratorio)
            const presentaciones = JSON.parse(response); 
            
            let template = '';
            presentaciones.forEach(presentacion => {
                template += `
                    <tr preId="${presentacion.id}" preNombre="${presentacion.nombre}">
                        <td>${presentacion.nombre}</td>
                        <td>
                            <button class="editar-pre btn btn-success" title="Editar presentacion" type="button" data-toggle="modal" data-target="#crearpresentacion">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="borrar-pre btn btn-danger" title="Borrar presentacion">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>`;
            });
            $('#presentaciones').html(template);
        });
    }

    // ... (El resto del código: Buscador y Borrar se mantienen igual) ...
    $(document).on('keyup', '#buscar_presentacion', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_Presentacion(valor);
        } else {
            buscar_Presentacion();
        }
    });

    $(document).on('click', '.borrar-pre', function(e) {
        // ... (Tu código de borrar con SweetAlert) ...
        funcion = 'borrar';
        const elemento = $(this).closest('tr');
        const id = elemento.attr('preId');
        const nombre = elemento.attr('preNombre');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: { confirmButton: 'btn btn-success', cancelButton: 'btn btn-danger mr-1' },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: '¿Está seguro de eliminar ' + nombre + '?',
            text: "No podrá revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, borrar!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/PresentacionController.php', { id, funcion }, (response) => {
                    if (response.trim() == 'borrado') { // <--- OJO AQUÍ TAMBIÉN AGREGUÉ TRIM
                        swalWithBootstrapButtons.fire('Borrado!', 'La presentación ' + nombre + ' ha sido borrada.', 'success');
                        buscar_Presentacion();
                    } else {
                        swalWithBootstrapButtons.fire('Error!', 'No se pudo borrar: ' + response, 'error');
                    }
                });
            }
        });
    });

    $(document).on('click', '.editar-pre', function(e) { 
        const elemento = $(this).closest('tr');
        const id = elemento.attr('preId');
        const nombre = elemento.attr('preNombre');
        $('#id_editar_presentacion').val(id);
        $('#nombre-presentacion').val(nombre);
        edit = true;
    });
});