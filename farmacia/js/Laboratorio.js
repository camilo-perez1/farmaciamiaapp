$(document).ready(function(){
    buscar_Lab();
    var funcion;
    var edit = false;

    $('#form-crear-laboratorio').submit(e => {
        e.preventDefault();
        let nombre_laboratorio = $('#nombre_laboratorio').val();
        let id_editado = $('#id_editar_lab').val();
        if (edit == false) {
            funcion = 'crear';
        } else {
            funcion = 'editar';
        }

        $.post('../controlador/LaboratorioController.php', {
            id_editado,
            nombre_laboratorio,
            funcion
        }, (response) => {
            if (response.trim() == 'add') {
                $('#add-laboratorio').hide();
                $('#add-laboratorio').show(1000);
                $('#add-laboratorio').hide(2000);
                $('#form-crear-laboratorio').trigger('reset');
                buscar_Lab();
            } if(response=='noadd') {
                $('#noadd-laboratorio').hide();
                $('#noadd-laboratorio').show(1000);
                $('#noadd-laboratorio').hide(2000);
                $('#form-crear-laboratorio').trigger('reset');
            }
            if(response== 'edit'){
                $('#edit-lab').hide();
                $('#edit-lab').show(1000);
                $('#edit-lab').hide(2000);
                $('#form-crear-laboratorio').trigger('reset');
                buscar_Lab();
            }
            edit == false
        });
    });

    function buscar_Lab(consulta) {
        funcion = 'buscar';
        $.post('../controlador/LaboratorioController.php', {
            consulta,
            funcion
        }, (response) => {
            const laboratorios = JSON.parse(response);
            let template = '';
            laboratorios.forEach(laboratorio => {
                // CORREGIDO: Espacios entre atributos y estructura de botones
               template += `
                    <tr labId="${laboratorio.id}" labNombre="${laboratorio.nombre}" labAvatar="${laboratorio.avatar}">
                        <td>${laboratorio.nombre}</td>
                        <td>
                            <img src="${laboratorio.avatar}" class="img-fluid rounded-circle" width="70px" height="70px">
                        </td>
                        <td>
                            <button class="avatar btn btn-info" title="cambiar logo" type="button" data-toggle="modal" data-target="#cambiologo">
                                <i class="far fa-image"></i>
                            </button>
                            
                            <button class="editar btn btn-success" title="Editar laboratorio" type="button" data-toggle="modal" data-target="#crearlaboratorio">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            
                            <button class="borrar btn btn-danger" title="Eliminar Laboratorio">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
                    
            });
            $('#laboratorios').html(template);
        });
    }


    // Escuchar el clic en el botón borrar
    $(document).on('click', '.borrar', (e) => {
        // Obtenemos el elemento fila (tr) para sacar el ID
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('labId'); // Asegúrate que tu <tr> tenga el atributo labId
        const nombre = $(elemento).find('td').eq(0).text(); // Obtenemos el nombre para mostrarlo

        // Confirmación simple (puedes usar SweetAlert si lo tienes instalado)
        if (confirm(`¿Estás seguro de que deseas eliminar el laboratorio: ${nombre}?`)) {
            
            // Petición AJAX al controlador
            $.post('../controlador/LaboratorioController.php', {
                id: id,
                funcion: 'borrar'
            }, (response) => {
                
                // Si la respuesta es JSON (como configuramos en el controlador)
                // Nota: Si tu controlador no tiene header JSON, usa JSON.parse(response)
                // const respuesta = JSON.parse(response); 
                
                if (response.status == 'success') {
                    alert('Laboratorio eliminado correctamente');
                    buscar_lab(); // Recargar la lista
                } else {
                    alert('Error al eliminar: ' + response.message);
                }
            }, 'json'); // 'json' fuerza a jQuery a interpretar la respuesta como JSON
        }
    });




    $(document).on('keyup', '#buscar_laboratorio', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_Lab(valor);
        } else {
            buscar_Lab();
        }
    });



    // LOGICA CAMBIAR LOGO
    $(document).on('click', '.avatar', function(e) { // Usamos clase en minúscula
        // Seleccionamos la fila completa
        const elemento = $(this).closest('tr');
        
        // Obtenemos datos
        const id = elemento.attr('labId');
        const nombre = elemento.attr('labNombre');
        const avatar = elemento.attr('labAvatar');
        
        // Llenamos el modal
        $('#logoactual').attr('src', avatar);
        $('#nombre_logo').html(nombre);
        $('#id_logo_lab').val(id); // Asegúrate que este ID coincida con el input hidden
        $('#funcion').val('cambiar_logo');
    });

    $('#form-logo').submit(function(e) {
        e.preventDefault();
        
        let formdata = new FormData($('#form-logo')[0]);

        $.ajax({
            
            url: '../controlador/LaboratorioController.php', // CORREGIDO: Apuntaba a UsuarioController
            type: 'POST',
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.alert == 'edit') {
                    $('#logoactual').attr('src', response.ruta);
                    $('#edit').hide('slow').show(1000).hide(2000);
                    $('#form-logo').trigger('reset');
                    buscar_Lab();
                } else {
                    $('#noedit').hide('slow').show(1000).hide(2000);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
    // Escuchar el clic en el botón borrar (CÓDIGO CORREGIDO)
    $(document).on('click', '.borrar', function(e) {
        
        // 1. Obtener la fila (tr) de forma segura usando 'closest'
        // Esto funciona aunque hagas clic en el ícono <i> o en el botón
        const elemento = $(this).closest('tr');
        
        // 2. Obtener el ID del atributo 'labId'
        const id = $(elemento).attr('labId');
        
        // 3. Obtener el nombre (primera columna 'td') para mostrarlo en la alerta
        const nombre = $(elemento).find('td').eq(0).text(); 

        // DEBUG: Mira la consola del navegador (F12) para ver si sale el ID
        console.log('Intentando eliminar laboratorio con ID:', id);

        // Si el ID es undefined o vacío, detenemos todo
        if (!id) {
            console.error('Error: No se encontró el ID del laboratorio.');
            return;
        }

        // 4. Confirmación y Envío (Usando SweetAlert o confirm normal)
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto. Se borrará el laboratorio: " + nombre,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, borrarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Petición AJAX
               $.post('../controlador/LaboratorioController.php', {
                        id: id,
                        funcion: 'borrar'
                    }, (response) => {
                        
                        // CORRECCIÓN: Quitamos .trim() porque 'response' ya es un objeto
                        if (response.status == 'success') {
                            Swal.fire(
                                '¡Borrado!',
                                'El laboratorio ha sido eliminado.',
                                'success'
                            );
                            buscar_Lab(); // Recargar la lista
                        } else {
                            Swal.fire(
                                'Error',
                                'No se pudo borrar: ' + response.message,
                                'error'
                            );
                        }
                }, 'json'); // <--- Esto convierte la respuesta a Objeto automáticamente
            }
        })
    });


      $(document).on('click', '.editar',function(e){ 

         const elemento = $(this).closest('tr');
       
      /*  const elemento = $(this)[0].activeElement.parentElement.parentElement; */
         
        const id = elemento.attr('labId');
        const nombre = elemento.attr('labNombre');
        $('#id_editar_lab').val(id);
        $('#nombre_laboratorio').val(nombre);
       
       edit = true;
        
      
    });



});