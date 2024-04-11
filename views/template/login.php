<main class="fondo">
  <div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container ">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">



            <div class="card mb-3">

              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Inicia sesión</h5>
                  <p class="text-center small">Ingresa tu usuario y contraseña</p>
                </div>
                <!-- Para mostrar errores de login -->
                <?php foreach ($errores as $error) : ?>
                  <div class="alert-sm mb-3 p-2 alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                  <?php echo $error; ?>
                  </div>
                <?php endforeach; ?>

                <form class="row g-3" method="POST">

                  <div class="col-12">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="usuario" class="form-control" id="usuario">
                  </div>

                  <div class="col-12">
                    <label for="contraseña" class="form-label">Contraseña</label>
                    <input type="password" name="contraseña" class="form-control" id="contraseña">
                  </div>

                  <div class="col-12">
                    <div class="form-check">


                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn  w-100 btn_ingresa" type="submit">Iniciar Sesion</button>
                  </div>
                  <div class="col-12">

                  </div>
                </form>

              </div>
            </div>

            <div class="credits credits_loguin"> Diseñado por SGF Devs. </div>

          </div>
        </div>
      </div>

    </section>

  </div>
</main><!-- End #main -->