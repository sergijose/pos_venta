<!--
<?php
if ($_SESSION["perfil"] != "Administrador") {
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>
--->

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <span><i class="glyphicon glyphicon-eye-open"></i></span>
      Modulo de Gastos internos
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Administrar de Gastos</li>
    </ol>
  </section>
  <section class="content">

    <div class="box box-success">
      <div class="box-header with-border">
        <button class="btn btn-flat btn-default" data-toggle="modal" data-target="#modalAgregarGasto"> Agregar Gasto</button>
      </div>
      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaGastos text-center" width="100%">

          <thead>
            <tr>

              <th style="width:10px">#</th>

              <th>Usuario</th>
              <th>Destino</th>
              <th>Descripción</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Fecha</th>
              <!--  <th>Acciones</th>-->

            </tr>
          </thead>
          <tbody>
            <?php
            $item = null;
            $valor = null;
            $gastos = ControladorGastos::ctrMostrarGastos($item, $valor);

         
            foreach ($gastos as $key => $value) {
              echo ' <tr>
                     <td>' . ($key + 1) . '</td>';           
                     $itemUsuario = "id";
                     $valorUsuario = $value["id_usuario"];
                     $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);       
                  echo  '<td>' .$respuestaUsuario["nombre"] . '</td>
                      <td>' . $value["destino"] . '</td>
                      <td>' . $value["descripcion"] . '</td>
                      <td>' . $value["cantidad"] . '</td>
                      <td>' . $value["precio"] . '</td>
                      <td>' . $value["fecha"] . '</td>
                  

                  </tr>';
            }
            ?>


          </tbody>

        </table>
        <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">
        <!-- <input type="hidden" value="<?php echo $_SESSION['idSucursal']; ?>" id="sucursalOculta"> -->

      </div>
    </div>
  </section>
</div>







<!--=====================================
  MODAL AGREGAR PRODUCTO
  ======================================-->
<div id="modalAgregarGasto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
    CABEZA DEL MODAL
    ======================================-->
        <div class="modal-header" style="background:#00a65a; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registro de Gastos</h4>
        </div>
        <!--=====================================
  CUERPO DEL MODAL
  ======================================-->
        <div class="modal-body">
          <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                <!-- ENTRADA DEL VENDEDOR -->
                <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">

                <!-- ENTRADA PARA SELECCIONAR EL DESTINO DEL GASTO -->
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select class="form-control input-lg" id="nuevoDestino" name="nuevoDestino" required>
                  <option value="">Seleccione destino</option>
                  <option value="Tienda">Tienda</option>
                  <option value="Cafeteria">Cafeteria</option>
                  <option value="Restaurant">Restaurant</option>
                  <option value="Hotel">Hotel</option>
                  <option value="otros">otros</option>
                </select>
              </div>
            </div>

            <!-- ENTRADA PARA LA DESCRIPCION DEL GASTO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa  fa-pencil-square-o"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoGasto" name="nuevoGasto" placeholder="Descripción Gastos" required>
                <span class="input-group-btn">
              </div>
            </div>

            <!-- ENTRADA PARA LA CANTIDAD DE COMPRA DE GASTO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                <input type="number" class="form-control input-lg" id="nuevaCantidad" name="nuevaCantidad" min="0" placeholder="Cantidad" required>
              </div>
            </div>
            <!-- ENTRADA PARA PRECIO COMPRA -->
            <div class="form-group row">
              <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                  <input type="number" class="form-control input-lg" id="nuevoPrecio" name="nuevoPrecio" min="0" step="any" placeholder="Precio" required>
                </div>
              </div>

            </div>
          </div>
        </div>
      <!--=====================================
    PIE DEL MODAL
    ======================================-->
    <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-dark">Guardar Gasto</button>
        </div>
      </form>
        <?php
          $crearGasto = new ControladorGastos();
          $crearGasto -> ctrCrearGastos();
        ?>  
    </div>
  </div>
</div>

