<?php

/*==========================================================================
REQUERIR CONTROLADORES Y MODELOS IMPLICADOS EN EL PROCESO
==========================================================================*/

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/compras.controlador.php";
require_once "../modelos/compras.modelo.php";

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/sucursal.controlador.php";
require_once "../modelos/sucursal.modelo.php";

class TablaListadoCompras
{

  /*===================================================
  MOSTRAR LA TABLA DE LISTADO VENTAS
  ===================================================*/
  public function mostrarTablaListadoCompras()
  {
    // Definir que item se quiere consultar en la base de datos
    //$item = "id_usuario";
    $item = "idSucursal";

    // Definir el valor que se va a comparar en la consulta en la base de datos
   // $valor = $_GET["idUsuario"];
   $valor = $_GET["idSede"];

    // Se pide la respuesta para todas las ventas filtradas por id_vendedor
    $respuesta = ControladorCompras::ctrMostrarCompras($item, $valor);

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
      Traemos el Proveedor
      =================================*/
      $item = "id";
      $valor = $value["id_proveedor"];
      $respuesta = ControladorProveedores::ctrMostrarProveedores($item, $valor);
      $reclutador = $respuesta["nombre"];

      /*=================================
      Mostramos la Sucursal
      =================================*/
      $item = "id";
      $valor = $value["idSucursal"];
      $respuesta = ControladorSucursal::ctrMostrarSucursal($item, $valor);
      $almacen = $respuesta["sede"];

      /*==================================
      Traemos el Vendedor / Registrador
      ==================================*/
      $item = "id";
      $valor = $value["id_usuario"];
      $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
      $vendedor = $respuesta["nombre"];
      /*==============================
      Detalles de los Productos
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
      foreach ($productos as $key3 => $value3) {
        $listadoProductos .= $value3["nombre"] . '<br>';
      }
      // Precio por producto
      // $precioProducto = '';
      // foreach ($productos as $key2 => $value2) {
      // $precioProducto .= "$ " . number_format($value2["precio"], 2) . "<br>";
      //}
      // Total
      $total = '';
      foreach ($productos as $key4 => $value4) {
        $total .= "$ " . number_format($value4["total"], 2) . "<br>";
      }
      // Metódo de pago
      $metodoPago = $value["metodo_pago"];
      // Neto 
      $neto = "$" . number_format($value["neto"], 2);
      // Total Venta
      $total2 = "$" . number_format($value["total"], 2);
      // Fecha venta
      $fecha = $value["fecha"];

      /*===================================
      DEVOLVER LOS DATOS
      ===================================*/
      $datosJson   .= '[
        "' . ($key + 1) . '",
        "' . $reclutador . '",
        "' . $almacen . '",
        "' . $vendedor . '",
        "' . $cantidad . '",
        "' . $listadoProductos . '",
        "' . $total . '",
        "' . $metodoPago . '",
        "' . $neto . '",  
        "' . $total2 . '",
        "' . $fecha . '"
        ],';
    }
    // Remover la última coma
    $datosJson = substr($datosJson, 0, -1);
    // Cerrar etiquetas para los datos JSON
    $datosJson .= '] }';
    // Devolver los datos
    echo $datosJson;
  }
}


/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/
$tablaListadoCompras = new TablaListadoCompras();
$tablaListadoCompras->mostrarTablaListadoCompras();