<?php

if (!isset($_SESSION)) {
  session_start();
}
//Obtengo los datos de la sesion
$nombre = $_SESSION['usuario'];
$nombre = ucfirst($nombre);
$tipoUsuario = $_SESSION['tipoUsuario'];
$tipoUsuario = ucfirst($tipoUsuario);

require "../template/head.php";

?>

<body>

  <?php
  require "../template/header.php";
  ?>


  <!-- Main -->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Clientes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= $baseUrl; ?>/views/legajos/ver-todos.php">Clientes</a></li>
          <li class="breadcrumb-item active">Nuevo Cliente</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <!-- Section Menu Principal -->
    <section id="seccion2" class="section dashboard">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Nuevo Cliente</h5>

              <!-- Formulario con Validacion -->
              <form class="row g-3" id="frmNuevoLegajo">
                <fieldset>
                  <h5>Datos Personales:</h5>

                  <div class="row">
                    <div class="col-md-4">
                      <label for="txtNombre" class="form-label">Nombre Cliente:</label>
                      <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre" required>
                    </div>

                    <div class="col-md-4">
                      <label for="txtApellido" class="form-label">Razon Social:</label>
                      <input type="text" class="form-control" id="txtApellido" name="txtApellido" placeholder="Razon Social" required>
                    </div>

                    <div class="col-md-4">
                      <label for="numCuil" class="form-label">Nro de CUIT:</label>
                      <input type="number" class="form-control" id="numCuil" name="numCuil" min="1" pattern="^[0-9]+" placeholder="Numero de CUIT">
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-4">
                      <label for="emailEmail" class="form-label">Email: </label>
                      <input type="email" class="form-control" name="emailEmail" id="emailEmail" placeholder="Email" required>
                    </div>

                    <div class="col-md-4">
                      <label for="numTelefono" class="form-label">Nro de Telefono:</label>
                      <input type="number" class="form-control" id="numTelefono" name="numTelefono" placeholder="Numero de telefono" required>
                    </div>

                    <div class="col-md-4">
                      <label for="txtDomicilio" class="form-label">Domicilio:</label>
                      <input type="text" class="form-control" id="txtDomicilio" name="txtDomicilio" placeholder="Domicilio" required>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-4">
                      <label class="form-label">Domicilio de Entrega:</label>
                      <input type="text" class="form-control" id="txtLocalidad" name="txtLocalidad" placeholder="Domicilio de Entrega" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Localidad:</label>
                      <input type="text" class="form-control" id="txtLocalidadEntrega" name="txtLocalidadEntrega" placeholder="Localidad" required>
                    </div>
                  </div>

                </fieldset>

                <fieldset>
                  <h5 class="mt-4">Datos de la Cuenta:</h5>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="txtUsuario" class="form-label">Usuario:</label>
                      <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="Usuario" required>
                    </div>

                    <div class="col-md-4">
                      <label for="contraseña" class="form-label">Contraseña:</label>
                      <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label" for="selEstado">Estado Actual:</label>
                      <div>
                        <select class="form-select" id="selEstado" name="selEstado" aria-label="Default select example" required>
                          <option value="Al Dia">Al día</option>
                          <option value="Suspendido">Suspendido</option>
                          <option value="Moroso">Moroso</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col mt-3" id="comentarios">
                    <label for="observaciones">Notas Facturación:</label>
                    <textarea class="form-control" placeholder="Escribe tu observación aqui" id="txtAreaObservaciones" name="txtAreaObservaciones" style="height: 80px"></textarea>
                  </div>
                </fieldset>

                <div class="text-center">
                  <button type="submit" class="btn btn-success">GUARDAR</button>
                  <button type="reset" class="btn btn-danger style" onclick="fntCancelarNuevoLeg()">CANCELAR</button>
                </div>
              </form><!-- Fin Form -->

            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- Fin main -->
  <?php
  require "../template/footer.php";
  ?>
  <script src="../template/js/functions-legajos.js"></script>