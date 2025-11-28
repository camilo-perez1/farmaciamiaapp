
<?php

session_start();
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] ==3) {
    include_once 'layouts/header.php';
?>
  <title>Farmacia | Editar datos personales</title>

<?php
    include_once 'layouts/nav.php';
?>
  <!-- Button trigger modal -->


<!-- Modal  -->
<div class="modal fade" id="confirmar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmar Accion</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img id="avatar3" src="../img/avatar04.png" class="profile-user-img img-fluid img-circle">
        </div>
        <div class="text-center">
          <b>
            <?php echo $_SESSION['nombre_us']; ?>
          </b>
        </div>
        <span>Necesitamos su password para confirmar</span>
        <div id="confirmado" class="alert alert-success text-center" style="display:none;">
          <span><i class="fas fa-check m-1"></i>Se modifico correctamente</span>
        </div>
        <div id="rechazado" class="alert alert-danger text-center" style="display:none;">
          <span><i class="fas fa-times m-1"></i>El password no es correcto</span>
        </div>
        <form id="form-confirmar"> 
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
              </div>
              <input id="oldpass" type="password" class="form-control" placeholder="Ingrese password actual" required>
              <input type="hidden" id="id_user">
              <input type="hidden" id="funcion">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn bg-gradient-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Cambiar Avatar -->
<div class="modal fade" id="crearusuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Crear Usuario</h3>
          <button data-dismiss="modal" aria-label="close" class="close">
            <span aria-hiddem="true">&times;</span>
          </button>
        </div> 
        
            
            <form id="form-crear">
              <div class="card-body">
            <div id="div_alerta_exito" class="alert alert-success text-center" style="display:none;">
              <span><i class="fas fa-check m-1"></i>Se agrego correctamente</span>
            </div>
            <div id="div_alerta_error" class="alert alert-danger text-center" style="display:none;">
              <span><i class="fas fa-times m-1"></i>El codigo ya existe en otro usuario</span>
            </div>
              <div class="form-group">
                <label for="nombre">Nombres</label>
                <input id="nombre" type="text" class="form-control" placeholder="Ingrese Nombre"  required>
              </div>
              <div class="form-group">
                <label for="apellido">Apellidos</label>
                <input id="apellido" type="text" class="form-control" placeholder="Ingrese apellido"  required>
              </div>
              <div class="form-group">
                <label for="edad">Nacimiento</label>
                <input id="edad" type="date" class="form-control" placeholder="Ingrese Nacimiento"  required>
              </div>
              <div class="form-group">
                <label for="dni">Codigo</label>
                <input id="dni" type="text" class="form-control" placeholder="Ingrese Codigo"  required>
              </div>
              <div class="form-group">
                <label for="pass">Password</label>
                <input id="pass" type="password" class="form-control" placeholder="Ingrese password"  required>
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
            <h1>Gestion Usuarios 
            <button type="button" id="button-crear" data-toggle="modal" data-target="#crearusuario" 
            class="btn bg-gradient-primary ml-2">Crear usuario</button></h1>


            <input type="hidden" id="tipo_usuario" value="<?php echo $_SESSION['us_tipo']?>">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestion Usuario</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section>
     <div class="container-fluid">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Buscar usuario</h3>
                <div class="input-group">
                  <input type="text" id="buscar"class="form-control float-left" placeholder="Ingrese nombere de usuario">
                <div class="input-group-append">
                        <button class="btn btn-default"><i class="fas fa-search"></i></button></div>
                </div>
            </div>
            <div  class="card-body">
              <div id="usuarios" class="row d-flex align-items-stretch">
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

?>

<script src="../js/Gestion_usuario.js"></script>
