<!--  
// <?php
//if ($value["perfil"] == "Vendedor") {
//  echo '<script>
 //        swal({
 //             type: "error",
//              title: "Acceso Denegado.. Consulte con el Admin del Sistema..!",
 //             showConfirmButton: true,
//              confirmButtonText: "Cerrar"
//            }).then(function(result){
//            if (result.value) {
//              window.location = "inicio";
//             }
//           })
//          </script>';
//  return;
//}
//?> -->

<script language="javascript" type="text/javascript">
  // INICIO DE VALIDADOR DE NUMEROS Y DECIMALES
  function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;
    if (key >= 48 && key <= 57) {
      if (filter(tempValue) === false) {
        return false;
      } else {
        return true;
      }
    } else {
      if (key == 8 || key == 13 || key == 0) {
        return true;
      } else if (key == 46) {
        if (filter(tempValue) === false) {
          return false;
        } else {
          return true;
        }
      } else {
        return false;
      }
    }
  }

  function filter(__val__) {
    var preg = /^([0-9]+\.?[0-9]{0,3})$/;
    if (preg.test(__val__) === true) {
      return true;
    } else {
      return false;
    }
    // FIN DEL VALIDADOR DE NUMEROS Y DECIMALES
  }

  function SoloNumeros() {
    if ((event.keyCode < 48) || (event.keyCode > 57))
      event.returnValue = false;
  }

  function Letras() {
    if ((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
      event.returnValue = false;
  }
</script>
<div class="content-wrapper">
  <section class="content-header">
    <h1><strong> APERTURA Y CIERRE DE CAJA</strong></h1>
  </section>
  <section class="content">
    <div class="box">
<!--============ CONDICIONAL PARA VERIFICAR SI ABRIMOS O CERRAMOS CAJA ==================================-->
      <div class="box-header with-border">
        <?php
error_reporting(0);
        $item = "estado_caja";
        $valor = "abierto";
        $respuesta = ControladorCaja::ctrMostrarCaja($item, $valor);
        // Se asigna el valor a vacio para setearlo después
        $idCaja = "";

        $item1 = null;
        $valor1 = null;
        $respuesta1 = ControladorCaja::ctrMostrarCaja($item1, $valor1);

        $item2 = null;
        $valor2 = null;
        $respuesta2 = ControladorCaja::ctrMostrarCajaInicial($item2, $valor2);
        foreach ($respuesta2 as $key => $value) {
        }
        if (empty($respuesta1)) {
        $montoApertura= $value["monto_inicial"];
        }
        else{
          $montoApertura=0;
        }
        
        $hoy=date('Y-m-d');
        
        //capturar las ventas de hoy

        
        $ventasHoy = ControladorVentas::ctrSumaTotalVentasXdia();
        foreach ($ventasHoy as $key => $valueHoy) {
        }
          //capturamos el monto de apertura
          

       // var_dump($valueHoy);
        
        if (empty($respuesta2)) {
          echo '<button  id="miBoton" class="btn btn-outline-dark miBoton" data-toggle="modal" data-target="#modalAbreCajaInicial"><i></i>Registrar Caja</button>';
          
        } 
        else{
          if (empty($respuesta)) {
            echo '<button class="btn btn-primary" data-toggle="modal" data-target="#modalAbreCaja"><i></i>Aperturar Caja</button>';
          } else {
            // Se setea con el id de la caja que esta abierta para usarlo en el modal cierra caja
            $idCaja = $respuesta["id_caja"];
            echo '<button class="btn btn-danger" data-toggle="modal" data-target="#modalCierraCaja"><i></i>Cierre Caja</button>';
          }

        }


        // Si la caja esta vacia, es decir si no hay ningun valor en la BD se muestra Boton Apertura de Caja
       
       
        
        ?>
      </div>
   
<!--==================FINAL DE CONDICIONAL PARA VERIFICAR SI ABRIMOS O CERRAMOS CAJA =======================================-->
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas text-center" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Nombre_Caja</th>
             <th>Usuario_Cajero</th>
              <th>Sucursal</th> 
              <th>Fecha_Apertura</th>
              <th>Monto_Apertura</th>
              <th>Estado_Caja</th>
              <th>Fecha_Cierre</th>
              <th>Monto_cierre_ventas</th>
              <th>Monto_cierre_gastos</th>
              <th>Monto_cierre_final</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $item = null;
            $valor = null;
            $respuesta = ControladorCaja::ctrMostrarCaja($item, $valor);
            
            foreach ($respuesta as $key => $value) {
              echo '<tr>
                        <td>' . ($key + 1) . '</td>
                        <td>' . $value["nombre"] . '</td>';

                    // TRAEMOS LOS DATOS PARA MOSTRAR MOSTRAR USUARIOS Y SUCURSALES
                    $item = "id";
                    $valor = $value["id_usuario"];
                    $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                    echo '<td>'.$usuarios["nombre"].'</td>'; 

                    // TRAEMOS LOS DATOS PARA MOSTRAR SUCURSALES
                    $item = "id";
                    $valor = $value["id_sucursal"];
                    $sede = ControladorSucursal::ctrMostrarSucursal($item, $valor);
                    echo '<td>'.$sede["sede"].'</td> 


                        <td>' . $value["fecha_apertura"] . '</td>
                        <td>$ ' . number_format($value["monto_apertura"], 2) . '</td>';

              // Se extrae el valor del estado_caja y dependiendo el valor se muestra el color
              if ($value["estado_caja"] == "abierto") {
                echo '<td><button class="btn btn-success btn-xs">Abierto</button></td>';
              } else {
                echo '<td><button class="btn btn-danger btn-xs">Cerrado</button></td>';
              }

              // Esto no aplica ya que todo esta en una sola tabla
              // $item = "id";
              // $valor = $value["idEstadoCaja"];
              // $rcaja = ControladorEstadoCaja::ctrMostrarEstadoCaja($item, $valor);
              // VALIDACION PARA CAMBIO DE COLOR EN DATATABLE
              // if ($valor == 0) {
              //   echo '<td><button class="btn btn-danger">' . $rcaja["estado"] . '</button></td>';
              // } else if ($valor == 1) {
              //   echo '<td><button class="btn btn-success">' . $rcaja["estado"] . '</button></td>';
              // } else {
              //   echo '<td><button class="btn btn-warning">' . $rcaja["estado"] . '</button></td>';
              // }
              // FINAL DE COLOR DEL BOTON DEPENDIENDO EL ESTADO  
              echo '<td>' . $value["fecha_cierre"] . '</td>
                        <td>$ ' . number_format($value["monto_cierre_ventas"], 2) . '</td>

                   
                ';
                 echo '  <td>$ ' . number_format($value["monto_cierre_gastos"], 2) . '</td>
                        <td>$ ' . number_format($value["monto_cierre_total"], 2) . '</td>
                    
                ';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <!--================= INICIO DE MODAL APERTURA DE CAJA ==================================-->
  </section>


  <div id="modalAbreCajaInicial" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">
          <!--================= CABEZA DEL MODAL ==================================-->
          <div class="modal-header" style="background:#3c8dbc; color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><strong>INICIAR DE CAJA</strong></h4>
          </div>
          <!--============================= CUERPO DEL MODAL ======================================-->
          <div class="modal-body">
            <div class="box-body">
              <!-- ENTRADA PARA MONTO INICIAL -->
              <div class="form-group">
                <label>Monto Inicial</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                  <input type="number" class="form-control" id="montoInicial" name="montoInicial" min="1" step="any" placeholder="Monto Apertura"
                  value="" required>
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
              <!--
              <div class="form-group"> 
                <input type="hidden" name="idSucursal" value="<?php echo $_SESSION["idSucursal"]; ?>">
              </div>
               NOMBRE DE LA CAJA 
              <div class="form-group">
                <input type="hidden" value="Caja Principal" class="form-control" id="nombreCaja" name="nombreCaja" readonly>
              </div>
               ESTADO INICIAL DE LA CAJA 
              <div class="form-group">
                 Se cambia el estadoCaja de 1 a abierto 
                <input type="hidden" value="abierto" class="form-control" id="estadoCaja" name="estadoCaja" required>
              </div>
               MONTO DE CIERRE DE LA CAJA 
              <div class="form-group">
                <input type="hidden" value="0" class="form-control" id="montoFinal" name="montoFinal" required readonly>
              </div> 
          -->
            </div>
          </div>
          <!--============================= 
            PIE DEL MODAL 
            ===================================-->
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary"><i></i>Iniciar Caja</button>
          </div>
          <?php
          $aperturaCajaInicial = new ControladorCaja();
          $aperturaCajaInicial->ctrAperturaCajaInicial();
          ?>
        </form>
      </div>
    </div>
  </div>


  <div id="modalAbreCaja" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">
          <!--================= CABEZA DEL MODAL ==================================-->
          <div class="modal-header" style="background:#3c8dbc; color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><strong>APERTURA DE CAJA</strong></h4>
          </div>
          <!--============================= CUERPO DEL MODAL ======================================-->
          <div class="modal-body">
            <div class="box-body">
              <!-- ENTRADA PARA MONTO INICIAL -->
              <div class="form-group">
                <label>Monto Inicial</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>

                  <input type="number" class="form-control" id="montoInicial" name="montoInicial" min="1" step="any" value="<?php echo $montoApertura;?>" required readonly>
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

  <!--================= 
    INICIO DE MODAL CIERRE DE CAJA 
    ==================================-->
  </section>
  <div id="modalCierraCaja" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">
          <!--================= 
            CABEZA DEL MODAL 
            ==================================-->
          <div class="modal-header" style="background:#3c8dbc; color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><strong>CIERRE DE CAJA</strong></h4>
          </div>
          <!--============================= 
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
              <!-- ENTRADA PARA MONTO CIERRE DE GASTOS-->
              <div class="form-group">
                <label>Monto de Cierre de ventas del dia</label>
                <div class="input-group">
                  <span class="input-group-addon"><i>$</i></span>
                  <input type="number" class="form-control" id="monto_cierre_ventas" name="monto_cierre_ventas" min="0" step="any" value=""required  onchange="SumarAutomatico(this.value);">
                </div>
              </div>
                <!-- ENTRADA PARA CIERRE DE GASTOS -->
                <div class="form-group">
                <label>Monto de Cierre de gastos</label>
                <div class="input-group">
                  <span class="input-group-addon"><i>$</i></span>
                  <input type="number" class="form-control" id="monto_cierre_gastos" name="monto_cierre_gastos" min="0" step="any" value="" required  onchange="SumarAutomatico(this.value);">
                </div>
              </div>
               <!-- ENTRADA PARA MONTO DE CIERRE CAJA -->
               <div class="form-group">
                <label>Monto total de cierre de caja</label>
                <div class="input-group">
                  <span class="input-group-addon"><i>$</i></span>
                  <input type="number" class="form-control" id="monto_cierre_final" name="monto_cierre_final" min="0" step="any" value="" readonly required >
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
          <!--============================= 
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