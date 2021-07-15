<div class="content-wrapper">
  <section class="content-header">
    <h1><strong>Listado de Ventas Totales</strong> </h1>
  </section>

  <section class="content">
    <div class="box-header with-border">
      <a href="crear-venta">
        <button class="btn btn-primary">Agregar venta</button>
      </a>
      <!-- <button type="button" class="btn btn-default pull-right" id="daterange-btn">
            <span><i class="fa fa-calendar"></i> Rango de fecha</span><i class="fa fa-caret-down"></i>
         </button> -->
    </div>


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

            echo '</td><td>S/ ' . number_format($value["neto"], 2) . '</td>
                  <td>S/ ' . number_format($value["total"], 2) . '</td>
                  <td>' . $value["fecha"] . '</td>
                  <td>

                     <div class="btn-group">
                          <button class="btn btn-success btnImprimirFactura" codigoVenta="' . $value["codigo"] . '">
                            <i class="fa fa-print"></i>

                          </button>';
            if ($_SESSION["perfil"] == "Administrador") {

              echo '<button class="btn btn-warning btnEditarVenta" idVenta="' . $value["id"] . '"><i class="fa fa-pencil"></i></button>';
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
</div>
</section>
</div>