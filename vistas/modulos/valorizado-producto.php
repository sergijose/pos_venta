<?php
if($_SESSION["perfil"] == "Especial"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>

<div class="content-wrapper">
  <section class="content-header">  
    <h1>Modulo Inventario : Valorizado de Productos</h1>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <!-- COLOCAR BOTONES SI ES QUE SE NECESITAN -->
      </div>

      <div class="box-body">       
       <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas text-center" width="100%">
        <thead>
         <tr>  
           <th style="width:10px">#</th>
           
           <th>Producto</th>
           <th>Stock_Actual</th>
           <th>Precio_De_Compra</th>
           <th>Valor_De_Stock</th>
           <th>Cantidad_De_Ventas</th>
           <th>Valor_De_Ventas</th>
    
          
         </tr> 
        </thead>
        <tbody>

        <?php
        $item = null;
        $valor = null;
        $productos = ControladorProductos::ctrMuestraCtm($item, $valor);

       foreach ($productos as $key => $value){
         // INICIO:CALCULAMOS EL INVENTARIO VALORIZADO
          $cantidad = ($value["stock"]);
          $cproducto = ($value["ventas"]);
          $precio = ($value["precio_compra"]);
          $precio_venta =($value["precio_venta"]);

          $costo = ($cantidad * $precio);
          $stotal =($cproducto*$precio_venta);
         // FINAL : CALCULO DE INVENTARIO VALORIZADO
          echo ' <tr>
                  <td>'.($key+1).'</td>

                  <td>'.$value["nombre"].'</td>';
   
                  // INICIO DE COLOR DEL BOTON DEPENDIENDO EL ESTADO
                  if($value["stock"] <= 10){
                    echo '<td><button class="btn btn-danger btn-xs">'.$value["stock"].'</button></td>';
                    }else if($value["stock"] > 11 && $value["stock"] <= 15){
                     echo '<td><button class="btn btn-warning btn-xs">'.$value["stock"].'</button></td>';
                    }else{
                       echo '<td><button class="btn btn-success btn-xs">'.$value["stock"].'</button></td>';
                         }
                  // FINAL DE COLOR DEL BOTON DEPENDIENDO EL ESTADO
                         
                  //MOSTRAMOS PRECIO DE COMPRA Y TOTAL
                  echo '<td>$ '.number_format($value["precio_compra"],2).'</td>';
                  echo '<td>$ '.number_format($costo,2).'</td> 
                 
                  <td>'.$value["ventas"].'</td>
                  <td>$ '.number_format($stotal,2).'</td>
                  

                </tr>';
        }
        ?> 
        </tbody>
       </table>
      </div>
    </div>
  </section>
</div>