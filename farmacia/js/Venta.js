$(document).ready(function() {
    let funcion;
    let carrito = []; 

    buscar_producto();

    // 1. Buscar Productos
    // En farmacia/js/Venta.js

function buscar_producto(consulta) {
    funcion = "buscar";
    $.post('../controlador/ProductoController.php', { consulta, funcion }, (response) => {
        const productos = JSON.parse(response);
        let template = '';
        productos.forEach(producto => {
            // Lógica para verificar el stock
            let stock = producto.stock;
            let boton = '';
            
            if(stock > 0){
                boton = `<button class="agregar-carrito btn btn-circle btn-primary">
                            <i class="fas fa-plus"></i>
                         </button>`;
            } else {
                boton = `<span class="badge badge-danger">Agotado</span>`;
            }

            // Agregamos prodStock a los atributos y la columna de Stock visual
            template += `
                <tr prodId="${producto.id}" prodNombre="${producto.nombre}" prodPrecio="${producto.precio}" 
                    prodConcentracion="${producto.concentracion}" prodAdicional="${producto.adicional}"
                    prodStock="${producto.stock}"> 
                    
                    <td>${producto.nombre}</td>
                    <td>${producto.concentracion}</td>
                    <td>${producto.adicional}</td>
                    <td>C$ ${producto.precio}</td>
                    <td>${producto.stock}</td> <td>
                        ${boton}
                    </td>
                </tr>`;
        });
        $('#lista-productos').html(template);
    });
}

    $(document).on('keyup', '#buscar-producto', function() {
        let valor = $(this).val();
        if (valor != "") {
            buscar_producto(valor);
        } else {
            buscar_producto();
        }
    });

    // 2. Agregar al Carrito
    // En farmacia/js/Venta.js

$(document).on('click', '.agregar-carrito', function() {
    const elemento = $(this).closest('tr');
    const id = elemento.attr('prodId');
    const nombre = elemento.attr('prodNombre');
    const precio = elemento.attr('prodPrecio');
    const concentracion = elemento.attr('prodConcentracion');
    const adicional = elemento.attr('prodAdicional');
    // 1. Capturamos el stock actual del HTML
    const stock = parseInt(elemento.attr('prodStock'));

    const producto = {
        id: id,
        nombre: nombre,
        descripcion: concentracion + ' ' + adicional,
        precio: precio,
        stock: stock, // 2. Guardamos el stock en el objeto
        cantidad: 1,
        subtotal: precio 
    };

    let id_producto_encontrado = false;
    
    // Verificamos si ya existe y si podemos sumar más
    carrito.forEach(prod => {
        if (prod.id === id) {
            id_producto_encontrado = true;
            // 3. Validación: Si la cantidad actual es menor al stock, sumamos
            if(prod.cantidad < prod.stock){
                prod.cantidad++; 
                prod.subtotal = prod.precio * prod.cantidad;
            } else {
                // Opcional: Alerta visual de que alcanzó el límite
                Swal.fire('Atención', 'Stock máximo alcanzado para este producto', 'warning');
            }
        }
    });

    if (!id_producto_encontrado) {
        // Si es nuevo en el carrito, verificamos que haya al menos 1 en stock (doble seguridad)
        if(stock > 0){
            carrito.push(producto);
        }
    }

    dibujarCarrito();
});

    // 3. Dibujar Carrito (Ajustado para vista ancha)
    function dibujarCarrito() {
        let template = '';
        let total = 0;

        carrito.forEach(prod => {
            total += parseFloat(prod.subtotal);
            template += `
                <tr prodId="${prod.id}">
                    <td>${prod.nombre}</td>
                    <td>${prod.descripcion}</td>
                    <td>C$ ${prod.precio}</td>
                    
                    <td style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <button class="restar-producto btn btn-warning">
                            <i class="fas fa-minus"></i>
                        </button>
                        
                        <span style="font-size: 1.2em; font-weight: bold; width: 30px; text-align: center;">${prod.cantidad}</span>
                        
                        <button class="sumar-producto btn btn-primary">
                            <i class="fas fa-plus"></i>
                        </button>
                    </td>

                    <td>C$ ${parseFloat(prod.subtotal).toFixed(2)}</td>
                    <td>
                        <button class="borrar-producto btn btn-danger btn-block">
                            <i class="fas fa-trash-alt"></i> Borrar
                        </button>
                    </td>
                </tr>`;
        });

        $('#lista-carrito').html(template);
        $('#total').html(total.toFixed(2));
    }

    // 4. Botones Restar, Sumar y Borrar
    $(document).on('click', '.restar-producto', function() {
        const elemento = $(this).closest('tr');
        const id = elemento.attr('prodId');
        carrito.forEach((prod, index) => {
            if (prod.id === id) {
                if (prod.cantidad > 1) {
                    prod.cantidad--;
                    prod.subtotal = prod.precio * prod.cantidad;
                } else {
                    carrito.splice(index, 1);
                }
            }
        });
        dibujarCarrito();
    });

    // En farmacia/js/Venta.js

$(document).on('click', '.sumar-producto', function() {
    const elemento = $(this).closest('tr');
    const id = elemento.attr('prodId');
    carrito.forEach(prod => {
        if (prod.id === id) {
            // Validamos contra el stock que guardamos en el objeto
            if(prod.cantidad < prod.stock){
                prod.cantidad++;
                prod.subtotal = prod.precio * prod.cantidad;
            } else {
                Swal.fire('Atención', 'No hay más stock disponible de este producto', 'error');
            }
        }
    });
    dibujarCarrito();
});

    $(document).on('click', '.borrar-producto', function() {
        const elemento = $(this).closest('tr');
        const id = elemento.attr('prodId');
        carrito = carrito.filter(prod => prod.id !== id);
        dibujarCarrito();
    });

    // 5. Procesar Venta (Cliente Opcional)
   // 5. Procesar Venta (Actualizado)
    $('#procesar-venta').click(function() {
        if (carrito.length === 0) {
            Swal.fire('Error', 'El carrito está vacío, agregue productos.', 'error');
        } else {
            let cliente = $('#cliente').val();
            if(cliente === "") {
                cliente = "Consumidor Final";
            }
            
            // CAMBIO: El DNI del cliente ya no se pide, enviamos 1 por defecto
            let dni = 1; 
            
            // CAMBIO: Capturamos el ID del vendedor desde el input readonly
           // CAMBIO: Ahora tomamos el ID del campo oculto
            let vendedor = $('#id_vendedor').val();
            
            let total = $('#total').html();
            
            let json = JSON.stringify(carrito);

            $.post('../controlador/VentaController.php', {
                funcion: 'registrar_venta',
                cliente: cliente,
                dni: dni, // Enviamos 1 como DNI de cliente genérico
                total: total,
                vendedor: vendedor, // Enviamos el ID real del empleado
                json: json
            }, (response) => {
                if (response.trim() == 'add') {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Venta Realizada',
                        text: 'Vendedor #' + vendedor + ' registró la venta.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    carrito = [];
                    dibujarCarrito();
                    $('#cliente').val('');
                } else {
                    Swal.fire('Error', 'No se pudo realizar la venta: ' + response, 'error');
                }
            });
        }
    });
});
