<?php
session_start([
'cookie_lifetime' => 86400, // Con cookie_lifetime se usa para indicar la vida de la cookie.
'gc_maxlifetime' => 86400, // Con gc_maxlifetime se refiere al tiempo de limpieza en el servidor
]);
//'cookie_lifetime' => 86400, // Con cookie_lifetime se usa para indicar la vida de la cookie.
//'gc_maxlifetime' => 86400, // Con gc_maxlifetime se refiere al tiempo de limpieza en el servidor
//Asi se utiliza
//session_start([
//    'cookie_lifetime' => 86400,
//    'gc_maxlifetime' => 86400,
//]);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SisVent V1.0</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!--=====================================
  PLUGINS DE CSS
  ======================================-->
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="vistas/bower_components/select2/dist/css/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- DataTables -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"> -->
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="vistas/plugins/iCheck/all.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css">
  <!--=====================================
  PLUGINS DE JAVASCRIPT
  ======================================-->
  <!-- jQuery 3 -->
  <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Select2 -->
 <script src="vistas/bower_components/select2/dist/js/select2.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="vistas/dist/js/adminlte.min.js"></script>
  <!-- DataTables -->
  <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
  <!-- SweetAlert 2 -->
  <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
  <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- iCheck 1.0.1 -->
  <script src="vistas/plugins/iCheck/icheck.min.js"></script>
  <!-- InputMask -->
  <script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <!-- jQuery Number -->
  <script src="vistas/plugins/jqueryNumber/jquerynumber.min.js"></script>
  <!-- daterangepicker http://www.daterangepicker.com/-->
  <script src="vistas/bower_components/moment/min/moment.min.js"></script>
  <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
  <script src="vistas/bower_components/raphael/raphael.min.js"></script>
  <script src="vistas/bower_components/morris.js/morris.min.js"></script>
  <!-- ChartJS http://www.chartjs.org/-->
  <script src="vistas/bower_components/chart.js/Chart.js"></script>

</head>
<!--================= 
  CUERPO DOCUMENTO 
  =====================================-->
<!-- <body class="hold-transition skin-green sidebar-collapse sidebar-mini login-page"> -->
<body class="hold-transition skin-green sidebar-mini login-page">
  
  <?php
  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
    echo '<div class="wrapper">';
    /*====================== CABEZOTE ==========================*/
    include "modulos/cabezote.php";
    /*=================== MENU =============================================*/
    include "modulos/menu.php";
    /*=============================== CONTENIDO =============================================*/

    if (isset($_GET["ruta"])) {

      if (
        $_GET["ruta"] == "inicio" ||
        $_GET["ruta"] == "usuarios" ||
        $_GET["ruta"] == "categorias" ||
        $_GET["ruta"] == "productos" ||
        $_GET["ruta"] == "productos-sucursal" ||
        $_GET["ruta"] == "clientes" ||
        $_GET["ruta"] == "proveedores" ||
        $_GET["ruta"] == "ventas" ||
        $_GET["ruta"] == "editar-venta" ||
        $_GET["ruta"] == "editar-compra" ||
        $_GET["ruta"] == "crear-venta" ||
        $_GET["ruta"] == "transferencia" ||
         $_GET["ruta"] == "listado-transferencias" ||
        $_GET["ruta"] == "nota-venta" ||
        //Esta Vista es para el Administrador del Sistema
        $_GET["ruta"] == "caja" ||
        //Esta Caja es con filtro para cada Usuario Vendedor
         $_GET["ruta"] == "cajas" ||
        $_GET["ruta"] == "reportes" ||
        $_GET["ruta"] == "compras" ||
        $_GET["ruta"] == "usuarios-compras" ||
        $_GET["ruta"] == "editar-compra" ||
        $_GET["ruta"] == "crear-compra" ||
        $_GET["ruta"] == "nueva-sucursal" ||
        $_GET["ruta"] == "reporte-compras" ||
        // $_GET["ruta"] == "ayuda" ||
        // $_GET["ruta"] == "acerca" ||
        $_GET["ruta"] == "salir"
      ) {

        include "modulos/" . $_GET["ruta"] . ".php";
      } else {

        include "modulos/404.php";
      }
    } else {
      include "modulos/inicio.php";
    }
    /*======================================= FOOTER =============================================*/
    include "modulos/footer.php";
    echo '</div>';
  } else {
    include "modulos/login.php";
  }
  ?>

  <script src="vistas/js/plantilla.js"></script>
  <script src="vistas/js/usuarios.js"></script>
  <script src="vistas/js/categorias.js"></script>
  <script src="vistas/js/productos.js"></script>
  <script src="vistas/js/productos_sucursal.js"></script>
  <script src="vistas/js/clientes.js"></script>
  <script src="vistas/js/proveedores.js"></script>
 <!--  <script src="vistas/js/ventas.js"></script> -->
  <script src="vistas/js/reportes.js"></script>
  <script src="vistas/js/compras.js"></script>
  <script src="vistas/js/ventas2.js"></script>
 <script src="vistas/js/compras2.js"></script>
 <script src="vistas/js/validafolio.js"></script>
  <!-- Aqui vamos para la Sucursal -->
  <script src="vistas/js/sucursal.js"></script>
  <script src="vistas/js/transferencia.js"></script>
  <script src="vistas/js/consultas.js"></script>
  <!-- <script src="vistas/js/reportes-compras.js"></script> -->

</body>

</html>