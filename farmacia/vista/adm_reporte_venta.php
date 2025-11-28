<?php
session_start();
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 3 || $_SESSION['us_tipo'] == 2) {
    include_once 'layouts/header.php';
?>

<title>Adm | Reporte de Ventas</title>
<?php include_once 'layouts/nav.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Reporte de Ventas por Fecha</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Selecciona el Rango</h3>
                </div>
                <div class="card-body">
                    <form id="form-reporte">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Fecha Inicio:</label>
                                <input type="date" id="fecha_inicio" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Fecha Fin:</label>
                                <input type="date" id="fecha_fin" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-search"></i> Generar Reporte
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-outline card-info">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead class="table-dark">
                            <tr>
                                <th># Venta</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>DNI</th>
                                <th>Vendedor</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="lista-reporte">
                            </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="5" class="text-right font-weight-bold">TOTAL VENDIDO:</td>
                                <td id="total-venta-reporte" class="font-weight-bold text-success">C$ 0.00</td>
                            </tr>
                        </tfoot>
                    </table>
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
<script src="../js/Reporte.js"></script>