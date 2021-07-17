<?php

/*==========================================================================
REQUERIR CONTROLADORES Y MODELOS IMPLICADOS EN EL PROCESO
==========================================================================*/

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/tipocomprobante.controlador.php";
require_once "../modelos/tipocomprobante.modelo.php";

class TablaListadoVentas
{

  /*===================================================
  MOSTRAR LA TABLA DE LISTADO VENTAS
  ===================================================*/
  public function mostrarTablaListadoVentas()
  {
    // Definir que item se quiere consultar en la base de datos
    $item = null;
    // Definir el valor que se va a comparar en la consulta en la base de datos PARA COMPRAS ES ID VENDEDOR
    $valor = null;
    // Se pide la respuesta para todas las ventas filtradas por id_vendedor
    $respuesta = ControladorVentas::ctrMostrarVentas($item, $valor);

    if (!$respuesta) {
      // Si no hay respuesta se manda la estructura json vacía
      echo '{"data": []}';
      // Se detiene el script
      return;
    }
    // Si, sí encontro datos entonces se empieza a crear la estructura JSON
    $datosJson = '{"data": [';
    // Se hace un ciclo por cada respuesta para traer sus valores correctos
    foreach ($respuesta as $key => $value) {

      /*=================================
      TRAER EL CLIENTE
      =================================*/
      $itemCliente = "id";
      $valorCliente = $value["id_cliente"];
      $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
      $cliente = $respuestaCliente["razon_social"];
      /*=================================
      TRAER TIPO DE COMPROBANTE
      =================================*/
      $itemComp = "id";
      $valorComp = $value["id_comprobante"];
      $respuestaComp = ControladorComprobante::ctrMostraTipo($itemComp, $valorComp);
      $comprobante = $respuestaComp["comprobante"];
      /*==================================
      TRAER EL VENDEDOR
      ==================================*/
      $itemUsuario = "id";
      $valorUsuario = $value["id_vendedor"];
      $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
      $vendedor = $respuestaUsuario["nombre"];
      /*==============================
      DETALLES DE LOS PRODUCTOS
      ==============================*/
      $productos =  json_decode($value["productos"], true);
      // Cantidad
      $cantidad = '';
      foreach ($productos as $key2 => $value2) {
        $cantidad .= $value2["cantidad"] . '<br>';
      }
      // Codigo de Factura
      //$codigo = '';
      //foreach ($productos as $key2 => $value2) {
       // $cantidad .= $value2["cantidad"] . '<br>';
     // }

      // Listado de productos
      $listadoProductos = '';
      foreach ($productos as $key2 => $value2) {
        $listadoProductos .= $value2["descripcion"] . '<br>';
      }
      // Precio por producto
     // $precioProducto = '';
     // foreach ($productos as $key2 => $value2) {
       // $precioProducto .= "$ " . number_format($value2["precio"], 2) . "<br>";
      //}
      // Total
      $total = '';
      foreach ($productos as $key2 => $value2) {
        $total .= "S/  " . number_format($value2["total"], 2) . "<br>";
      }
      // Metódo de pago
      $metodoPago = $value["metodo_pago"];
      // Neto 
      $neto = "S/ " .number_format($value["neto"],2);
      // Total Venta
      $total2 = "S/ " .number_format($value["total"],2);
      // Fecha venta
      $fecha = date('d/m/Y',strtotime($value["fecha"]));

      /*==================================
      BOTONES DE ACCIÓN
      ==================================*/

     /* $botones = "<div class='btn-group'><button class='btn btn-success btnImprimirFactura' codigoVenta='" . $value["codigo"] . "'><i class='fa fa-print'></i></button>
      <button class='btn btn-danger btnEliminarVenta' idVenta='" . $value["id"] . "'><i class='fa fa-times'></i></button></div>";
      */
      if (isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Vendedor") {
        $botones = "<div class='btn-group'><button class='btn btn-success btnImprimirFactura' codigoVenta='" . $value["codigo"] . "'><i class='fa fa-print'></i></button><button class='btn btn-danger btnEliminarVenta' idventa='" . $value["id"] . "'><i class='fa fa-times'></i></button></div>";
    } else {
      
      $botones = "<div class='btn-group'><button class='btn btn-success btnImprimirFactura' codigoVenta='" . $value["codigo"] . "'><i class='fa fa-print'></i></button><button class='btn btn-warning btnEditarVenta' idVenta='".$value["id"]."' data-toggle='modal' data-target='#modalEditarVenta'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarVenta' idventa='" . $value["id"] . "'><i class='fa fa-times'></i></button></div>";
    };
      /*$botones = "<div class='btn-group'><button class='btn btn-success btnImprimirFactura' codigoVenta='" . $value["codigo"] . "'><i class='fa fa-print'></i></button><button class='btn btn-warning btnEditarVenta' idVenta='".$value["id"]."' data-toggle='modal' data-target='#modalEditarVenta'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarVenta' idventa='" . $value["id"] . "'><i class='fa fa-times'></i></button>";*/
      /*===================================
      DEVOLVER LOS DATOS
      ===================================*/
      $datosJson   .= '[
        "' . ($key + 1) . '",
        "' . $cliente . '",
        "' . $vendedor . '",
        "' . $cantidad . '",
        "' . $listadoProductos . '",
        "' . $total . '",
        "' . $metodoPago . '",
        "' . $comprobante . '",
        "' . $neto . '",	
        "' . $total2 . '",
        "' . $fecha . '",
        "' . $botones . '"
        ],';
    }
    // Remover la última coma
    $datosJson = substr($datosJson, 0, -1);
    // Cerrar etiquetas para los datos JSON
    $datosJson .=   ']
     }';
    // Devolver los datos
    echo $datosJson;
  }
}


/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/
$tablaListadoVentas = new TablaListadoVentas();
$tablaListadoVentas->mostrarTablaListadoVentas();
