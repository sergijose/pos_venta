
<div class="content-wrapper">
  <section class="content">
    <div class="row">

  <!--================================== 
        EL FORMULARIO 
  ====================================-->
    <div class="col-lg-6 col-xs-12">
        <div class="box box-success">
          <section class="content-header">
            <h1>Registro de Ventas</h1>
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
                    <label>Vendedor:</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                      <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">
                    </div>
                  </div>
                </div>  
<!--============================================
          ENTRADA PARA SUCURSAL
======================================-->

                      <input type="hidden" name="idSucursal" value="<?php echo $_SESSION["idSucursal"]; ?>">

<!--=====================================
      TIPO DE  COMPROBANTE
======================================-->        
 <div class="col-xs-5">
            <div class="form-group"> 
            <label>Tipo de Comprobante:</label>             
              <div class="input-group">           
                  <span class="input-group-addon"><i class="fa fa-cube"></i></span> 
                    <select class="form-control" id="nuevaFactura" name="nuevaFactura">
                      <?php
                        $item = null;
                        $valor = null;
                        $tipoC = ControladorComprobante::ctrMostraTipo($item, $valor);

                        foreach ($tipoC as $key => $value) {
                          echo '<option value="'.$value["id"].'">'.$value["comprobante"].'</option>';
                        }
                        ?>
                </select>
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
                      echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="0001" readonly>';                 
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
<!--========================================================= 
        ENTRADA DEL CLIENTE 
==========================================================-->
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
                          echo '<option value="' . $value["id"] . '">' . $value["razon_social"].' - [D.N.I.: '.$value["ruc"].' ]</option>';
                        }
                        ?>
                      </select>
                      <span class="input-group-addon"><button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalDNI" data-dismiss="modal">Agregar cliente</button></span>
                    </div>
                  </div>
<!--======================================= 
      ENTRADA PARA AGREGAR PRODUCTO  
=========================================-->
                <div class="form-group row nuevoProducto">
                </div>
                <input type="hidden" id="listaProductos" name="listaProductos">
<!--=================================== 
        BOTÓN PARA AGREGAR PRODUCTO 
======================================-->
                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
                <hr>
                <div class="row">
<!--================================================ 
        ENTRADA IMPUESTOS Y TOTAL 
================================================-->
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
<!---------------------------- Aqui calculamos el SubTotal ----------->
                          <td style="width: 34%">  
                            <div class="input-group">
                              <input type="number" class="form-control input-lg" id="SubTotal" name="SubTotal" readonly>
                            </div>
                          </td> 
<!------------------------- Aqui calculamos el IGV --------------->
                          <td style="width: 34%">  
                            <div class="input-group">
                              <input type="number" class="form-control input-lg" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" readonly>
                            </div>
                          </td>
<!----------------------- Aqui calculamos el Total ------------>      
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
<!--================================================== 
      ENTRADA MÉTODO DE PAGO 
 ==================================================-->

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
                  <th>Producto</th>
                  <th>Categoria</th>
                  <th>Precio</th>
                  <th>Stock</th>
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


<!--=====================================
MODAL CLIENTES DNI
======================================-->
<div id="modalDNI" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
      <form role="form" method="post">  
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
          <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registro de Clientes  -Extraido de RENIEC</h4>
        </div> 
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
         <div class="modal-body">
          <div class="box-body">

        <div class="col-xs-6">
            <div class="form-group"> 
            <label>Tipo Documento:</label> 
              <div class="input-group">           
                  <span class="input-group-addon"><i class="fa fa-cube"></i></span> 
                    <!-- <input type="text" value="RUC" class="form-control" id="nuevoTipo" name="nuevoTipo"readonly> -->
                    <select class="form-control" id="nuevoTipo" name="nuevoTipo">
                      <option value="">Selecionar Tipo</option>
                      <option value="DNI">D.N.I.</option>
                </select>
              </div>
            </div> 
        </div>      
          <div class="col-xs-6">
              <label>Nº D.N.I.:</label>
         <div class="input-group">
            <input type="text" autocomplete="off" class="form-control" id="dni" name="dni" placeholder="Nº de DNI" required>
               <span class="input-group-btn">
                   <a href="#" class="btn btn-info" onclick="consultar()">Buscar<i class="fa fa-search"></i></a>
               </span>
         </div>
           </div>
      
        <div class="col-xs-12">     
            <div class="form-group">
              <label>Informacion de Cliente:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="nombres" name="nombres" required >
              </div>
            </div>
        </div>    
          
        <div class="col-xs-6">     
            <div class="form-group">
              <label>Direccion del Cliente:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente"  autocomplete="off" required>
              </div>
            </div> 
        </div> 
        
        <div class="col-xs-6">     
            <div class="form-group">
              <label>Numero RUC:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="ruc_cliente" name="ruc_cliente"  autocomplete="off">
              </div>
            </div> 
        </div> 

        <div class="col-xs-6">     
            <div class="form-group">
              <label>Telefono:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="telefono" name="telefono"  autocomplete="off">
              </div>
            </div> 
        </div> 

        <div class="col-xs-6">     
            <div class="form-group">
              <label>Correo Electronico:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="email" class="form-control" id="correo" name="correo"  autocomplete="off">
              </div>
            </div> 
        </div> 

             
            </div>
        </div>  
        <!--=====================================
        PIE DEL MODAL
        =====================================-->
           <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Grabar Informacion</button>
        </div> 
       <?php
        $cliente = new ControladorClientes();
        $cliente -> ctrCrearClienteDNIVENTA();
       ?>
      </form>
    </div>
  </div>
</div> 
 