<div class="content-wrapper">
  <section class="content-header">
    <h1><strong>Listado de Transferencias : Consulta realizada por : <?php  echo $_SESSION["nombre"]; ?></strong> </h1> 
  </section>

  <section class="content">
    
    <div class="box-header with-border">
      <a href="transferencia">
        <button class="btn btn-primary">Nueva Transferencia</button>
      </a>
      <!-- <button type="button" class="btn btn-default pull-right" id="daterange-btn">
            <span><i class="fa fa-calendar"></i> Rango de fecha</span><i class="fa fa-caret-down"></i>
         </button> -->
    </div>

      <!-- Aqui empezamos a  mostrar la tabla de transferencias -->
      <div class="box-body">
      <table class="table table-bordered table-striped dt-responsive tablas text-center" width="100%">

        <thead>
          <tr>
            <th style="width:10px">#</th>

            <th>Registra</th>
            <th>Cantidad</th>
            <th>Producto</th>
            <th>Destino</th>
            <th>Comprobante</th>
            <th>Fecha_Transferencia</th>

          </tr>
        </thead>

        <tbody>
          <?php

          $item = null;
          $valor = null;
          $idUsuario = null;
          $respuesta = ControladorTransferencia::ctrMostrarTransferencias($item, $valor, $idUsuario);

          foreach ($respuesta as $key => $value) {
            echo '<tr>

            <td>' . ($key + 1) . '</td>';


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
            echo'<td>' . $value["destino"] . '</td>
            <td>' . $value["comprobante"] . '</td>
            <td>' . date('d/m/Y',strtotime($value["fecha"])) . '</td>

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