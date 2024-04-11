<?php
require_once "config/config.php";

/// VALIDACIONES ///
//Conexion a BD
function conect()
{
  $mysql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $mysql->set_charset(DB_CHARSET);
  if (mysqli_connect_errno()) {
    echo "Error en la conexion: " . mysqli_connect_errno();
  }
  return $mysql;
}

$mysql = conect(); //Variable que nos conecta

//// Crear usuarios con contraseñas hasheadas //////
// $usuario = "maciel";
// $contraseña = "123456"; usuario 1
// $usuario = "daiana";
// $contraseña = "654321"; //usuario 2
// // $usuario = "nicolas";
// // $contraseña = "admin123"; //usuario sigmarroller

// $contraHash = password_hash($contraseña, PASSWORD_BCRYPT);
// $queryInsertar = "INSERT INTO usuarios(usuario, contraseña) VALUES ('{$usuario}','{$contraHash}' );";
// mysqli_query($mysql,$queryInsertar);
///// Fin crear Usuario ////////
$errores = []; //Array de posibles errores

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Metodo de envio de datos

  $usuario = mysqli_real_escape_string($mysql, $_POST['usuario']);
  $contraseña = mysqli_real_escape_string($mysql, $_POST['contraseña']);

  if (!$usuario) {
    $errores[] = "Usuario obligatorio o no valido.";
  }

  if (!$contraseña) {
    $errores[] = "Contraseña obligatoria.";
  }

  if (empty($errores)) {
    
    $query = "SELECT * FROM usuarios WHERE usuario = '{$usuario}'";
    $resultado = mysqli_query($mysql, $query);

    if ($resultado->num_rows) {
      //Revisar si la contraseña es correcta
      $user = mysqli_fetch_assoc($resultado);

      $auth = password_verify($contraseña, $user['contraseña']); // Funcion de php para verificar la coincidencia de contraseñas (bool)

      if ($auth) {
        // EL usuario y contraseña son correctos
        //Iniciamos sesion y usamos la superglobal SESSION
        session_start();

        //en la superglobal llenaremos un array con la info que deseamos guardar de la sesion
        //como por ej: para verificar el logeo y restringuir accesos
        $_SESSION['idUsuario'] = $user['idUsuarios'];
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['tipoUsuario'] = $user['tipoUsuario'];
        $_SESSION['inicioSesion'] = date('d-m-Y H:i:s');
        if($user['tipoUsuario'] == "administrador"){
          $_SESSION['acceso'] = true;
        }elseif($user['tipoUsuario'] == "cliente"){
          $_SESSION['acceso'] = true;
          $idUsuario = $_SESSION['idUsuario'];

          $query = "SELECT nombreCliente FROM cliente WHERE idUsuarios = '{$idUsuario}'";
          $resultado = mysqli_query($mysql, $query);

          if ($resultado->num_rows) {
            //Revisar si la contraseña es correcta
            $cliente = mysqli_fetch_assoc($resultado);
            $_SESSION['nombreCliente'] = $cliente['nombreCliente'];
            // var_dump($cliente);
            // exit;
          }
        }
        // Establecer tiempo de vida de la sesión (opcional)
        $lifetime = 60; // Duración en segundos (1 hora)
        ini_set('session.gc_maxlifetime', $lifetime);
        ini_set('session.cookie_lifetime', $lifetime);


        //header('Location: /views/legajos/main.php');
        // Servidor
        header('Location: '.$baseUrl.'/views/legajos/main.php');

      } else {
        $errores[] = "La contraseña es incorrecta.";
      }
    } else {
      $errores[] = "El usuario no existe.";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>APP Sigmaroller</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo $baseUrl; ?>/assets/img/logoSigmaroller.jpg" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo $baseUrl; ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo $baseUrl; ?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo $baseUrl; ?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo $baseUrl; ?>/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?php echo $baseUrl; ?>/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?php echo $baseUrl; ?>/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo $baseUrl; ?>/assets/vendor/simple-datatables/style.css" rel="stylesheet">


  <!-- CSS File -->
  <link href="<?php echo $baseUrl; ?>/assets/css/style.css" rel="stylesheet">

</head>

<body>

  <?php
  require "views/template/login.php";
  ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo $baseUrl; ?>/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/php-email-form/validate.js"></script>


  <!-- Main JS File -->
  <script src="<?php echo $baseUrl; ?>/assets/js/main.js"></script>

</body>

</html>