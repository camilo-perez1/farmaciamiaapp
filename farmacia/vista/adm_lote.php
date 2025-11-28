<?php
session_start();
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 3) {
    include_once 'layouts/header.php';
?>
    <title>Adm | Gestión Lotes</title>
    <?php include_once 'layouts/nav.php'; ?>

    <!-- Modal Crear Lote -->
    <div class="modal fade" id="crearlote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Crear Lote</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success text-center" id="add-lote" style="display:none;">
                            <span><i class="fas fa-check m-1"></i>Lote agregado correctamente</span>
                        </div>
                        
                        <form id="form-crear-lote">
                            <div class="form-group">
                                <label for="producto_lote">Producto:</label>
                                <!-- Se llena con JS -->
                                <select id="producto_lote" class="form-control select2" style="width: 100%" required></select>
                            </div>
                            <div class="form-group">
                                <label for="proveedor_lote">Proveedor:</label>
                                <!-- Se llena con JS -->
                                <select id="proveedor_lote" class="form-control select2" style="width: 100%" required></select>
                            </div>
                            <div class="form-group">
                                <label for="stock_lote">Stock (Cantidad):</label>
                                <input type="number" id="stock_lote" class="form-control" placeholder="Ingrese cantidad" required>
                            </div>
                            <div class="form-group">
                                <label for="vencimiento_lote">Vencimiento:</label>
                                <input type="date" id="vencimiento_lote" class="form-control" required>
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

    <!-- Contenido Principal -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestión de Lotes <button type="button" data-toggle="modal" data-target="#crearlote" class="btn bg-gradient-primary btn-sm m-2">Crear Lote</button></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
                            <li class="breadcrumb-item active">Gestión Lotes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Buscar Lotes</h3>
                        <div class="input-group">
                            <input type="text" id="buscar-lote" class="form-control float-left" placeholder="Ingrese nombre de producto">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover text-nowrap">
                            <thead class="table-success">
                                <tr>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>Vencimiento</th>
                                    <th>Laboratorio</th>
                                    <th>Proveedor</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody class="table-active" id="lotes">
                                <!-- Se llena con JS -->
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
<script src="../js/Lote.js"></script>