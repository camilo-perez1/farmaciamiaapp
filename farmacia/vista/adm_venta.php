<?php
session_start();
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 3 || $_SESSION['us_tipo'] == 2) {
    include_once 'layouts/header.php';
?>
    <title>Adm | Nueva Venta</title>
    <?php include_once 'layouts/nav.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Nueva Venta</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
                            <li class="breadcrumb-item active">Ventas</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    
                   <div class="col-md-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Carrito de Compras</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-8">
                                        <label>Cliente</label>
                                        <input type="text" class="form-control" id="cliente" placeholder="Nombre Cliente (Opcional)">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Nombre Empleador</label>
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['nombre_us']; ?>" readonly>
                                        <input type="hidden" id="id_vendedor" value="<?php echo $_SESSION['usuario']; ?>">
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover text-nowrap table-striped">
                                        <thead class="table-success">
                                            <tr>
                                                <th>Producto</th>
                                                <th>Descripcion</th>
                                                <th>Precio</th>
                                                <th style="width: 150px;">Cantidad</th>
                                                <th>Subtotal</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lista-carrito">
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-4 offset-md-8">
                                        <div class="float-right text-right">
                                            <h3>Total: C$ <span id="total">0.00</span></h3>
                                            <button id="procesar-venta" class="btn btn-success btn-lg mt-2">
                                                <i class="fas fa-save"></i> Realizar Venta
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="card card-primary collapsed-card"> <div class="card-header">
                                <h3 class="card-title">Catálogo de Productos</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0" style="display: block;"> <div class="p-3">
                                    <div class="input-group">
                                        <input id="buscar-producto" type="text" class="form-control" placeholder="Buscar producto por nombre...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive" style="height: 400px;">
                                    <table class="table table-hover text-nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Producto</th>
                                                <th>Conc.</th>
                                                <th>Adicional</th>
                                                <th>Precio</th>
                                                <th>Agregar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lista-productos">
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

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
<script src="../js/Venta.js"></script>