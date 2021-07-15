<?php

class ControladorCompras
{
  /*=====================================   
   MOSTRAR COMPRAS SIN FILTRO
   ======================================*/ 
  static public function ctrMostrarCompras($item, $valor)
  {
    $tabla = "compras";
    $respuesta = ModeloCompras::mdlMostrarCompras($tabla, $item, $valor);
    return $respuesta;
  }
  /*=====================================   
   MOSTRAR COMPRAS CON FILTRO POR IDVENDEDOR
   ======================================*/ 
  static public function ctrMostrarCompras2($item, $valor)
  {
    $tabla = "compras";
    $respuesta = ModeloCompras::mdlMostrarCompras2($tabla, $item, $valor);
  
    return $respuesta;
  }

  /*============================= 
  Registrando Nueva Compra 
  =====================================*/
  static public function ctrCrearCompra()
  {
    if (isset($_POST["nuevaCompra"])) {
      /*============================================================================================= 
      ACTUALIZAR LAS VENTAS DEL PROVEEDOR, AUMENTAR EL STOCK Y AUMENTAR LAS COMPRAS DE LOS PRODUCTOS
      ===============================================================================================*/
      $listaProductosC = json_decode($_POST["listaProductosC"], true);
      $totalProductosVendidos = array();

      foreach ($listaProductosC as $key => $value) {

        array_push($totalProductosVendidos, $value["cantidad"]);

        $tablaProductos = "productos";

        $item = "id";
        $valor = $value["id"];
        $orden = "id";

        $traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);
        $item1a = "compras";
        $valor1a = $value["cantidad"] + $traerProducto["compras"];

        $nuevasCompras = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);
        $item1b = "stock";
        $valor1b = $value["stock"];

        $nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
      }

      $tablaProveedores = "proveedores";

      $item = "id";
      $valor = $_POST["seleccionarProveedor"];
      $traerProveedor = ModeloProveedores::mdlMostrarProveedores($tablaProveedores, $item, $valor);

