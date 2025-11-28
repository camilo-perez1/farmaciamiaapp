$(document).ready(function() {
    var edit = false;
    var funcion;
    buscar_prov();

    $('#form-crear').submit(e => {
        e.preventDefault();
        let nombre = $('#nombre').val();
        let telefono = $('#telefono').val();
        let correo = $('#correo').val();
        let direccion = $('#direccion').val();
        let id = $('#id_edit_prov').val();

        if (edit == false) {
            funcion = 'crear';
        } else {
            funcion = 'editar';
        }

        $.post('../controlador/ProveedorController.php', { nombre, telefono, correo, direccion, id, funcion }, (response) => {
            if (response == 'add') {
                $('#add').hide('slow').show(1000).hide(2000);
                $('#form-crear').trigger('reset');
                buscar_prov();
            }
            if (response == 'noadd') {
                $('#noadd').hide('slow').show(1000).hide(2000);
                $('#form-crear').trigger('reset');
            }
            if (response == 'edit') {
                $('#edit_prov').hide('slow').show(1000).hide(2000);
                $('#form-crear').trigger('reset');
                buscar_prov();
            }
            edit = false;
        });
    });

    function buscar_prov(consulta) {
        funcion = 'buscar';
        $.post('../controlador/ProveedorController.php', { consulta, funcion }, (response) => {
            const proveedores = JSON.parse(response);
            let template = '';
            proveedores.forEach(proveedor => {
                template += `
                <div provId="${proveedor.id}" provNombre="${proveedor.nombre}" provTelefono="${proveedor.telefono}" provCorreo="${proveedor.correo}" provDireccion="${proveedor.direccion}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                  <h1 class="badge badge-success">Proveedor</h1>
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>${proveedor.nombre}</b></h2>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Dirección: ${proveedor.direccion}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Teléfono #: ${proveedor.telefono}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Correo: ${proveedor.correo}</li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="../img/prod/prod_default.png" alt="" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <button class="avatar btn btn-sm bg-teal" title="Editar logo">
                      <i class="fas fa-image"></i>
                    </button>
                    <button class="editar btn btn-sm btn-success" title="Editar proveedor" data-toggle="modal" data-target="#crearproveedor">
                      <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button class="borrar btn btn-sm btn-danger" title="Borrar proveedor">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>`;
            });
            $('#proveedores').html(template);
        });
    }

    $(document).on('keyup', '#buscar_proveedor', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_prov(valor);
        } else {
            buscar_prov();
        }
    });

    $(document).on('click', '.editar', function() {
        const elemento = $(this).closest('div.card').parent(); // Ajustado para encontrar el div contenedor
        const id = $(elemento).attr('provId');
        const nombre = $(elemento).attr('provNombre');
        const telefono = $(elemento).attr('provTelefono');
        const correo = $(elemento).attr('provCorreo');
        const direccion = $(elemento).attr('provDireccion');
        
        $('#id_edit_prov').val(id);
        $('#nombre').val(nombre);
        $('#telefono').val(telefono);
        $('#correo').val(correo);
        $('#direccion').val(direccion);
        edit = true;
    });

    $(document).on('click', '.borrar', function() {
        const elemento = $(this).closest('div.card').parent();
        const id = $(elemento).attr('provId');
        const nombre = $(elemento).attr('provNombre');

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
                funcion = 'borrar';
                $.post('../controlador/ProveedorController.php', { id, funcion }, (response) => {
                    if (response == 'borrado') {
                        swalWithBootstrapButtons.fire('Borrado!', 'El proveedor ' + nombre + ' ha sido borrado.', 'success');
                        buscar_prov();
                    } else {
                        swalWithBootstrapButtons.fire('Error!', 'No se pudo borrar el proveedor (posiblemente tenga lotes).', 'error');
                    }
                });
            }
        });
    });
});