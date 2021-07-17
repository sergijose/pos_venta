<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->
      <div class="col-lg-12 hidden-md hidden-sm hidden-xs">
        <div class="box box-warning">
          <div class="box-header with-border"></div>
          <div class="box-body">         
            <table class="table table-bordered table-striped dt-responsive tablaN">
              
               <thead>
                 <tr>
                  <th style="width: 10px">#</th>
                  <th>Producto</th>
                  <th>Descripcion</th>
                  <th>Stock</th>
                  <th>Acciones</th>
                </tr>

              </thead>
              
              <input type="hidden" value="<?php echo $_SESSION['idSucursal']; ?>" id="sedeoculta">
            </table>
          </div>
        </div>
      </div>    
  <!--============================================
      EL FORMULARIO
  ===============================================-->
      <div class="col-lg-12 col-xs-12">  
        <div class="box box-success"> 
          <section class="content-header">
             <h1><strong>Edicion de Venta</strong></h1>
          </section>        
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="formularioVenta">
            <div class="box-body">
              <div class="box">

                <?php
                    $item = "id";
                    $valor = $_GET["idVenta"];
                    $venta = ControladorVentas::ctrMostrarVentas($item, $valor);

                    $itemUsuario = "id";
                    $valorUsuario = $venta[0]["id_vendedor"];
                    $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemCliente = "id";
                    $valorCliente = $venta[0]["id_cliente"];
                    $cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                    $porcentajeImpuesto = $venta[0]["impuesto"] * 100 / $venta[0]["neto"];
                ?>
                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
             <div class="col-xs-4">   
                <div class="form-group"> 
                <label>VENDEDOR:</label>              
                  <div class="input-group">                  
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $vendedor["nombre"]; ?>" readonly>
                    <input type="hidden" name="idVendedor" value="<?php echo $vendedor["id"]; ?>">
                  </div>
                </div> 
             </div>     
                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================-->
            <div class="col-xs-4">      
                <div class="form-group">
                 <label>CODIGO DE VENTA:</label>                 
                  <div class="input-group">                  
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                   <input type="text" class="form-control" id="nuevaVenta" name="editarVenta" value="<?php echo $venta[0]["codigo"];?>" readonly>
                  </div>              
                </div>
             </div>    
                <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================--> 
            <div class="col-xs-4">    
                <div class="form-group">
                 <label>CLIENTE:</label>                
                  <div class="input-group">                  
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>                 
                    <select class="form-control" id="seleccionarCliente" name="seleccionarCliente" required>
                    <option value="<?php echo $cliente["id"]; ?>"><?php echo $cliente["razon_social"]; ?></option>
                    <?php
                      $item = null;
                      $valor = null;
                      $categorias = ControladorClientes::ctrMostrarClientes($item, $valor);
                       foreach ($categorias as $key => $value) {
                         echo '<option value="'.$value["id"].'">'.$value["razon_social"].'</option>';
                       }
                    ?>
                    </select>        
                     <!--          
                    <span class="input-group-addon">
                     <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar cliente</button></span>
                      -->
                    </div>             
                </div>
            </div>    
                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 
                <div class="form-group row nuevoProducto">
                <?php
                $listaProducto = json_decode($venta[0]["productos"], true);
                foreach ($listaProducto as $key => $value) {

                  $item = "id";
                  $valor = $value["id"];
                  $orden = "id";
                  $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
                  $stockAntiguo = $respuesta["stock"] + $value["cantidad"];
                  
                  echo '<div class="row" style="padding:5px 15px">
            
                        <div class="col-xs-6" style="padding-right:0px">            
                          <div class="input-group">              
                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'"><i class="fa fa-times"></i></button></span>
                            <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value["id"].'" name="agregarProducto" value="'.$value["descripcion"].'" readonly required>
                          </div>
                        </div>

                        <div class="col-xs-3 divCant">
                          <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stock"].'" required>
                        </div>

                        <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>                   
                            <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$respuesta["precio_venta"].'" name="nuevoPrecioProducto" value="'.$value["total"].'" readonly required>
                          </div>             
                        </div>
                      </div>';
                }
                ?>
                </div>
                <input type="hidden" id="listaProductos" name="listaProductos">
                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->
                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
                <hr>
                <div class="row">
                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->               
                  <div class="col-xs-8 pull-right">                   
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Impuesto</th>
                          <th>Total</th>      
                        </tr>
                      </thead>
                      <tbody>                     
                        <tr>                          
                          <td style="width: 50%">                           
                            <div class="input-group">                         
                              <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" value="0"  readonly>
                               <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" value="<?php echo $venta["impuesto"]; ?>" required>
                               <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" value="<?php echo $venta[0]["neto"]; ?>" required>
                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>                     
                            </div>
                          </td>
                           <td style="width: 50%">                         
                            <div class="input-group">                           
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="<?php echo $venta[0]["neto"]; ?>"  value="<?php echo $venta[0]["total"]; ?>" readonly required>
                              <input type="hidden" name="totalVenta" value="<?php echo $venta[0]["total"]; ?>" id="totalVenta">
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
                <div class="form-group">                  
                  <div class="col-xs-4" style="padding-right:0px">                    
                     <div class="input-group">
                      <input type="text" value="Efectivo" class="form-control" readonly> 
                      <input type="hidden" value="Efectivo" class="form-control" id="listaMetodoPago" name="listaMetodoPago" readonly>
                    </div>
                  </div>
                </div>
                <!-- Aca termina los metodos de pago -->
                <!-- Aca la Caja de Texto para el efectivo pagado por el cliente -->
                <div class="form-group">
                     <div class="col-xs-4">
                       <div class="input-group">
                           <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" class="form-control" id="nuevoValorEfectivo" placeholder="000000" required>
                       </div>
                    </div>
                </div> 
                <!-- Aca la Caja de Texto para el Cambio del Efectivo al cliente -->
              <div class="form-group">
                  <div class="input-group">
                     <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                      <input type="text" class="form-control" style="height:60px" id="nuevoCambioEfectivo" placeholder="000000" readonly required>
                  </div>
             </div>
             <!-- Final del Cambio del Efectivo al cliente -->
                <br>
              </div>
            </div>

          <div class="box-footer">
            <button type="submit" class="btn btn-flat btn-dark pull-right">Guardar cambios</button>
          </div>
        </form>
        <?php
          $editarVenta = new ControladorVentas();
          $editarVenta -> ctrEditarVenta();
        ?>
        </div>       
      </div>



    </div>
  </section>
</div>



<!--=====================================
MODAL CLIENTES DNI
======================================-->
 <div id="modalAgregarCliente" class="modal fade" role="dialog">
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
                <input type="text" class="form-control" id="nombres" name="nombres" required readonly>
              </div>
            </div>
        </div>    
          
        <div class="col-xs-12">     
            <div class="form-group">
              <label>Direccion del Cliente:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control input-lg" id="direccion_cliente" name="direccion_cliente"  autocomplete="off" required>
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
        $cliente -> ctrCrearClienteRUC();
       ?>
      </form>
    </div>
  </div>
</div> 