<div class="content-wrapper">
  <section class="content">
    <div class="row">
   <!--=====================================
  LA TABLA DE PRODUCTOS
  ==========================-->
      <div class="col-lg-12 hidden-md hidden-sm hidden-xs">
        <div class="box box-primary">
          <div class="box-header with-border"></div>
          <div class="box-body">
            <table class="table table-bordered table-striped dt-responsive tablaCompras" width="100%">            
               <thead>
                 <tr>
                  <th style="width: 10px">#</th>
                   <th>Codigo</th>
                   <th>Producto</th>
                   <th>Nota / Descripcion</th>
                  <th>Sucursal</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <!-- <input type="hidden" value="1" id="sedeoculta"> --> <!--Aqui indicamos que solamente muestre Sede Principal-->
              <input type="hidden" value="<?php echo $_SESSION['idSucursal']; ?>" id="sedeoculta"> <!--Aqui indicamos que solamente muestre Sede Principal-->
            </table>
          </div>
        </div>
      </div>
      <!--=====================================
      EL FORMULARIO
      ======================================-->
      <div class="col-lg-12 col-xs-12">       
        <div class="box box-primary">
             <section class="content-header">
               <h1><strong>Edicion de Compra</strong></h1>
             </section> 
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="formularioCompra">
            <div class="box-body">
                <div class="box">
                <?php

                    $item = "id";
                    $valor = $_GET["idCompra"];
                    $compra = ControladorCompras::ctrMostrarCompras($item, $valor);

                    $itemUsuario = "id";
                    $valorUsuario = $compra["id_usuario"];

                    $comprador = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemProveedor = "id";
                    $valorProveedor = $compra["id_proveedor"];

                    $proveedor = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);
                    $porcentajeImpuestoC = $compra["impuesto"] * 100 / $compra["neto"];
                ?>
                <!--=====================================
                ENTRADA DEL COMPRADOR
                ======================================-->
            <div class="col-xs-4">     
                <div class="form-group">
                  <label>USUARIO REGISTRADOR:</label>
                  <div class="input-group">                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                    <!-- <input type="text" class="form-control" id="nuevoComprador" name="nuevoComprador" value="Usuario Administrador" readonly> -->
                    <input type="text" class="form-control" id="nuevoComprador" value="<?php echo $comprador["nombre"]; ?>" readonly>
                    <input type="hidden" name="idComprador" value="<?php echo $comprador["id"]; ?>">
                  </div>
                </div> 
            </div>     
                <!--=====================================
                ENTRADA DEL CODIGO FACTURA
                ======================================-->
           <div class="col-xs-4">      
                <div class="form-group"> 
                <label>CODIGO IDENTIFICADOR:</label>                 
                  <div class="input-group">                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="text" class="form-control" id="nuevaCompra" name="editarCompra" value="<?php echo $compra["codigo"]; ?>" readonly>                   
                    <!-- <input type="text" class="form-control" id="nuevaCompra" name="nuevaCompra" value="10002343" readonly> -->   
                  </div>               
                </div>
           </div>     
                <!--=====================================
                ENTRADA DEL PROVEEDOR
                ======================================-->
            <div class="col-xs-4">     
                <div class="form-group">
                  <label>PROVEEDOR:</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    <select class="form-control" id="seleccionarProveedor" name="seleccionarProveedor" required>
                    <option value="<?php echo $proveedor["id"]; ?>"><?php echo $proveedor["nombre"]; ?></option>
                    <?php                    
                      $item = null;
                      $valor = null;
                      $categorias = ControladorProveedores::ctrMostrarProveedores($item, $valor);
                      foreach($categorias as $key => $value){
                        echo'<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                      }                  
                    ?>
                    </select>                    
                    <span class="input-group-addon"><button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalAgregarProveedor" data-dismiss="modal">Agregar proveedor</button></span>                 
                  </div>             
                </div>
            </div>    
                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 
                <div class="form-group row nuevoProducto">
                <?php             
                    $listaProductoC = json_decode($compra["productos"], true);
                    // var_dump($listaProductoC);
                    foreach($listaProductoC as $key =>$value){

                        $item = "id";
                        $valor = $value["id"];
                        $orden = "id";

                        $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
                        // var_dump($respuesta);
                        $stockAntiguo = $respuesta["stock"] - $value["cantidad"];
                        echo'
                        
                            <div class="row" style="padding:5px 15px">                                               
                                <div class="col-xs-6" style="padding-right:0px">
                                    <div class="input-group">
                                        <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'"><i class="fa fa-times"></i></button></span>
                                        <input type="text" class="form-control agregarProductoCompra" idProducto="'.$value["id"].'" name="agregarProductoCompra" value="'.$value["nombre"].'" readonly required>
                                    </div>
                                </div>                                
                                <div class="col-xs-3">
                                    <input type="number" class="form-control nuevaCantidadProductoC" name="nuevaCantidadProductoC" min="1" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStockC="'.$value["stock"].'" required>
                                </div>
                              
                                <div class="col-xs-3 ingresoPrecioC" style="padding-left:0px">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                        <input type="text" class="form-control nuevoPrecioProductoC" precioRealC="'.$respuesta["precio_compra"].'" name="nuevoPrecioProductoC" value="'.$value["total"].'" readonly required>                        
                                    </div>
                                </div>
                            </div> ';
                    }
                ?>
                </div>
                <input type="hidden" id="listaProductosC" name="listaProductosC">
                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->
                <button type="button" class="btn btn-default hidden-lg btnAgregarProductoC">Agregar producto</button>
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
                              <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoCompra" name="nuevoImpuestoCompra" value="<?php echo $porcentajeImpuestoC; ?>" required readonly>
                              <input type="hidden" name="nuevoPrecioImpuestoC" id="nuevoPrecioImpuestoC" value="<?php echo $compra["impuesto"]; ?>" required>
                              <input type="hidden" name="nuevoPrecioNetoC" id="nuevoPrecioNetoC" value="<?php echo $compra["neto"]; ?>" required>
                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>                   
                            </div>
                          </td>
                           <td style="width: 50%">                           
                            <div class="input-group">                           
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="text" class="form-control input-lg" id="nuevoTotalCompra" name="nuevoTotalCompra" total="" value="<?php echo $compra["total"]; ?>" readonly required>
                              <input type="hidden" name="totalCompra" value="<?php echo $compra["total"]; ?>" id="totalCompra">                        
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <hr>
                <!--=====================================
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
                      <input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly required>
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
          $editarCompra = new ControladorCompras();
          $editarCompra -> ctrEditarCompra();
        ?>
        </div>           
      </div>
      

    </div>
  </section>
</div>
