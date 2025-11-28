
<?php
session_start();
if ($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] ==3){
    

    
    $ruta_imagen = '../img/avatar04.png';
    echo "<!-- DEBUG: Verificando imagen: " . $ruta_imagen . " -->";
    echo "<!-- Existe: " . (file_exists($ruta_imagen) ? 'SI' : 'NO') . " -->";
    echo "<!-- Ruta absoluta: " . realpath($ruta_imagen) . " -->";
    
    include_once 'layouts/header.php';
?>
  <title>Farmacia | Editar datos personales</title>
<?php
    include_once 'layouts/nav.php';
?>

<!-- Modal Cambiar Contraseña -->
<div class="modal fade" id="cambiocontra" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar password</h1>
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
        <div id="update" class="alert alert-success text-center" style="display:none;">
          <span><i class="fas fa-check m-1"></i>Se cambió password correctamente</span>
        </div>
        <div id="noupdate" class="alert alert-danger text-center" style="display:none;">
          <span><i class="fas fa-times m-1"></i>El password no es correcto</span>
        </div>
        <form id="form-pass"> 
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
            </div>
            <input id="oldpass" type="password" class="form-control" placeholder="Ingrese password actual" required>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input id="newpass" type="password" class="form-control" placeholder="Ingrese password nueva" required>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" form="form-pass" class="btn bg-gradient-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Cambiar Avatar -->
<div class="modal fade" id="cambiophoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambiar avatar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img id="avatar1" src="../img/avatar04.png" class="profile-user-img img-fluid img-circle">
        </div>
        <div class="text-center mt-2">
          <b><?php echo $_SESSION['nombre_us']; ?></b>
        </div>
        <div id="edit" class="alert alert-success text-center" style="display:none;">
          <span><i class="fas fa-check m-1"></i>Se cambió el avatar</span>
        </div>
        <div id="noedit" class="alert alert-danger text-center" style="display:none;">
          <span><i class="fas fa-times m-1"></i>Formato no soportado</span>
        </div>
        <form id="form-photo" enctype="multipart/form-data"> 
          <div class="form-group mt-3">
            <input type="file" id="photo" name="photo" class="form-control-file" accept="image/*" required>
          </div>
          <input type="hidden" name="funcion" value="cambiar_foto">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" form="form-photo" class="btn btn-primary">Guardar</button>
        
      </div>
    </div>
  </div>
</div>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Editar Datos Personales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Datos personales</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Perfil izquierdo -->
          <div class="col-md-3">
            <div class="card card-success card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img id="avatar2" src="../img/avatar04.png" class="profile-user-img img-fluid img-circle" alt="User Image">
                </div>
                <div class="text-center mt-1">
                  <button type="button" data-toggle="modal" data-target="#cambiophoto" class="btn btn-primary btn-sm">Cambiar avatar</button>
                </div>
                <input id="id_usuario" type="hidden" value="<?php echo $_SESSION['usuario']; ?>">
                <h3 id="nombre_us" class="profile-username text-center text-success">Nombre</h3>
                <p id="apellidos_us" class="text-muted text-center">Apellidos</p>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b style="color:#0B7300">Edad</b> <a id="edad" class="float-right">12</a>
                  </li>
                  <li class="list-group-item">
                    <b style="color:#0B7300">Codigo</b> <a id="dni_us" class="float-right">12</a>
                  </li>
                  <li class="list-group-item">
                    <b style="color:#0B7300">Tipo de usuario</b>
                    <span class="float-right badge badge-primary">Administrador</span>
                  </li>
                  <button data-toggle="modal" data-target="#cambiocontra" type="button" class="btn btn-block btn-outline-warning btn-sm">Cambiar password</button>
                </ul>
              </div>
            </div>

            <div class="card card-success">
              <div class="card-header" style="background-color:#0B7300; color:#fff;">
                <h3 class="card-title">Sobre mi</h3>
              </div>
              <div class="card-body">
                <strong style="color:#0B7300">
                  <i class="fas fa-phone mr-1"></i> Telefono
                </strong>
                <p id="telefono_us" class="text-muted">123456789</p>
                <strong style="color:#0B7300">
                  <i class="fas fa-map-marker-alt mr-1"></i> Residencia
                </strong>
                <p id="residencia_us" class="text-muted">bello horizonte</p>
                <strong style="color:#0B7300">
                  <i class="fas fa-at mr-1"></i> Correo
                </strong>
                <p id="correo_us" class="text-muted">Ejemplo123@gmail.com</p>
                <strong style="color:#0B7300">
                  <i class="fas fa-smile-wink mr-1"></i> Sexo
                </strong>
                <p id="sexo_us" class="text-muted">424534543</p>
                <strong style="color:#0B7300">
                  <i class="fas fa-info-circle mr-1"></i> Informacion adicional
                </strong>
                <p id="adicional_us" class="text-muted">424534543</p>
                <button class="edit btn btn-block bg-gradient-danger">Editar</button>
              </div>
              <div class="card-footer">
                <p class="text-muted">Click en el boton si desea editar</p>
              </div>
            </div>
          </div>

          <!-- Formulario derecho -->
          <div class="col-md-9">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Editar datos personales</h3>
              </div>
              <div class="card-body">
                <div id="status" class="alert alert-success text-center" style="display:none;">
                  <span><i class="fas fa-check m-1"></i>Editado</span>
                </div>
                <div id="noeditado" class="alert alert-danger text-center" style="display:none;">
                  <span><i class="fas fa-times m-1"></i>Edicion Deshabilitada</span>
                </div>
                <form id="form-usuario" class="form-horizontal">
                  <div class="form-group row">
                    <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                    <div class="col-sm-10">
                      <input type="number" id="telefono" class="form-control" placeholder="Ingrese telefono">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="residencia" class="col-sm-2 col-form-label">Residencia</label>
                    <div class="col-sm-10">
                      <input type="text" id="residencia" class="form-control" placeholder="Ingrese su Residencia">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="correo" class="col-sm-2 col-form-label">Correo</label>
                    <div class="col-sm-10">
                      <input type="email" id="correo" class="form-control" placeholder="Ingrese su Correo">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="sexo" class="col-sm-2 col-form-label">Sexo</label>
                    <div class="col-sm-10">
                      <input type="text" id="sexo" class="form-control" placeholder="Ingrese su genero">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="adicional" class="col-sm-2 col-form-label">Informacion Adicional</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" id="adicional" cols="30" rows="10"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10 float-right">
                      <button type="submit" class="btn btn-block btn-outline-success">Guardar</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer">
                <p class="text-muted">Cuidado con ingresar datos erroneos</p>
              </div>
            </div>
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

<script src="../js/Usuario.js"></script>