<?php
if ($_SESSION["perfil"] != "Administrador") {
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <span><i class="fa fa-product-hunt"></i></span>
      Modulo de Productos Generales
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Administrar productos</li>
    </ol>
  </section>
  <section class="content">

    <div class="box box-success">
      <div class="box-header with-border">
        <button class="btn btn-flat btn-default" data-toggle="modal" data-target="#modalAgregarProducto"> Agregar productos</button>
      </div>
      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaProductosPorVencer text-center" width="100%">

          <thead>
            <tr>

              <th style="width:10px">#</th>

              <th>Código</th>
              <th>Nombre</th>
              <th>Categoria</th>
              <th>Sucursal</th>
              <th>Stock</th>
              <th>Precio_Compra</th>
              <th>Precio_Venta</th>
              <th>F_vencimiento</th>
              <th>Observaciones</th>
              <th>Agregado</th>
              <th>Acciones</th>

            </tr>
          </thead>

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
<div id="modalAgregarProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
    CABEZA DEL MODAL
    ======================================-->
        <div class="modal-header" style="background:#00a65a; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registro de Productos</h4>
        </div>
        <!--=====================================
  CUERPO DEL MODAL
  ======================================-->
        <div class="modal-body">
          <div class="box-body">

            <div class="form-group">
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select class="form-control input-lg" id="nuevaSucursal" name="nuevaSucursal" required>
                  <option value="">Sucursal</option>

                  <?php
                  $item = null;
                  $valor = null;

                  $sucursal = ControladorSucursal::ctrMostrarSucursal($item, $valor);
                  foreach ($sucursal as $key => $value) {
                    echo '<option value="' . $value["id"] . '">' . $value["sede"] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
            <div class="form-group">
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required>
                  <option value="">Selecionar categoria</option>

                  <?php
                  $item = null;
                  $valor = null;

                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                  foreach ($categorias as $key => $value) {
                    echo '<option value="' . $value["id"] . '">' . $value["categoria"] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <!-- ENTRADA PARA EL CÓDIGO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="Codigo del Producto" required>
                <span class="input-group-btn">
                  <!--   <button type="button" class="btn btn-primary btn-xs form-control input-lg" onClick="getCodigoProducto()"><i class="glyphicon glyphicon-repeat"></i> Generar</button>  -->
                </span>
              </div>
            </div>
            <!-- ENTRADA PARA EL CÓDIGO INTERNO -->

            <!-- ENTRADA PARA NOMBRE -->
            <div class="form-group">

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoNombre" placeholder="Ingresar nombre" required>
              </div>

            </div>
            <!-- ENTRADA PARA STOCK -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                <input type="number" class="form-control input-lg" id="nuevoStock" name="nuevoStock" min="0" placeholder="Stock" required>
              </div>
            </div>
            <!-- ENTRADA PARA PRECIO COMPRA / VENTA-->
            <div class="form-group row">

              <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                  <input type="number" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" min="0" step="any" placeholder="Precio de compra" required>
                </div>
              </div>
              
             <!-- ENTRADA PARA PRECIO VENTA -->

             <div class="col-xs-6">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                  <input type="number" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" step="any" min="0" placeholder="Precio de venta" required>

                </div>
              
                <br>

                <!-- CHECKBOX PARA PORCENTAJE -->

                <div class="col-xs-6">
                  
                  <div class="form-group">
                    
                    <label>
                      
                      <input type="checkbox" class="minimal porcentaje" checked>
                      Utilizar procentaje
                    </label>

                  </div>

                </div>

                <!-- ENTRADA PARA PORCENTAJE -->

                <div class="col-xs-6" style="padding:0">
                  
                  <div class="input-group">
                    
                    <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>

                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                  </div>

                </div>

                

              </div>

              </div><!--fin form group-->
                  



              <!-- ENTRADA PARA LA FECHA DE VENCIMIENTO -->
              <strong>fecha vencimiento</strong>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  <input type="date" class="form-control input-lg" name="nuevaFechaVencimiento" placeholder="Fecha Vencimiento">
                </div>
              </div>

            

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar descripción o notas">
              </div>
            </div>



          </div>
        </div>
        <!--=====================================
    PIE DEL MODAL
    ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-dark">Guardar producto</button>
        </div>
      </form>
      <?php
      $crearProducto = new ControladorProductos();
      $crearProducto->ctrCrearProducto();
      ?>
    </div>
  </div>
</div>

<!--=====================================
  MODAL EDITAR PRODUCTO
  ======================================-->
<div id="modalEditarProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
  CABEZA DEL MODAL
  ======================================-->
        <div class="modal-header" style="background:#00a65a; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar producto</h4>
        </div>
        <!--=====================================
  CUERPO DEL MODAL 
  ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select class="form-control input-lg" name="editarCategoria" readonly required>
                  <option id="editarCategoria"></option>
                </select>
              </div>
            </div>
            <!-- ENTRADA PARA SURCURSAL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select class="form-control input-lg" name="editarSucursal" readonly required>
                  <option id="editarSucursal"></option>
                </select>
              </div>
            </div>
            <!-- ENTRADA PARA EL CÓDIGO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" readonly required>
                <input type="hidden" class="form-control input-lg" id="id" name="id" readonly required>
              </div>
            </div>
            <!-- ENTRADA PARA EL CÓDIGO INTERNO  
          <div class="form-group">
              <div class="input-group">          
                <span class="input-group-addon"><i class="fa fa-barcode"></i></span> 
                <input type="text" class="form-control input-lg" id="editarCodigo2" name="editarCodigo2" readonly required>
              </div>
          </div>    
          -->
            <!-- ENTRADA PARA LA NOMBRE-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" required>
              </div>
            </div>
            <!-- ENTRADA PARA STOCK -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                <input type="number" class="form-control input-lg" id="editarStock" name="editarStock" min="0" required>
              </div>
            </div>
            <!-- ENTRADA PARA PRECIO COMPRA -->
            <div class="form-group row">
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                  <input type="number" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" step="any" min="0" required>
                </div>
              </div>
              <!-- ENTRADA PARA PRECIO VENTA -->

              <div class="col-xs-6">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                  <input type="number" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0"  required>

                </div>
              
                <br>

                <!-- CHECKBOX PARA PORCENTAJE -->

                <div class="col-xs-6">
                  
                  <div class="form-group">
                    
                    <label>
                      
                      <input type="checkbox" class="minimal porcentaje" checked>
                      Utilizar procentaje
                    </label>

                  </div>

                </div>

                <!-- ENTRADA PARA PORCENTAJE -->

                <div class="col-xs-6" style="padding:0">
                  
                  <div class="input-group">
                    
                    <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>

                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                  </div>

                </div>

              </div>



            </div>

            <!-- ENTRADA PARA LA FECHA DE VENCIMIENTO -->

            <div class="form-group">
              <strong>fecha vencimiento</strong>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="date" class="form-control input-lg" id="editarFechaVencimiento" name="editarFechaVencimiento">
              </div>
            </div>
            <!-- ENTRADA PARA LA DESCRIPCIÓN -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion">
              </div>
            </div>


          </div>
        </div>
        <!--=====================================PIE DEL MODAL======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-flat btn-dark">Guardar cambios</button>
        </div>
      </form>

      <?php
      $editarProducto = new ControladorProductos();
      $editarProducto->ctrEditarProducto();

      ?>
    </div>
  </div>
</div>

<?php

$eliminarProducto = new ControladorProductos();
$eliminarProducto->ctrEliminarProducto();

?>