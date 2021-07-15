<?php
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/sucursal.controlador.php";
require_once "../modelos/sucursal.modelo.php";
class TablaProductosVentas
{

  /*===================================================
  MOSTRAR LA TABLA DE PRODUCTOS
  ===================================================*/
  public function mostrarTablaProductosVentas()
  {

    // Definir que item se quiere consultar en la base de datos
    $item = null;
    // Definir el valor que se va a comparar en la consulta en la base de datos
    $valor = null;
    $orden = "id";
    

    $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
    if (count($productos) == 0) {

      echo '{"data": []}';
      return;
    }
    $datosJson = '{
		  "data": [';

    for ($i = 0; $i < count($productos); $i++) {
      /*=======================================Traemos la imagen =============================================*/
      $imagen = "<img src='" . $productos[$i]["imagen"] . "' width='40px'>";
      /*=============================================Traemos la Sucursal=============================================*/
      $item = "id";
      $valor = $productos[$i]["idSucursal"];
      $sucursal = ControladorSucursal::ctrMostrarSucursal($item, $valor);
      /*=============================================Stock del producto/*=============================================*/
      if ($productos[$i]["stock"] <= 10) {
        $stock = "<button class='btn btn-danger'>" . $productos[$i]["stock"] . "</button>";
      } else if ($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 19) {
        $stock = "<button class='btn btn-warning'>" . $productos[$i]["stock"] . "</button>";
      } else {
        $stock = "<button class='btn btn-success'>" . $productos[$i]["stock"] . "</button>";
      }
      /*=============================================Traemos las acciones=============================================*/
      $botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='" . $productos[$i]["id"] . "'>Agregar</button></div>";

      $datosJson .= '[
			      "' . ($i + 1) . '",
			      "' . $productos[$i]["codigo"] . '",
			      "' . $productos[$i]["nombre"] . '",
                  "' . $sucursal["sede"] . '",
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
/*=============================================ACTIVAR TABLA DE PRODUCTOS=============================================*/
$activarProductosVentas = new TablaProductosVentas();
$activarProductosVentas->mostrarTablaProductosVentas();
