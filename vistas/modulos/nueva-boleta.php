
<div class="content-wrapper">
  <section class="content">
    <div class="row">

  <!--================================== 
        EL FORMULARIO 
  ====================================-->
    <div class="col-lg-6 col-xs-12">
        <div class="box box-success">
          <section class="content-header">
            <h1>Registro de Ventas - Boleta  de Venta</h1>
          </section>
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="formularioVenta">
            <div class="box-body">
              <div class="box">
                <!--==================================== 
                  ENTRADA DEL VENDEDOR 
                  ======================================-->
            <div class="col-xs-4">      
                  <div class="form-group">
                    <label>VENDEDOR:</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                      <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">
                    </div>
                  </div>
             </div>      
                <!--=====================================
                  ENTRADA PARA SUCURSAL
                  ======================================-->
                <!-- <div class="col-xs-6">
                  <div class="form-group"> -->
                    <!-- <label>SUCURSAL:</label> -->
                   <!--  <div class="input-group"> -->
<!--                       <input type="text" class="form-control" id="nuevaSucursal" value="<?php echo $_SESSION["idSucursal"]; ?>" readonly> -->
                      <input type="hidden" name="idSucursal" value="<?php echo $_SESSION["idSucursal"]; ?>">
                    <!-- </div> -->
                 <!--  </div>
                </div> -->
<!--=====================================
      TIPO DE  COMPROBANTE
======================================-->        
<div class="col-xs-5">             
            <div class="form-group">
              <label>Tipo de Comprobante:</label>              
              <div class="input-group">           
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <input type="text" value="Boleta de Venta" class="form-control" readonly>
                <input type="hidden" value="2" class="form-control" id="nuevaFactura" name="nuevaFactura">
              </div>
            </div>
       </div>            

        <!--=====================================
          CORRELATIVO DEL COMPROBANTE
        ======================================-->
 <div class="col-xs-3">         
       <div class="form-group">
          <label>Correlativo:</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <?php
                    $item = null;
                    $valor = null;
                    $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

                    if(!$ventas){
                      echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="001" readonly>';                 
                    }else{

                      foreach ($ventas as $key => $value) {                     
                      }
                      
                      $codigo = $value["codigo"] + 1;
                      $numeroConCeros = str_pad($codigo, 4, "0", STR_PAD_LEFT);

                      echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="'.$numeroConCeros.'" readonly>';                  
                    }
                    ?>                                      
          </div>          
        </div>  
   </div>       
                <!--================================ 
                  ENTRADA DEL CLIENTE 
                  ======================================-->
                  <div class="form-group">
                    <label>CLIENTE:</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-users"></i></span>
                      <select class="form-control" id="seleccionarCliente" name="seleccionarCliente" required>
                        <!-- <option value="">Seleccionar cliente</option> -->
                        <?php
                        $item = null;
                        $valor = null;
                        $categorias = ControladorClientes::ctrMostrarClientes($item, $valor);

                        foreach ($categorias as $key => $value) {
                          echo '<option value="' . $value["id"] . '">' . $value["nombre"].' - [D.N.I: '.$value["documento"].' ]</option>';
                        }
                        ?>
                      </select>
                      <span class="input-group-addon"><button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar cliente</button></span>
                    </div>
                  </div>
                <!--=================================== 
                  ENTRADA PARA AGREGAR PRODUCTO  
                  ======================================-->
                <div class="form-group row nuevoProducto">
                </div>
                <input type="hidden" id="listaProductos" name="listaProductos">
                <!--=================================== 
                  BOTÓN PARA AGREGAR PRODUCTO 
                  ======================================-->
                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
                <hr>
                <div class="row">
                  <!--=================================== 
                    ENTRADA IMPUESTOS Y TOTAL 
                    ======================================-->
                  <div class="col-xs-12 pull-right">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>SubTotal</th>
                          <th>IGV(18%)</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                      <!-- Aqui calculamos el SubTotal -->
                          <td style="width: 34%">  
                            <div class="input-group">
                             <input type="number" value="0" class="form-control input-lg" readonly>
                              <input type="hidden" value="0" class="form-control input-lg" id="SubTotal" name="SubTotal" readonly>
                            </div>
                          </td> 
                    <!-- Aqui calculamos el IGV-->
                          <td style="width: 34%">  
                            <div class="input-group">
                              <input type="number" value="0" class="form-control input-lg" readonly>
                              <input type="hidden" value="0" class="form-control input-lg" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" readonly>
                            </div>
                          </td>
                    <!-- Aqui calculamos el Total -->      
                          <td style="width: 34%"> 
                            <div class="input-group">
                              <span class="input-group-addon"><i>S/</i></span>
                              <input type="text" class="form-control input-lg" style="height:60px" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" placeholder="00000" readonly required>
                              <input type="hidden" name="totalVenta" id="totalVenta">
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <hr>
                <!--============================= 
                  ENTRADA MÉTODO DE PAGO 
                  ======================================-->
