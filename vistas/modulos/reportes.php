<?php
if ($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor") {
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Reportes de ventas</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Reportes de ventas</li>
    </ol>
  </section>
  <section class="content">


    <div class="box">

      <!--primer header-->
      <div class="row">
        <div class="col-md-6 col-xs-12">
          <div class="box-header with-border">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title"><strong>Lista de ventas por Vendedor</strong></h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6 col-xs-12">
                    <div class="form-group">

                      <div class="input-group">

                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <select class="form-control input-md" id="idCliente" name="idCliente" onchange="ShowSelected(this);" required>

                          

                          <?php

                          $item = null;
                          $valor = null;

                          $vendedor = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

                          foreach ($vendedor as $key => $value) {

                            echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';
                          }

                          ?>

                        </select>

                      </div>

                    </div>
                  </div>

                  <div class="col-md-4 col-xs-12">


                    <?php

                    if (isset($_GET["vendedor"])) {
                      echo '<a href="vistas/modulos/descargar-reporte-vendedor.php?vendedor=' . $_GET["vendedor"] . '">';
                    } else {
                      echo '<a href="vistas/modulos/descargar-reporte-vendedor.php?vendedor=vendedor">';
                    }
                    ?>
                    <button class="btn btn-success btnMostrar" id="btnMostrar" >Descargar reporte en Excel</button>
                    </a>

                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- final header-->


      <div class="box-header with-border">
        <div class="input-group">
          <button type="button" class="btn btn-default" id="daterange-btn2">
            <span>
              <i class="fa fa-calendar"></i>
              <?php
              if (isset($_GET["fechaInicial"])) {
                echo $_GET["fechaInicial"] . " - " . $_GET["fechaFinal"];
              } else {
                echo 'Rango de fecha';
              }
              ?>
            </span>
            <i class="fa fa-caret-down"></i>
          </button>
        </div>
        <div class="box-tools pull-right">
          <?php

          if (isset($_GET["fechaInicial"])) {
            echo '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte&fechaInicial=' . $_GET["fechaInicial"] . '&fechaFinal=' . $_GET["fechaFinal"] . '">';
          } else {
            echo '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte">';
          }
          ?>
          <button class="btn btn-success" style="margin-top:5px">Descargar reporte en Excel</button>
          </a>
        </div>

      </div>
      <!-- Aqui empezamos a mostrar el grafico de ventas -->
      <div class="box-body">
        <div class="row">
          <div class="col-xs-12">
            <?php
            include "reportes/grafico-ventas.php";
            ?>
          </div>

          <div class="col-md-6 col-xs-12">

            <?php

            include "reportes/productos-mas-vendidos.php";

            ?>

          </div>

          <div class="col-md-6 col-xs-12">

            <?php

            include "reportes/vendedores.php";

            ?>

          </div>

          <div class="col-md-6 col-xs-12">

            <?php

            include "reportes/compradores.php";

            ?>

          </div>
        </div>


      </div>



    </div>
  </section>
</div>