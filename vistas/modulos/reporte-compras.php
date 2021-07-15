<div class="content-wrapper">
  <section class="content-header">
   <h1><strong>Reporte de Compras  : Todas las Sucursales</strong></h1>

  <!-- Aqui Inicia el Grafico de Compras  -->
      <div class="box-header with-border">
          <div class="row">
              <div class="col-xs-12">
                  <?php
                      include "reportes/grafico-compras.php";
                   ?>
                </div>
           </div> 
        </div>
  <!-- Aqui Finaliza el Grafico de Compras  -->

<!-- Aqui empezamos con la Descarga del Reporte -->
  <div class="box-header with-border">

      <div class="box-header with-border">
        <?php
           echo '<a href="vistas/modulos/listado-compras.php?reporte_compras=reporte_compras">'; 
         ?>
           <button class="btn btn-success" style="margin-top:5px"><i class="glyphicon glyphicon-download-alt"></i> Descargar Excel</button>
          </a>
      </div>
      
  </div>
<!-- Aqui terminamos con la Descarga del Reporte -->


      <div class="box-body"> 
       <table id="tablas" class="table table-bordered table-striped dt-responsive tablas text-center" width="100%">
         
        <thead>
         <tr>
           
           <th style="width:10px">#</th>
           <th>Codigo_Factura</th>
           <th>Proveedor</th>
           <th>Sucursal</th>
           <th>Registra:</th>
           <th>Cantidad</th>
           <th>Producto</th>
           <th>TotalXProducto</th>
           <th>Forma_Pago</th>
           <th>Neto</th>
           <th>Total</th> 
           <th>Fecha</th>
          

         </tr> 
        </thead>
        <tbody>

          <?php

            $item=null;
            $valor=null;
            $respuesta = ControladorCompras::ctrMostrarCompras($item, $valor);

            foreach ($respuesta as $key => $value) {
                 echo '<tr>

                  <td>'.($key+1).'</td>
                  <td>'.$value["codigo"].'</td>';

                  $itemProveedor = "id";
                  $valorProveedor = $value["id_proveedor"];
                  $respuestaProveedor = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);
                  echo ' <td>'.$respuestaProveedor["nombre"].'</td>';

                  $itemSucursal = "id";
                  $valorSucursal = $value["idSucursal"];
                  $respuestaSucursal = ControladorSucursal::ctrMostrarSucursal($itemSucursal, $valorSucursal);
                  echo ' <td>'.$respuestaSucursal["sede"].'</td>';

                  $itemUsuario = "id";
                  $valorUsuario = $value["id_usuario"];
                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
                  echo '<td>'.$respuestaUsuario["nombre"].'</td><td>';


                  $productos =  json_decode($value["productos"], true);
                  foreach ($productos as $key => $valueProductos)
                   {
                   echo ($valueProductos["cantidad"].'<br>');
                   } 
                   
                  echo '</td><td>'; 
                  $productos = json_decode($value["productos"], true);
                  foreach ($productos as $key2 => $value2) {
                   echo $value2["nombre"] . '<br>';
                  }echo '</td>';

                  echo '</td><td>'; 
                  $productos = json_decode($value["productos"], true);
                  foreach ($productos as $key2 => $value2) {
                  echo "$ ".number_format($value2["total"],2)."<br>";
                  }echo '</td>';
                  
                  echo'</td><td>'.$value["metodo_pago"].'</td></td>';

                  echo '</td><td>$ '.number_format($value["neto"],2).'</td>
                  <td>$ '.number_format($value["total"],2).'</td>
                  <td>'.$value["fecha"].'</td>
                  
                </tr>';
            }
        ?>
               
        </tbody>
       </table>

      </div>
    </div>
  </section>
</div>




