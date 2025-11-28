$(document).ready(function(){
    buscar_Tipo();
    var funcion;
    var edit = false;

    $('#form-crear-tipo').submit(e => {
        e.preventDefault();
        let nombre_tipo = $('#nombre-tipo').val(); // Ojo con el ID del input
        let id_editado = $('#id_editar_tipo').val(); // Necesitas crear este input hidden
        
        if (edit == false) {
            funcion = 'crear';
        } else {
            funcion = 'editar';
        }

        $.post('../controlador/TipoController.php', { nombre_tipo, id_editado, funcion }, (response) => {
            if (response == 'add') {
                $('#add-tipo').hide('slow').show(1000).hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_Tipo();
            }
            if (response == 'noadd') {
                $('#noadd-tipo').hide('slow').show(1000).hide(2000);
                $('#form-crear-tipo').trigger('reset');
            }
            if (response == 'edit') {
                $('#edit-tipo').hide('slow').show(1000).hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_Tipo();
            }
            edit = false;
        });
    });

    function buscar_Tipo(consulta) {
        funcion = 'buscar';
        $.post('../controlador/TipoController.php', { consulta, funcion }, (response) => {
            const tipos = JSON.parse(response);
            let template = '';
            tipos.forEach(tipo => {
                template += `
                    <tr tipoId="${tipo.id}" tipoNombre="${tipo.nombre}">
                        <td>${tipo.nombre}</td>
                        <td>
                            <button class="editar-tipo btn btn-success" title="Editar tipo" type="button" data-toggle="modal" data-target="#creartipo">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="borrar-tipo btn btn-danger" title="Borrar tipo">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>`;
            });
            $('#tipos').html(template);
        });
    }

    $(document).on('keyup', '#buscar_tipo', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_Tipo(valor);
        } else {
            buscar_Tipo();
        }
    });

    $(document).on('click', '.borrar-tipo', function(e) {
        funcion = 'borrar';
        const elemento = $(this).closest('tr');
        const id = elemento.attr('tipoId');
        const nombre = elemento.attr('tipoNombre');

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
                $.post('../controlador/TipoController.php', { id, funcion }, (response) => {
                    if (response == 'borrado') {
                        swalWithBootstrapButtons.fire('Borrado!', 'El tipo ' + nombre + ' ha sido borrado.', 'success');
                        buscar_Tipo();
                    } else {
                        swalWithBootstrapButtons.fire('Error!', 'El tipo ' + nombre + ' no pudo ser borrado.', 'error');
                    }
                });
            }
        });
    });

    $(document).on('click', '.editar-tipo', function(e) { 
        const elemento = $(this).closest('tr');
        const id = elemento.attr('tipoId');
        const nombre = elemento.attr('tipoNombre');
        $('#id_editar_tipo').val(id);
        $('#nombre-tipo').val(nombre);
        edit = true;
    });
});