<!--                 <div class="form-group">                  
                  <div class="col-xs-4" style="padding-right:0px">                    
                     <div class="input-group">
                      <input type="text" value="Efectivo" class="form-control" readonly> 
                      <input type="hidden" value="Efectivo" class="form-control" id="listaMetodoPago" name="listaMetodoPago" readonly>
                    </div>
                  </div>
                </div> -->
                <!-- Aca termina los metodos de pago -->
                <!-- Aca la Caja de Texto para el efectivo pagado por el cliente -->
<!--                 <div class="form-group">
                     <div class="col-xs-4">
                       <div class="input-group">
                           <span class="input-group-addon"><i>S/</i></span>
                          <input type="text" class="form-control" name="nuevoValorEfectivo" id="nuevoValorEfectivo" placeholder="000000" required>
                       </div>
                    </div>
                </div> --> 
                <!-- Aca la Caja de Texto para el Cambio del Efectivo al cliente -->
<!--               <div class="form-group">
                  <div class="input-group">
                     <span class="input-group-addon"><i>S/</i></span>
                      <input type="text" class="form-control" style="height:60px" name="nuevoCambioEfectivo" id="nuevoCambioEfectivo" placeholder="000000" readonly required>
                  </div>
             </div> --><!-- Final del Cambio del Efectivo al cliente -->
              <div class="form-group row">                 
                  <div class="col-xs-6" style="padding-right:0px">                   
                     <div class="input-group">                 
                      <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                        <option value="">Seleccione método de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta</option>                
                      </select>    
                    </div>
                  </div>
                  <div class="cajasMetodoPago"></div>
                  <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">
                  <input type="hidden" name="pagoCliente" id="pagoCliente" required> 
                  <input type="hidden" name="cambioEfectivo" id="cambioEfectivo" required>
                  <input type="hidden" name="codigoTransaccion" id="codigoTransaccion" required>
                 </div>  <!-- Final de ENTRADA METODO DE PAGO -->

                <br>
              </div>
            </div>
            
            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-dark pull-right">Guardar venta</button>
            </div>
          </form>
          <?php
          $guardarVenta = new ControladorVentas();
          $guardarVenta->ctrCrearVenta();
          ?>
        </div>
      </div>


  <!--=====================================
      LA TABLA DE PRODUCTOS 
  ======================================-->
     <div class="col-lg-6 hidden-md hidden-sm hidden-xs">
        <div class="box box-success">
          <div class="box-header with-border"></div>
          <div class="box-body">
            <table class="table table-bordered table-striped dt-responsive tablaN text-center">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
<!--                   <th>Codigo</th> -->
                  <th>Producto</th>
                  <th>Nota/Descripcion</th>
<!--                   <th>Sucursal</th> -->
                  <th>Stock_Actual</th>
                  <th>Acciones</th>
                </tr>
              </thead>

              <input type="hidden" value="<?php echo $_SESSION['idSucursal']; ?>" id="sedeoculta">
            </table>
          </div>
        </div>
      </div>




    </div>
  </section>
</div>
<!--=====================================MODAL AGREGAR CLIENTE======================================-->
<div id="modalAgregarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <form role="form" method="post">
        <!--=====================================CABEZA DEL MODAL======================================-->
        <div class="modal-header" style="background:#00a65a; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar cliente</h4>
        </div>
        <!--===================================== CUERPO DEL MODAL======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingresar nombre" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoDocumentoId" placeholder="Ingresar documento" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" value="contacto@mail.com" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email">
              </div>
            </div>
            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" value="999-999-999" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono">
              </div>
            </div>
            <!-- ENTRADA PARA LA DIRECCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección" >
              </div>
            </div>

          </div>
        </div>
        <!--=====================================PIE DEL MODAL======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-dark">Guardar cliente</button>
        </div>
      </form>
      <?php

      $clienteVenta = new ControladorClienteVenta();
      $clienteVenta->ctrCrearClienteVenta();

      ?>

    </div>
  </div>
</div>