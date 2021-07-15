<?php
if($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor"){
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
      <div class="box-header with-border">
        <div class="input-group">
          <button type="button" class="btn btn-default" id="daterange-btn2">
            <span>
              <i class="fa fa-calendar"></i> 
              <?php
                if(isset($_GET["fechaInicial"])){
                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                }else{
                  echo 'Rango de fecha';
                }
              ?>
            </span>
            <i class="fa fa-caret-down"></i>
          </button>
        </div>
        <div class="box-tools pull-right">
        <?php

        if(isset($_GET["fechaInicial"])){
          echo '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'">';
        }else{
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
        </div>
      </div>
      <!-- Aqui termina el codigo para mostrar el grafico de ventas -->

      <!-- Aqui empezamos a  mostrar la tabla de ventas -->
      <div class="box-body">
      <table class="table table-bordered table-striped dt-responsive tablas text-center" width="100%">

        <thead>
          <tr>
            <th style="width:10px">#</th>
            <!--   <th>Codigo</th> -->
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Cantidad</th>
            <th>Producto</th>
            <th>Precio_Unidad</th>
            <th>TotalXProducto</th>
            <th>Forma_Pago</th>
            <th>Comprobante</th>
            <th>Precio_Neto</th>
            <th>Costo_Total</th>
            <th>Fecha</th>
            <th>Acciones</th>

          </tr>
        </thead>

        <tbody>
          <?php

          $item = null;
          $valor = null;
          $idUsuario = null;
          $respuesta = ControladorVentas::ctrMostrarVentas($item, $valor, $idUsuario);

          foreach ($respuesta as $key => $value) {
            echo '<tr>

                  <td>' . ($key + 1) . '</td>';

            $itemCliente = "id";
            $valorCliente = $value["id_cliente"];
            $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
            echo '<td>' . $respuestaCliente["nombre"] . '</td>';

            $itemUsuario = "id";
            $valorUsuario = $value["id_vendedor"];
            $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
            echo '<td>' . $respuestaUsuario["nombre"] . '</td><td>';


            $productos =  json_decode($value["productos"], true);
            foreach ($productos as $key => $valueProductos) {
              echo ($valueProductos["cantidad"] . '<br>');
            }

            echo '</td><td>';
            $productos = json_decode($value["productos"], true);
            foreach ($productos as $key2 => $value2) {
              echo $value2["descripcion"] . '<br>';
            }
            echo '</td>';

            echo '</td><td>';
            $productos = json_decode($value["productos"], true);
            foreach ($productos as $key2 => $value2) {
              echo "S/ " . number_format($value2["precio"], 2) . "<br>";
            }
            echo '</td>';

            echo '</td><td>';
            $productos = json_decode($value["productos"], true);
            foreach ($productos as $key2 => $value2) {
              echo "S/ " . number_format($value2["total"], 2) . "<br>";
            }
            echo '</td>';

            echo '</td><td>' . $value["metodo_pago"] . '</td></td>';

            $itemComp = "id";
            $valorComp = $value["id_comprobante"];
            $respuestaComp = ControladorComprobante::ctrMostraTipo($itemComp, $valorComp);
            echo '<td>' . $respuestaComp["comprobante"] . '</td>';


            echo '</td><td>S/ ' . number_format($value["neto"], 2) . '</td>
                  <td>S/ ' . number_format($value["total"], 2) . '</td>
                  <td>' . $value["fecha"] . '</td>
                  <td>

                     <div class="btn-group">
                          <button class="btn btn-success btnImprimirFactura" codigoVenta="' . $value["codigo"] . '">
                            <i class="fa fa-print"></i>

                          </button>';
            if ($_SESSION["perfil"] == "Administrador") {

              echo '<button class="btn btn-warning btnEditarVenta" idVenta="' . $value["id"] . '"><i class="fa fa-pencil"></i></button>
                      
              <button class="btn btn-danger btnEliminarVenta" idVenta="'.$value["id"].'"><i class="fa fa-times"></i></button>';

            }
            echo '</div>  
                      </td>
                    </tr>';
          }
          ?>
        </tbody>
        <input type="hidden" value="<?php echo $_SESSION['id']; ?>" id="idUsuario">
      </table>
    </div>
    <!-- Aqui termina la tabla de ventas -->
</div>
</section>
</div>