<?php
/*==========================================================================
REQUERIR CONTROLADORES Y MODELOS IMPLICADOS EN EL PROCESO
==========================================================================*/
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/sucursal.controlador.php";
require_once "../modelos/sucursal.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

class TablaSucursalVentas
{

  /*===================================================
  MOSTRAR LA TABLA DE PRODUCTOS
  ===================================================*/
  public function mostrarTablaSucursalVentas()
  {

    // Definir que item se quiere consultar en la base de datos
    $item = "idSucursal";
    // Definir el valor que se va a comparar en la consulta en la base de datos
    $valor = $_GET["sedeoculta"];
    $orden = "id";
    // Se pide la respuesta para todas las ventas filtradas por idSucursal
    $productos = ControladorProductos::ctrMostrarProductoSucursal($item, $valor, $orden);
    
   
    //SI LA TABLA ESTA VACIA SE MOSTRARA DE IGUAL FORMA LOS PRODUCTOS CON ESTA CONDICIONAL
    if (count($productos) == 0) {

      echo '{"data": []}';
      return;
    }
    $datosJson = '{
		  "data": [';

    for ($i = 0; $i < count($productos); $i++) {
      /*=======================================
      Traemos la imagen 
      =============================================*/
      $imagen = "<img src='" . $productos[$i]["imagen"] . "' width='40px'>";
      /*=============================================
      Traemos la Sucursal
      =============================================*/
      $item = "id";
      $valor = $productos[$i]["idSucursal"];
      $sucursal = ControladorSucursal::ctrMostrarSucursal($item, $valor);

      //traemos la categoria
      $item ="id";
      $valor = $productos[$i]["id_categoria"];
      $categorias=ControladorCategorias::ctrMostrarCategorias($item,$valor);
      
        //TRAEMOS EL STOCK     

      if ($productos[$i]["stock"] <= 10) {
        $stock = "<button class='btn btn-danger'>" . $productos[$i]["stock"] . "</button>";
      } else if ($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 19) {
        $stock = "<button class='btn btn-warning'>" . $productos[$i]["stock"] . "</button>";
      } else {
        $stock = "<button class='btn btn-success'>" . $productos[$i]["stock"] . "</button>";
      }
      /*=============================================
      Traemos las acciones
      =============================================*/
      $botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='" . $productos[$i]["id"] . "'>Agregar</button></div>";

      $datosJson .= '[
			      "' . ($i + 1) . '",
			      "' . $productos[$i]["nombre"] . '",
            "' . $categorias["categoria"] . '",
            "' . $productos[$i]["precio_venta"] . '",
			      "' . $stock . '",
			      "' . $botones . '"
			    ],';
    }
    $datosJson = substr($datosJson, 0, -1);
    $datosJson .=   '] 

		 }';
    echo $datosJson;
  }
}
/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/
$activarProductosVentas = new TablaSucursalVentas();
$activarProductosVentas->mostrarTablaSucursalVentas();
