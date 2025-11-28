
<?php
session_start();
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 3) {
    include_once 'layouts/header.php';
?>
    <title>Adm | Productos</title>
    <?php include_once 'layouts/nav.php'; ?>

    <div class="modal fade" id="crearproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Gestión de Producto</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success text-center" id="add" style="display:none;">
                            <span><i class="fas fa-check m-1"></i>Producto agregado correctamente</span>
                        </div>
                        <div class="alert alert-danger text-center" id="noadd" style="display:none;">
                            <span><i class="fas fa-times m-1"></i>El producto ya existe</span>
                        </div>
                        <div class="alert alert-success text-center" id="edit_prod" style="display:none;">
                            <span><i class="fas fa-check m-1"></i>Producto editado correctamente</span>
                        </div>

                        <form id="form-crear-producto">
                            <div class="form-group">
                                <label for="nombre_producto">Nombre</label>
                                <input type="text" class="form-control" id="nombre_producto" placeholder="Nombre del producto" required>
                                <input type="hidden" id="id_edit_prod"> </div>
                            <div class="form-group">
                                <label for="concentracion">Concentración</label>
                                <input type="text" class="form-control" id="concentracion" placeholder="Ej: 500mg">
                            </div>
                            <div class="form-group">
                                <label for="adicional">Adicional</label>
                                <input type="text" class="form-control" id="adicional" placeholder="Ej: Caja x 10">
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" step="any" class="form-control" id="precio" placeholder="Precio" required>
                            </div>

                            <div class="form-group">
                                <label for="laboratorio">Laboratorio</label>
                                <select id="laboratorio" class="form-control select2" style="width: 100%" required></select>
                            </div>
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select id="tipo" class="form-control select2" style="width: 100%" required></select>
                            </div>
                            <div class="form-group">
                                <label for="presentacion">Presentación</label>
                                <select id="presentacion" class="form-control select2" style="width: 100%" required></select>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-primary float-right">Guardar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right mr-2">Cerrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestión de Productos</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
                            <li class="breadcrumb-item active">Productos</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Buscar Producto <button type="button" data-toggle="modal" data-target="#crearproducto" class="btn bg-gradient-primary btn-sm m-2">Crear Producto</button></h3>
                        <div class="input-group">
                            <input type="text" id="buscar-producto" class="form-control float-left" placeholder="Ingrese nombre de producto">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover text-nowrap">
                            <thead class="table-success">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Concentración</th>
                                    <th>Adicional</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Laboratorio</th>
                                    <th>Tipo</th>
                                    <th>Presentación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-active" id="productos">
                                </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </section>
    </div>

<?php
    include_once 'layouts/footer.php';
} else {
    header('Location: ../index.php');
}
?>


<?php
/*
session_start();
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] ==3) {
    include_once 'layouts/header.php';
?>
  <title>Farmacia | Editar datos personales</title>

<?php
    include_once 'layouts/nav.php';
?>
  <!-- Button trigger modal -->



<!-- Modal Cambiar Avatar -->
<div class="modal fade" id="crearproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Crear producto</h3>
          <button data-dismiss="modal" aria-label="close" class="close">
            <span aria-hiddem="true">&times;</span>
          </button>
        </div> 
        
            
            <form id="form-crear-producto">
              <div class="card-body">
            <div id="div_alerta_exito" class="alert alert-success text-center" style="display:none;">
              <span><i class="fas fa-check m-1"></i>Se agrego correctamente</span>
            </div>
            <div id="div_alerta_error" class="alert alert-danger text-center" style="display:none;">
              <span><i class="fas fa-times m-1"></i>El producto ya existe en otro usuario</span>
            </div>
              <div class="form-group">
                <label for="nombre_producto">Nombre</label>
                <input id="nombre" type="text" class="form-control" placeholder="Ingrese Nombre"  required>
              </div>
              <div class="form-group">
                <label for="concentracion">Concentracion</label>
                <input id="concentracion" type="text" class="form-control" placeholder="Ingrese concentracion" >
              </div>
              <div class="form-group">
                <label for="adicional">Adicional</label>
                <input id="adicional" type="text" class="form-control" placeholder="Ingrese adicional"  >
              </div>
              <div class="form-group">
                <label for="precio">Precio</label>
                <input id="precio" type="number" class="form-control" value="1" placeholder="Ingrese precio"  required>
              </div>
              <div class="form-group">
                <label for="laboratorio">Laboratorio</label>
                <select name="laboratorio" id="laboratorio" class="form-control"></select> 
              </div>
              <div class="form-group">
                <label for="tipo">Tipo</label>
                <select name="tipo" id="tipo" class="form-control"></select> 
              </div>
              <div class="form-group">
                <label for="presentacion">Presentacion</label>
                <select name="presentacion" id="presentacion" class="form-control"></select> 
              </div>
            
          </div>
          <div class="card-footer">
              <button type="submit" class="btn bg-gradient-primary float-right">Guardar</button>
              <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right mr-2">Close</button>
            </form>
          </div>
        
      </div>
      

    </div>
  </div>
</div>



  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestion Producto 
            <button type="button" id="button-crear" data-toggle="modal" data-target="#crearproducto" 
            class="btn bg-gradient-primary ml-2">Crear producto</button></h1>


            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestion producto</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section>
     <div class="container-fluid">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Buscar producto</h3>
                <div class="input-group">
                  <input type="text" id="buscar-producto"class="form-control float-left" placeholder="Ingrese nombere de producto">
                <div class="input-group-append">
                        <button class="btn btn-default"><i class="fas fa-search"></i></button></div>
                </div>
            </div>
            <div  class="card-body">
              <div id="productos" class="row d-flex align-items-stretch">
              </div>
            </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
     </div>
    </section>
  </div>

  
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../js/demo.js"></script>

<?php
    include_once 'layouts/footer.php';
} else {
    header('Location: ../index.php');
    exit;

}  
*/
?>

<script src="../js/Producto.js"></script>