      $item1a = "ventas";
      $valor1a = array_sum($totalProductosVendidos) + $traerProveedor["ventas"];
      $ventasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1a, $valor1a, $valor);

      $item1b = "ultima_venta";
      date_default_timezone_set('America/Bogota');

      $fecha = date('Y-m-d');
      $hora = date('H:i:s');
      $valor1b = $fecha . ' ' . $hora;

      $fechaProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1b, $valor1b, $valor);
      /*=====================================
      GUARDAR LA COMPRA
      =====================================*/
      $tabla = "compras";
      // var_dump($tabla);
      $datos = array(
        "id_usuario" => $_POST["idComprador"],
        "id_proveedor" => $_POST["seleccionarProveedor"],
        "idSucursal" => $_POST["idSucursal"],
        "codigo" => $_POST["nuevaCompra"],
        "productos" => $_POST["listaProductosC"],
        "impuesto" => $_POST["nuevoPrecioImpuestoC"],
        "neto" => $_POST["nuevoPrecioNetoC"],
        "total" => $_POST["totalCompra"],
        "metodo_pago" => $_POST["listaMetodoPagoC"]
      );

      $respuesta = ModeloCompras::mdlIngresarCompra($tabla, $datos);

      if ($respuesta == "ok") {
        echo '<script>
                    localStorage.removeItem("rango");

                    swal({
                        type: "success",
                        title: "La compra ha sido guardada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then((result)=>{
                            if(result.value){
                                window.location = "compras";
                            }
                        })
                    </script>';
      }
    }
  }

  /*=============================================
  SUMA TOTAL COMPRAS 
  =============================================*/
  public function ctrSumaTotalCompras()
  {
    $tabla = "compras";
    $respuesta = ModeloCompras::mdlSumaTotalCompras($tabla);
    return $respuesta;
  }

  /*==================================== 
  RANGO FECHAS 
  =============================================*/
  static public function ctrRangoFechasCompras($fechaInicial, $fechaFinal)
  {
    $tabla = "compras";
    //$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);
    $respuesta = ModeloCompras::mdlRangoFechasCompras($tabla, $fechaInicial, $fechaFinal);
    return $respuesta;
  }
  /*===================================== 
  EDITAR COMPRA 
  =====================================*/
  static public function ctrEditarCompra()
  {

    if (isset($_POST["editarCompra"])) {
      /*=====================================
      FORMATEAR LA TABLA DE PRODUCTOS Y DE PROVEEDORES
      =============*/
      $tabla = "compras";
      $item = "codigo";
      $valor = $_POST["editarCompra"];
      $orden = "id";
      $traerCompra = ModeloCompras::mdlMostrarCompras($tabla, $item, $valor, $orden);
      $productosC = json_decode($traerCompra[0]["productos"], true);
      // var_dump($productosC);
      $totalProductosVendidos = array();

      foreach ($productosC as $key => $value) {

        array_push($totalProductosVendidos, $value["cantidad"]);
        $tablaProductos = "productos";

        $item = "id";
        $valor = $value["id"];
        $orden = "id";
        $traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

        $item1a = "compras";
        $valor1a = $traerProducto["compras"] - $value["cantidad"];
        $nuevasCompras = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);
        $item1b = "stock";
        $valor1b = $traerProducto["stock"] - $value["cantidad"];
        $nuevoStockC = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
        // var_dump($valor1b);
      }
      $tablaProveedores = "proveedores";

      $itemProveedor = "id";
      $valorProveedor = $_POST["seleccionarProveedor"];

      $traerProveedor = ModeloProveedores::mdlMostrarProveedores($tablaProveedores, $itemProveedor, $valorProveedor);

      $item1a = "ventas";
      $valor1a = $traerProveedor["ventas"] - array_sum($totalProductosVendidos);

      $ventasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1a, $valor1a, $valor);

      /*=====================================
          ACTUALIZAR LAS VENTAS DEL PROVEEDOR, AUMENTAR EL STOCK Y AUMENTAR LAS COMPRAS DE LOS PRODUCTOS
      =====================================*/
      $listaProductosC_2 = json_decode($_POST["listaProductosC"], true);

      $totalProductosVendidos_2 = array();

      foreach ($listaProductosC_2 as $key => $value) {
        array_push($totalProductosVendidos_2, $value["cantidad"]);
        $tablaProductos_2 = "productos";

        $item_2 = "id";
        $valor_2 = $value["id"];
        $orden = "id";

        $traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $orden);

        $item1a_2 = "compras";
        $valor1a_2 = $value["cantidad"] + $traerProducto["compras"];

        $nuevasCompras_2 = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

        $item1b_2 = "stock";
        $valor1b_2 = $value["stock"];

        $nuevoStockC_2 = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
      }

      $tablaProveedores_2 = "proveedores";

      $item_2 = "id";
      $valor_2 = $_POST["seleccionarProveedor"];

      $traerProveedor_2 = ModeloProveedores::mdlMostrarProveedores($tablaProveedores, $item, $valor);

      $item1a_2 = "ventas";
      $valor1a_2 = array_sum($totalProductosVendidos) + $traerProveedor["ventas"];

      $ventasProveedor_2 = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1a, $valor1a, $valor);

      $item1b_2 = "ultima_venta";
      date_default_timezone_set('America/Bogota');

      $fecha = date('Y-m-d');
      $hora = date('H:i:s');
      $valor1b_2 = $fecha . ' ' . $hora;

      $fechaProveedor_2 = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1b, $valor1b, $valor);


   /*=====================================
      GUARDAR CAMBIOS DE LA COMPRA
    =====================================*/
      $tabla = "compras";
      // var_dump($tabla);
      $datos = array(
        "id_usuario" => $_POST["idComprador"],
        "id_proveedor" => $_POST["seleccionarProveedor"],
        "codigo" => $_POST["editarCompra"],
        "productos" => $_POST["listaProductosC"],
        "impuesto" => $_POST["nuevoPrecioImpuestoC"],
        "neto" => $_POST["nuevoPrecioNetoC"],
        "total" => $_POST["totalCompra"],
        "metodo_pago" => $_POST["listaMetodoPagoC"]);

      $respuesta = ModeloCompras::mdlEditarCompra($tabla, $datos);

      if ($respuesta == "ok") {

        echo '<script>
                    localStorage.removeItem("rango");
                    swal({
                        type: "success",
                        title: "La compra ha sido editada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then((result)=>{
                            if(result.value){
                                window.location = "compras";
                            }
                        })
                    </script>';
      }
    }
  }//Llave de la funcion Editar Compra

 /*=============================================
  DESCARGAR EXCEL
  =============================================*/
  public function ctrDescargarReporte(){

    if(isset($_GET["reporte_compras"])){ //Este es el nombre del objeto creado el lista-compras.php

      $tabla = "compras";
     // Con esto hacemos el Reporte de toda la data
      $item = null;
      $valor = null;
      $compras = ModeloCompras::mdlMostrarCompras($tabla, $item, $valor);
      
       /*=============================================
      CREAMOS EL ARCHIVO DE EXCEL
      =============================================*/
      $Name = $_GET["reporte_compras"].'.xls';

      header('Expires: 0');
      header('Cache-control: private');
      header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
      header("Cache-Control: cache, must-revalidate"); 
      header('Content-Description: File Transfer');
      header('Last-Modified: '.date('D, d M Y H:i:s'));
      header("Pragma: public"); 
      header('Content-Disposition:; filename="'.$Name.'"');
      header("Content-Transfer-Encoding: binary");

      echo utf8_decode("<table border='0'> 

          <tr> 
          <td style='font-weight:bold; border:1px solid #eee;'>NºFACTURA</td> 
          <td style='font-weight:bold; border:1px solid #eee;'>USUARIO</td>
          <td style='font-weight:bold; border:1px solid #eee;'>PROVEEDOR</td>
          <td style='font-weight:bold; border:1px solid #eee;'>SUCURSAL</td>
          <td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
          <td style='font-weight:bold; border:1px solid #eee;'>PRODUCTO</td>
          <td style='font-weight:bold; border:1px solid #eee;'>TOTAL_POR_PRODUCTO</td>
          <td style='font-weight:bold; border:1px solid #eee;'>FORMA_PAGO</td> 
          <td style='font-weight:bold; border:1px solid #eee;'>NETO_DE_PAGO</td>
          <td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>  
          <td style='font-weight:bold; border:1px solid #eee;'>FECHA_DE_COMPRA</td>              
          </tr>");

        foreach ($compras as $row => $item){

        $proveedores = ControladorProveedores::ctrMostrarProveedores("id", $item["id_proveedor"]);
        $sucursal = ControladorSucursal::ctrMostrarSucursal("id", $item["idSucursal"]);
        $usuario = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_usuario"]);

        echo utf8_decode("</td>
          <td style='border:1px solid #eee;'> ".$item["codigo"]."</td>
          <td style='border:1px solid #eee;'>".$usuario["nombre"]."</td>
          <td style='border:1px solid #eee;'>".$proveedores["nombre"]."</td>
          <td style='border:1px solid #eee;'>".$sucursal["sede"]."</td>
          <td style='border:1px solid #eee;'>");

          $productos =  json_decode($item["productos"], true);
        foreach ($productos as $key => $valueProductos) {
          echo utf8_decode($valueProductos["cantidad"] . "<br>");
        }

        echo utf8_decode("</td><td style='border:1px solid #eee;'>");
        foreach ($productos as $key => $valueProductos) {
          echo utf8_decode($valueProductos["nombre"] . "<br>");
        }

        echo utf8_decode("</td><td style='border:1px solid #eee;'>");
        foreach ($productos as $key => $valueProductos) {
          echo utf8_decode("$".number_format($valueProductos["precio"], 2) . "<br>");
        }
           
         echo utf8_decode("</td>
          <td style='border:1px solid #eee;'>" . $item["metodo_pago"] . "</td>
          <td style='border:1px solid #eee;'>$ " . number_format($item["neto"], 2) . "</td>
          <td style='border:1px solid #eee;'>$ " . number_format($item["total"], 2) . "</td>
          <td style='border:1px solid #eee;'>" . substr($item["fecha"], 0, 10) . "</td>   
          </tr>");
      }// Llave den foreach


      echo "</table>";
    }// Llave del isset
  }//Final de Fncion DescargarReporte







}//Llave de la Clase Principal