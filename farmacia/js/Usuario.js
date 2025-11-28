$(document).ready(function() {
    var funcion = '';
    var id_usuario = $('#id_usuario').val();
    var edit = false;

    // IMPORTANTE: Llamar a buscar_usuario al cargar la página
    buscar_usuario(id_usuario);

    function buscar_usuario(dato) {
        funcion = 'buscar_usuario';
        $.ajax({
            url: '../controlador/UsuarioController.php',
            type: 'POST',
            data: {dato: dato, funcion: funcion},
            dataType: 'json',
            success: function(usuario) {
                console.log("Usuario cargado:", usuario);
                
                // Actualizar datos
                $('#nombre_us').html(usuario.nombre);
                $('#apellidos_us').html(usuario.apellidos);
                $('#edad').html(usuario.edad);
                $('#dni_us').html(usuario.dni);
                $('#us_tipo').html(usuario.tipo);
                $('#telefono_us').html(usuario.telefono);
                $('#residencia_us').html(usuario.residencia);
                $('#correo_us').html(usuario.correo);
                $('#sexo_us').html(usuario.sexo);
                $('#adicional_us').html(usuario.adicional);

                // Actualizar TODOS los avatares
                console.log("Actualizando avatar con:", usuario.avatar);
                $('#avatar1').attr('src', usuario.avatar);
                $('#avatar2').attr('src', usuario.avatar);
                $('#avatar3').attr('src', usuario.avatar);
            },
            error: function(xhr, status, error) {
                console.error("Error al buscar usuario:", error);
                console.log("Respuesta:", xhr.responseText);
            }
        });
    }
    
    $(document).on('click', '.edit', function(e) {
        funcion = 'capturar_datos';
        edit = true;
        $.ajax({
            url: '../controlador/UsuarioController.php',
            type: 'POST',
            data: {funcion: funcion, id_usuario: id_usuario},
            dataType: 'json',
            success: function(usuario) {
                $('#telefono').val(usuario.telefono);
                $('#residencia').val(usuario.residencia);
                $('#correo').val(usuario.correo);
                $('#sexo').val(usuario.sexo);
                $('#adicional').val(usuario.adicional);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    });

    $('#form-usuario').submit(function(e) {
        e.preventDefault();
        
        if (edit == true) {
            let telefono = $('#telefono').val();
            let residencia = $('#residencia').val();
            let correo = $('#correo').val();
            let sexo = $('#sexo').val();
            let adicional = $('#adicional').val();
            funcion = 'editar_usuario';
            
            $.ajax({
                url: '../controlador/UsuarioController.php',
                type: 'POST',
                data: {
                    id_usuario: id_usuario,
                    funcion: funcion,
                    telefono: telefono,
                    residencia: residencia,
                    correo: correo,
                    sexo: sexo,
                    adicional: adicional
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        $('#status').hide('slow').show(1000).hide(2000);
                        $('#form-usuario').trigger('reset');
                        edit = false; 
                        buscar_usuario(id_usuario);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        } else {
            $('#noeditado').hide('slow').show(1000).hide(2000);
            $('#form-usuario').trigger('reset');
        }
    });

    $('#form-pass').submit(function(e) {
        e.preventDefault();
        
        let oldpass = $('#oldpass').val();
        let newpass = $('#newpass').val();
        funcion = 'cambiar_contra';
        
        $.ajax({
            url: '../controlador/UsuarioController.php',
            type: 'POST',
            data: {
                id_usuario: id_usuario,
                funcion: funcion,
                oldpass: oldpass,
                newpass: newpass
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    $('#update').hide('slow').show(1000).hide(2000);
                    $('#form-pass').trigger('reset');
                    setTimeout(function() {
                        $('#cambiocontra').modal('hide');
                    }, 2000);
                } else if (response.status == 'error_pass') {
                    $('#noupdate').hide('slow').show(1000).hide(2000);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    });

    $('#form-photo').submit(function(e) {
        e.preventDefault();
        
        let formdata = new FormData($('#form-photo')[0]);
        
        $.ajax({
            url: '../controlador/UsuarioController.php',
            type: 'POST',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log("Respuesta cambiar foto:", response);
                
                if (response.alert == 'edit') {
                    // Actualizar TODOS los avatares
                    $('#avatar1').attr('src', response.ruta + '?t=' + new Date().getTime());
                    $('#avatar2').attr('src', response.ruta + '?t=' + new Date().getTime());
                    $('#avatar3').attr('src', response.ruta + '?t=' + new Date().getTime());
                    
                    $('#edit').hide('slow').show(1000).hide(2000);
                    $('#form-photo').trigger('reset');
                    
                    setTimeout(function() {
                        $('#cambiophoto').modal('hide');
                        buscar_usuario(id_usuario);
                    }, 2000);
                } else {
                    $('#noedit').hide('slow').show(1000).hide(2000);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al cambiar foto:", error);
                console.log("Respuesta:", xhr.responseText);
                $('#noedit').hide('slow').show(1000).hide(2000);
            }
        });
    });
});