<?php
session_start();
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 3 || $_SESSION['us_tipo'] == 2) {
    include_once 'layouts/header.php';
?>
    <title>Adm | Historial de Ventas</title>
    <?php include_once 'layouts/nav.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Historial de Ventas</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
                            <li class="breadcrumb-item active">Historial</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Consultar Ventas</h3>
                        <div class="input-group">
                            <input type="text" id="buscar-venta" class="form-control float-left" placeholder="Buscar por cliente o vendedor...">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover text-nowrap">
                            <thead class="table-success">
                                <tr>
                                    <th>Código Venta</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Codigo Empleador</th>
                                    <th>Total</th>
                                    <th>Vendedor</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody class="table-active" id="registros_historial">
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
<script src="../js/HistorialVenta.js"></script>