<?php
require_once "conexion.php";

class ModeloGastos
{

  /*=============================================
	CREAR CATEGORIA
	=============================================*/
  static public function mdlIngresarGastos($tabla, $datos)
  {
    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_usuario,destino,descripcion,cantidad,precio) VALUES (:id_usuario,:destino,:descripcion,:cantidad,:precio)");
    $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
    $stmt->bindParam(":destino", $datos["destino"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
    $stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
    $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_INT);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }
  /*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/
  static public function mdlMostrarGastos($tabla, $item, $valor)
  {
    if ($item != null) {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();

      return $stmt->fetch();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
      $stmt->execute();
      return $stmt->fetchAll();
    }
    // $stmt->close();
    $stmt = null;
  }

  static public function mdlSumaTotalGastosXdia($tabla,$fechaInicial,$fechaFinal)
  {

    $stmt = Conexion::conectar()->prepare("SELECT SUM(precio) as total FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");
    $stmt->execute();

    return $stmt->fetch();
    

    // $stmt -> close();
    $stmt = null;
  }

  /*=============================================
	EDITAR CATEGORIA
	=============================================
  static public function mdlEditarCategoria($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET categoria = :categoria WHERE id = :id");
    $stmt->bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }

  =============================================
	BORRAR CATEGORIA
	=============================================
  static public function mdlBorrarCategoria($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
    $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

    if ($stmt->execute()) {
      return "ok";
    } else {

      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }
  */


}
