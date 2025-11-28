<?php
session_start();
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 3 || $_SESSION['us_tipo'] == 2) {
    include_once 'layouts/header.php';
?>
    <title>Adm | Catálogo</title>
    <?php include_once 'layouts/nav.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard - Alertas de Vencimiento</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li> 
                            <li class="breadcrumb-item active">Catálogo</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Lotes por Vencer / Vencidos</h3>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover text-nowrap">
                            <thead class="table-dark"> <!-- Encabezado Oscuro -->
                                <tr>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>Laboratorio</th>
                                    <th>Presentación</th>
                                    <th>Proveedor</th>
                                    <th>Meses</th> <!-- Calculado -->
                                    <th>Días</th>  <!-- Calculado -->
                                </tr>
                            </thead>
                            <tbody id="lotes_riesgo">
                                <!-- Se llena con JS -->
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-muted">
                        <i class="fas fa-square text-danger"></i> Vencido/Urgente 
                        <i class="fas fa-square text-warning ml-3"></i> Precaución
                        <i class="fas fa-square text-success ml-3"></i> Seguro
                    </div>
                </div>
            </div>
            <br>
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle"></i> Alertas de Bajo Stock
                        </h3>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Presentación</th>
                                    <th>Laboratorio</th>
                                    <th>Stock Actual</th>
                                    <th>Mínimo Requerido</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody id="lista-stock-bajo">
                                </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-muted">
                        * Los límites varían según la presentación (Ej: Tabletas < 50, Jarabes < 5).
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
<script src="../js/Catalogo.js"></script> <!-- Nuevo JS Específico -->