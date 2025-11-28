<?php
session_start();
if($_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 3){  
    include_once 'layouts/header.php';
?>

  <title>Adm | Atributo</title>
<?php
    include_once 'layouts/nav.php';
?>

<div class="modal fade" id="crearpresentacion" tabindex="-1" role="dialog" aria-labelledby="exampleModal" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Crear presentación</h3> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-crear-presentacion">       
                    <div class="card-body">
                        <div class="alert alert-success text-center" id="add-pre" style="display:none;">
                            <span><i class="fas fa-check m-1"></i>Se agregó correctamente</span>
                        </div>
                        <div class="alert alert-danger text-center" id="noadd-pre" style="display:none;">
                            <span><i class="fas fa-times m-1"></i>La presentación ya existe</span>
                        </div>
                        <div class="alert alert-success text-center" id="edit-pre" style="display:none;">
                            <span><i class="fas fa-check m-1"></i>Se editó correctamente</span>
                        </div>

                        <div class="form-group">
                             <label for="nombre-presentacion">Nombre</label>
                             <input type="hidden" id="id_editar_presentacion">
                             <input type="text" class="form-control" id="nombre-presentacion" placeholder="ingrese nombre" required>
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





<div class="modal fade" id="creartipo" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Crear tipo</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="card-body">
          
          <div class="alert alert-success text-center" id="add-tipo" style="display:none;">
            <span><i class="fas fa-check m-1"></i>Se agregó correctamente</span>
          </div>
          <div class="alert alert-danger text-center" id="noadd-tipo" style="display:none;">
            <span><i class="fas fa-times m-1"></i>El tipo ya existe</span>
          </div>
          <div class="alert alert-success text-center" id="edit-tipo" style="display:none;">
            <span><i class="fas fa-check m-1"></i>Se editó correctamente</span>
          </div>

          <form id="form-crear-tipo">
            <div class="form-group">
              <label for="nombre-tipo">Nombre</label>
              
              <input type="hidden" id="id_editar_tipo">
              
              <input type="text" class="form-control" id="nombre-tipo" placeholder="Ingrese nombre" required>
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
</div>

<div class="modal fade" id="cambiologo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambiar logo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img id="logoactual" src="../img/lab/lab_default.png" class="profile-user-img img-fluid img-circle">
        </div>
        <div class="text-center mt-2">
          <b id="nombre_logo"></b>
        </div>
        <div id="edit" class="alert alert-success text-center" style="display:none;">
          <span><i class="fas fa-check m-1"></i>Se cambió el logo</span>
        </div>
        <div id="noedit" class="alert alert-danger text-center" style="display:none;">
          <span><i class="fas fa-times m-1"></i>Formato no soportado</span>
        </div>
        
        <form id="form-logo" enctype="multipart/form-data"> 
          <div class="form-group mt-3">
            <input type="file" name="photo" class="form-control-file" accept="image/*" required>
          </div>
          <input type="hidden" name="funcion" id="funcion">
          <input type="hidden" name="id_logo_lab" id="id_logo_lab">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" form="form-logo" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="crearlaboratorio" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Crear laboratorio</h3> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-crear-laboratorio">
                    <div class="card-body">
                        <div class="alert alert-success text-center" id="add-laboratorio" style="display:none;">
                            <span><i class="fas fa-check m-1"></i>Se agregó correctamente</span>
                        </div>
                        <div class="alert alert-danger text-center" id="noadd-laboratorio" style="display:none;">
                            <span><i class="fas fa-times m-1"></i>El laboratorio ya existe</span>
                        </div>
                        <div class="alert alert-success text-center" id="edit-lab" style="display:none;">
                            <span><i class="fas fa-check m-1"></i>Se edito correctamente</span>
                        </div>
                        <div class="form-group">
                             <label for="nombre_laboratorio">Nombre</label>
                             <input type="hidden" id="id_editar_lab">   
                             <input type="text" class="form-control" id="nombre_laboratorio" placeholder="ingrese nombre" required>
                        </div>      
                              

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-primary float-right">Guardar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right mr-2">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="crearpresentacion" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Crear presentacion</h3> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-crear-presentacion">       
                    <div class="card-body">
                        <div class="form-group">
                             <label for="nombre-presentacion">Nombre</label>
                             <input type="text" class="form-control" id="nombre-presentacion" placeholder="ingrese nombre" required>
                        </div>        
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-primary float-right">Crear</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right mr-2">Close</button>
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
            <h1>Gestion atributos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Gestion atributos</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a href="#laboratorio" class="nav-link active" data-toggle="tab">Laboratorio</a></li>
                            <li class="nav-item"><a href="#tipo" class="nav-link" data-toggle="tab">Tipo</a></li>
                            <li class="nav-item"><a href="#presentacion" class="nav-link" data-toggle="tab">Presentacion</a></li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="tab-content">
                            
                            <div class="tab-pane active" id='laboratorio'>
                                <div class="card card-success">
                                    <div class="card-header">
                                        <div class="card-title">Buscar laboratorio <button type="button" data-toggle="modal" data-target="#crearlaboratorio" class="btn bg-gradient-primary btn-sm m-2">Crear Laboratorio</button></div>
                                        <div class="input-group">
                                            <input id="buscar_laboratorio" type="text" class="form-control float-left" placeholder="ingrese nombre">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 table-responsive">
                                        <table class="table table-hover text-nowrap">
                                            <thead class="table-success">
                                                <tr>
                                                    <th>Laboratorio</th>
                                                    <th>Logo</th>
                                                    <th>Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-active" id="laboratorios">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>

                            <div class="tab-pane" id='tipo'>
                                <div class="card card-success">
                                    <div class="card-header">
                                        <div class="card-title">Buscar tipo <button type="button" data-toggle="modal" data-target="#creartipo" class="btn bg-gradient-primary btn-sm m-2">Crear tipo</button></div>
                                        <div class="input-group">
                                            <input id="buscar_tipo" type="text" class="form-control float-left" placeholder="ingrese nombre">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 table-responsive">
                                        <table class="table table-hover text-nowrap">
                                            <thead class="table-success">
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-active" id="tipos">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">


                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id='presentacion'>
                                <div class="card card-success">
                                    <div class="card-header">
                                        <div class="card-title">Buscar presentacion <button type="button" data-toggle="modal" data-target="#crearpresentacion" class="btn bg-gradient-primary btn-sm m-2">Crear presentacion</button></div>
                                        <div class="input-group">
                                            <input id="buscar_presentacion" type="text" class="form-control float-left" placeholder="ingrese nombre">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 table-responsive">
                                        <table class="table table-hover text-nowrap">
                                            <thead class="table-success">
                                                <tr>
                                                    <th>Presentación</th>
                                                    <th>Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-active" id="presentaciones">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
      </div>
    </section>
  </div>

<?php
    include_once 'layouts/footer.php';  
}
else{
    header('location: ../index.php');
}
?>
<script src="../js/Presentacion.js"></script>
<script src="../js/Laboratorio.js"></script>
<script src="../js/Tipo.js"></script>