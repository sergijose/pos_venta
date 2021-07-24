<?php

require_once "conexion.php";

class ModeloVentas
{

  /*======================================= 
  MOSTRAR VENTAS 
  =============================================*/
  // static public function mdlMostrarVentas($tabla, $item, $valor, $idUsuario)
  // {
  //   if ($item != null) {
  //     $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $idUsuario = :$idUsuario $item = :$item ORDER BY id ASC");
  //     $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
  //     $stmt->bindParam(":" . $idUsuario, $idUsuario, PDO::PARAM_INT);
  //     $stmt->execute();
  //     return $stmt->fetch();
  //   } else {
  //     $stmt = Conexion::conectar()->prepare("SELECT *,DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM $tabla");
  //     $stmt->execute();
  //     return $stmt->fetchAll();
  //   }
  //   // $stmt -> close();
  //   $stmt = null;
  // }
/*======================================= 
MOSTRAR VENTAS CON FILTRO DE VENDEDOR 
=============================================*/
  static public function mdlMostrarVentas($tabla, $item, $valor)
  {

    if ($item != null) {

      // Aquí se compara con el valor que viene dinamico que vendria siendo id_vendedor
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");
      // Aquí se pasa el parametro con los valores...
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      // Esto no sirve acá
      // $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchAll();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT *,DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM $tabla");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    // $stmt -> close();
    $stmt = null;
  }


  /*=============================================
	REGISTRO DE VENTA
	=============================================*/
  static public function mdlIngresarVenta($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_cliente, id_vendedor, productos, impuesto, neto, total, metodo_pago, pagocon, vuelto, codigoTransaccion, id_comprobante) VALUES (:codigo, :id_cliente, :id_vendedor, :productos, :impuesto, :neto, :total, :metodo_pago, :pagocon, :vuelto, :codigoTransaccion, :id_comprobante)");

    $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
    $stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
    $stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
    $stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
    $stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
    $stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
    $stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
    $stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
    // Aqui se graba el dinero que pago el cliente
    $stmt->bindParam(":pagocon", $datos["pagocon"], PDO::PARAM_STR);
    $stmt->bindParam(":vuelto", $datos["vuelto"], PDO::PARAM_STR);
    $stmt->bindParam(":codigoTransaccion", $datos["codigoTransaccion"], PDO::PARAM_STR);
    $stmt->bindParam(":id_comprobante", $datos["id_comprobante"], PDO::PARAM_INT);


    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }

    // $stmt->close();
    $stmt = null;
  }

  /*=============================================
  EDITAR VENTA
  =============================================*/
  static public function mdlEditarVenta($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, impuesto = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago WHERE codigo = :codigo");

    $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
    $stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
    $stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
    $stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
    $stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
    $stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
    $stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
    $stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }

    // $stmt->close();
    $stmt = null;
  }
  /*=============================================
  ELIMINAR VENTA
  =============================================*/
  static public function mdlEliminarVenta($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
    $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }
    // $stmt -> close();
    $stmt = null;
  }
  /*================================ 
  RANGO FECHAS 
  =============================================*/
  static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal)
  {

    if ($fechaInicial == null) {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");
      $stmt->execute();
      return $stmt->fetchAll();
    } else if ($fechaInicial == $fechaFinal) {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%'");
      $stmt->bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetchAll();
    } else {

      $fechaActual = new DateTime();
      $fechaActual->add(new DateInterval("P1D"));
      $fechaActualMasUno = $fechaActual->format("Y-m-d");

      $fechaFinal2 = new DateTime($fechaFinal);
      $fechaFinal2->add(new DateInterval("P1D"));
      $fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

      if ($fechaFinalMasUno == $fechaActualMasUno) {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
      } else {


        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");
      }

      // $stmt -> execute();
      return $stmt->fetchAll();
    }
  }
  /*=============================================
  SUMAR EL TOTAL DE VENTAS
  =============================================*/
  static public function mdlSumaTotalVentas($tabla)
  {

    $stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla");
    $stmt->execute();
    return $stmt->fetch();

    // $stmt -> close();
    $stmt = null;
  }

  static public function mdlSumaTotalVentasXdia($tabla,$item,$valor)
  {

    $stmt = Conexion::conectar()->prepare("SELECT SUM(total) as total FROM $tabla WHERE date($item) = date(:$item)");
    
    $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
    // Esto no sirve acá
    // $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch();
    

    // $stmt -> close();
    $stmt = null;
  }
}
