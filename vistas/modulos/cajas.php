
<div class="content-wrapper">
  <section class="content-header">
    <h1><strong> APERTURA Y CIERRE DE CAJA</strong></h1>
  </section>
  <section class="content">
    <div class="box">
      <!--================= 
        CONDICIONAL PARA VERIFICAR SI ABRIMOS O CERRAMOS CAJA 
        ==================================-->
      <div class="box-header with-border">
        <?php

        $item = "estado_caja";
        $valor = "abierto";
        $respuesta = ControladorCaja::ctrMostrarCaja($item, $valor);
        // Se asigna el valor a vació para setearlo después
        $idCaja = "";

        // Si la caja esta vacia, es decir si no hay ningun valor en la BD se muestra Boton Apertura de Caja
        if (empty($respuesta)) {
          echo '<button class="btn btn-primary" data-toggle="modal" data-target="#modalAbreCaja"><i></i>Aperturar Caja</button>';
        } else {
          // Se setea con el id de la caja que esta abierta para usarlo en el modal cierra caja
          $idCaja = $respuesta["id_caja"];
          echo '<button class="btn btn-danger" data-toggle="modal" data-target="#modalCierraCaja"><i></i>Cierre Caja</button>';
        }
        ?>
      </div>
      <!--=============================================================== 
        FINAL DE CONDICIONAL PARA VERIFICAR SI ABRIMOS O CERRAMOS CAJA 
        =====================================================================-->
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablaListadoCajas text-center" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Nombre_Caja</th>
              <th>Usuario_Cajero</th>
              <th>Sucursal</th> 
              <th>Fecha_Apertura</th>
              <th>Monto_Inicial</th>
              <th>Estado_Caja</th>
              <th>Fecha_Cierre</th>
              <th>Monto_Final</th>
            </tr>
          </thead>

          <tbody>
            <?php
            /*$item = null;
            $valor = null;
            $respuesta = ControladorCaja::ctrMostrarCaja($item, $valor);

            foreach ($respuesta as $key => $value) {
              echo '<tr>
                        <td>' . ($key + 1) . '</td>
                        <td>' . $value["nombre"] . '</td>
                        <td>' . $value["id_usuario"] . '</td>
                        <td>' . $value["id_sucursal"] . '</td>
                        <td>' . $value["fecha_apertura"] . '</td>
                        <td>$ ' . number_format($value["monto_apertura"], 2) . '</td>';*/

              // Se extrae el valor del estado_caja y dependiendo el valor se muestra el color
              /*if ($value["estado_caja"] == "abierto") {
                echo '<td><button class="btn btn-success btn-xs">Abierto</button></td>';
              } else {
                echo '<td><button class="btn btn-danger btn-xs">Cerrado</button></td>';
              }*/
              /*echo '<td>' . $value["fecha_cierre"] . '</td>
              <td>$ ' . number_format($value["monto_cierre"], 2) . '</td>
                            <div class="btn-group">';
              '</div>
                        </td>
                    </tr>
                ';
            }*/
            ?>
          </tbody>
          <input type="hidden" value="<?php echo $_SESSION['id']; ?>" id="idUsuario"> 

        </table>
      </div>
    </div>
    <!--============================================= 
      INICIO DE MODAL APERTURA DE CAJA 
      ================================================-->
  </section>
  <div id="modalAbreCaja" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">
          <!--====================================================
           CABEZA DEL MODAL 
           ======================================================-->
          <div class="modal-header" style="background:#3c8dbc; color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><strong>APERTURA DE CAJA</strong></h4>
          </div>
          <!--=====================================================
            CUERPO DEL MODAL 
            ======================================================-->
          <div class="modal-body">
            <div class="box-body">
              <!-- ENTRADA PARA MONTO INICIAL -->
              <div class="form-group">
                <label>Monto Inicial</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                  <input type="text" class="form-control" id="montoInicial" name="montoInicial" placeholder="Monto Apertura" required>
                </div>
              </div>
              <!-- NOMBRE DE USUARIO A CARGO DE CAJA -->
              <div class="form-group">
                <label>Cajero:</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                  <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">
                </div>
              </div> 
              <!-- NOMBRE DE SUCURSAL DE CAJA --> 
              <div class="form-group"> 
                <input type="hidden" name="idSucursal" value="<?php echo $_SESSION["idSucursal"]; ?>">
              </div>
              <!-- NOMBRE DE LA CAJA -->
              <div class="form-group">
                <input type="hidden" value="Caja Principal" class="form-control" id="nombreCaja" name="nombreCaja" readonly>
              </div>
              <!-- ESTADO INICIAL DE LA CAJA -->
              <div class="form-group">
                <!-- Se cambia el estadoCaja de 1 a abierto -->
                <input type="hidden" value="abierto" class="form-control" id="estadoCaja" name="estadoCaja" required>
              </div>
              <!-- MONTO DE CIERRE DE LA CAJA -->
              <div class="form-group">
                <input type="hidden" value="0" class="form-control" id="montoFinal" name="montoFinal" required readonly>
              </div> 
        
            </div>
          </div>
          <!--============================= 
            PIE DEL MODAL 
            ===================================-->
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary"><i></i>Aperturar</button>
          </div>
          <?php
          $aperturaCaja = new ControladorCaja();
          $aperturaCaja->ctrAperturaCaja();
          ?>
        </form>
      </div>
    </div>
  </div>
  <!--============================= FINAL MODAL APERTURA DE CAJA ===================================-->

  <!--================================= 
    INICIO DE MODAL CIERRE DE CAJA 
    ==================================-->
  </section>
  <div id="modalCierraCaja" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">
          <!--================================ 
            CABEZA DEL MODAL 
            ==================================-->
          <div class="modal-header" style="background:#3c8dbc; color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><strong>CIERRE DE CAJA</strong></h4>
          </div>
          <!--==================================== 
            CUERPO DEL MODAL 
            ======================================-->
          <div class="modal-body">
            <div class="box-body">
              <!-- ESTADO DE LA CAJA -->
              <div class="form-group">
                <!-- Se cambia valor de 0 a cerrado -->
                <input type="hidden" value="cerrado" class="form-control" id="estadoFinal" name="estadoFinal" required readonly>
                <!-- Se añade input oculto para el id -->
                <input type="hidden" value="<?php echo ($idCaja != "") ? $idCaja : '' ?>" class="form-control" id="idCaja" name="idCaja" required>
              </div>
              <!-- ENTRADA PARA MONTO INICIAL -->
              <div class="form-group">
                <label>Monto de Cierre</label>
                <div class="input-group">
                  <span class="input-group-addon"><i>S/</i></span>
                  <input type="text" class="form-control" id="monto_final" name="monto_final"  placeholder="Monto de Cierre" required>
                </div>
              </div>
              <!-- ENTRADA PARA FECHA DE CIERRE DE CAJA -->
              <!-- ESTE DATO SE COLOCA EN EL Controlador o en el Modelo (hacer pruebas) -->
              <div class="form-group">
                <label>Fecha de Cierre</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <?php date_default_timezone_set('America/Lima');
                  $fecha_cierre = date('Y-m-d'); ?>
                  <!-- <input type="date" class="form-control" name="monto_final" min="0" step="any" placeholder="Monto de Cierre" required> -->
                  <input type="date" class="form-control" value="<?php echo $fecha_cierre; ?>" id="fechaCierre" name="fechaCierre" readonly>
                </div>
              </div>

            </div>
          </div>
          <!--================================= 
            PIE DEL MODAL 
            ===================================-->
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger"><i></i>CIERRE DE CAJA</button>
          </div>
          <?php
          $cierreCaja = new ControladorCaja();
          $cierreCaja->ctrCierreCaja();
          ?>
        </form>
      </div>
    </div>
  </div>

</div>