<?php
require_once "conexion.php";

class ModeloTransferencia{
  /*=============================================
  MOSTRAR 
  =============================================*/
  static public function mdlMostrarTransferencia($tabla, $item, $valor){

    if($item != null){

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");
      $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetch();

    }else{

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");
      $stmt -> execute();
      return $stmt -> fetchAll();
    }
    $stmt -> close();
    $stmt = null;
  }

  

  /*=============================================
  REGISTRO DE TRANSFERENCIAS
  =============================================*/
  static public function mdlNuevaTransferencia($tabla, $datos){

    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_vendedor, destino , productos ,nota) 
                                                      VALUES (:id_vendedor, :destino, :productos, :nota)");
        
        $stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
        $stmt->bindParam(":destino", $datos["destino"], PDO::PARAM_STR);
        $stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
        $stmt->bindParam(":nota", $datos["nota"], PDO::PARAM_STR);
    

    if($stmt->execute()){
      return "ok";}
    else{
      return $stmt->errorInfo(); // Con esto me muestra el error en especifico
    }
    $stmt=null;

    
  }
  /*=============================================
  EDITAR ENTRADAS AL ALMACEN
  =============================================*/
  /*static public function mdlEditarVenta($tabla, $datos){
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, impuesto = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago WHERE codigo = :codigo");

    $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
    $stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
    $stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
    $stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
    $stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
    $stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
    $stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
    $stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);

    if($stmt->execute()){
      return "ok";
    }else{
      return "error";
    }
    $stmt->close();
    $stmt = null;
  }*/
  /*=============================================
  ELIMINAR ENTRADAS AL ALMACEN
  =============================================*/
/*  static public function mdlEliminarVenta($tabla, $datos){
    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
    $stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
    if($stmt -> execute()){
      return "ok";
    }else{
      return "error"; 
    }
    $stmt -> close();
    $stmt = null;
  }
*/
  /*=============================================
  RANGO FECHAS - ENTRADAS AL ALMACEN
  =============================================*/ 
/*  static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal){
    if($fechaInicial == null){

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");
      $stmt -> execute();
      return $stmt -> fetchAll(); 

    }else if($fechaInicial == $fechaFinal){

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%'");
      $stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetchAll();

    }else{

      $fechaActual = new DateTime();
      $fechaActual ->add(new DateInterval("P1D"));
      $fechaActualMasUno = $fechaActual->format("Y-m-d");

      $fechaFinal2 = new DateTime($fechaFinal);
      $fechaFinal2 ->add(new DateInterval("P1D"));
      $fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

      if($fechaFinalMasUno == $fechaActualMasUno){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");

      }else{

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");
      }
    
      $stmt -> execute();
      return $stmt -> fetchAll();
    }

  }*/

  /*=============================================
  SUMAR EL TOTAL DE VENTAS - ENTRADAS AL ALMACEN
  =============================================*/
  // static public function mdlSumaTotalVentas($tabla){ 

  //  $stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla");
  //  $stmt -> execute();
  //  return $stmt -> fetch();
  //  $stmt -> close();
  //  $stmt = null;
  // }

  
}