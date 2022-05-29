<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

require_once "../controladores/sucursal.controlador.php";
require_once "../modelos/sucursal.modelo.php";


class TablaProductosfiltro
{

  /*======================================= 
  MOSTRAR LA TABLA DE PRODUCTOS 
  ===================================*/
  public function mostrarTablaProductosFiltro()
  {

    $item = null;
    $valor = null;
    $orden = "id";
    $productos = ControladorProductos::ctrMostrarProductosVencidos();
    //SI LA TABLA ESTA VACIA SE MOSTRARA DE IGUAL FORMA LOS PRODUCTOS CON ESTA CONDICIONAL
    if (count($productos) != 0) {
      $datosJson = '{
			"data": [';

      for ($i = 0; $i < count($productos); $i++) {
        /*============================================= 
        TRAEMOS LA IMAGEN 
        =============================================*/
       // $imagen = "<img src='" . $productos[$i]["imagen"] . "' width='40px'>";
        /*============================================ 
        TRAEMOS LA CATEGORÍA 
        =============================================*/
        $item = "id";
        $valor = $productos[$i]["id_categoria"];
        $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
        /*============================================ 
        TRAEMOS LA SUCURSAL 
        =============================================*/
        $item = "id";
        $valor = $productos[$i]["idSucursal"];
        $sucursal = ControladorSucursal::ctrMostrarSucursal($item, $valor);
        /*============================================= 
        STOCK 
        =============================================*/
        if ($productos[$i]["stock"] <= 10) {
          $stock = "<button class='btn btn-danger'>" . $productos[$i]["stock"] . "</button>";
        } else if ($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 19) {
          $stock = "<button class='btn btn-warning'>" . $productos[$i]["stock"] . "</button>";
        } else {
          $stock = "<button class='btn btn-success'>" . $productos[$i]["stock"] . "</button>";
        }
        /*============================================= 
        TRAEMOS LAS ACCIONES 
        =============================================*/
        $botones = "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='" . $productos[$i]["id"] . "' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProducto' idProducto='" . $productos[$i]["id"] . "' codigo='" . $productos[$i]["codigo"] . "' imagen='" . $productos[$i]["imagen"] . "'><i class='fa fa-times'></i></button></div>";
        $datosJson .= '[
						"' . ($i + 1) . '",
				
						"' . $productos[$i]["codigo"] . '",
						"' . $productos[$i]["nombre"] . '",
						"' . $categorias["categoria"] . '",
						"' . $sucursal["sede"] . '",
						"' . $stock . '",
						"$ ' . number_format($productos[$i]["precio_compra"], 2) . '",
			      "$ ' . number_format($productos[$i]["precio_venta"], 2) . '",
            "' . $productos[$i]["fecha_vencimiento"] . '",
						"' . $productos[$i]["descripcion"] . '",
						"' . $productos[$i]["fecha"] . '",
						"' . $botones . '"
			    	],';
      }
      $datosJson = substr($datosJson, 0, -1);
      $datosJson .=   ']}';
      echo $datosJson;
    } else {
      echo '{
        	"data":[]
        }';
    }
  }
}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS 
=============================================*/
$activarProductos = new TablaProductosfiltro();
$activarProductos->mostrarTablaProductosFiltro();
