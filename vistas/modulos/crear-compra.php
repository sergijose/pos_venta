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
      <div class="col-lg-12 col-xs-10">       
        <div class="box box-primary">
             <section class="content-header">
               <h1>Registro de Compras</h1>
               </section>
          <form role="form" method="post" class="formularioCompra">
            <div class="box-body">
              <div class="box">
<!--=====================================
  ENTRADA DEL COMPRADOR
  ======================================-->
           <div class="col-xs-4">      
                <div class="form-group">  
                <label>USUARIO REGISTRADOR:</label>          
                  <div class="input-group">               
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                    <!-- <input type="text" class="form-control" id="nuevoComprador" name="nuevoComprador" value="Usuario Administrador" readonly> -->
                    <input type="text" class="form-control" id="nuevoComprador" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                    <input type="hidden" name="idComprador" value="<?php echo $_SESSION["id"]; ?>">
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
                      <input type="text" class="form-control" id="nuevaCompra" name="nuevaCompra" placeholder="Codigo / Folio" required>
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
                <span class="input-group-addon"><i class="fa fa-archive"></i></span> 
                <input type="text" value="GENERAL" class="form-control" readonly> 
                <input type="hidden" value="6" class="form-control" id="seleccionarProveedor" name="seleccionarProveedor" readonly> 
              </div>
          </div>
         </div> 
 <!--==================== 
  ENTRADA PARA SUCURSAL
  ======================================-->
       <!--  <input type="hidden" id="idSucursal" name="idSucursal" value="1">  -->
       <input type="hidden" name="idSucursal" value="<?php echo $_SESSION['idSucursal']; ?>" id="idSucursal">  
<!--=====================================
  ENTRADA PARA AGREGAR PRODUCTO
  ======================================--> 
                <div class="form-group row nuevoProducto">
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
                              <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoCompra" name="nuevoImpuestoCompra" value="0"  readonly>
                              <input type="hidden" name="nuevoPrecioImpuestoC" id="nuevoPrecioImpuestoC" required>
                              <input type="hidden" name="nuevoPrecioNetoC" id="nuevoPrecioNetoC" required>
                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                            </div>
                          </td>

                           <td style="width: 50%">
                            
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="text" class="form-control input-lg" id="nuevoTotalCompra" name="nuevoTotalCompra" total="" placeholder="00000" readonly required>
                              <input type="hidden" name="totalCompra" id="totalCompra">
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
                      <input type="hidden" value="Efectivo" class="form-control" id="listaMetodoPagoC" name="listaMetodoPagoC" readonly>
                    </div>
                  </div>
                </div>
                <!-- Aca termina los metodos de pago -->
                <!-- Aca la Caja de Texto para el efectivo pagado por el cliente -->
                <div class="form-group">
                     <div class="col-xs-4">
                       <div class="input-group">
                           <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                          <input type="text" class="form-control" id="nuevoValorEfectivoC" placeholder="000000" required>
                       </div>
                    </div>
                </div> 
                <!-- Aca la Caja de Texto para el Cambio del Efectivo al cliente -->
              <div class="form-group">
                  <div class="input-group">
                     <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                      <input type="text" class="form-control" id="nuevoCambioEfectivoC" placeholder="000000" readonly required>
                  </div>
             </div>
             <!-- Final del Cambio del Efectivo al cliente -->

                <br>
              </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-flat btn-dark pull-right">Guardar compra</button>
          </div>

        </form>
        <?php
          $guardarCompra = new ControladorCompras();
          $guardarCompra -> ctrCrearCompra();
        ?>
        </div>
      </div>


    </div>
  </section>
</div>
