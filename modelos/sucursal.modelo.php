<?php
require_once "conexion.php";
class ModeloSucursal
{
  /*=============================================
	Creamos Nueva Sucursal
	=============================================*/
  static public function mdlIngresarSucursal($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(sede, descripcion) VALUES (:sede, :descripcion)");
    $stmt->bindParam(":sede", $datos["sede"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }
  /*=============================================
	Mostramos Sucursal
	=============================================*/
  static public function mdlMostrarSucursal($tabla, $item, $valor)
  {
    if ($item != null) {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
      
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT *, DATE_FORMAT(fecha_registro, '%d/%m/%Y') AS fecha_registro FROM $tabla");
      $stmt->execute();
      return $stmt->fetchAll();
    }
    // $stmt->close();
    $stmt = null;
  }
  
/*=============================================
  Editamos la Sucursal
  =============================================*/
  static public function mdlEditarSucursal($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET sede = :sede, descripcion=:descripcion WHERE id = :id");

    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
    $stmt->bindParam(":sede", $datos["sede"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
   

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }

 /*=============================================
  Eliminamos Sucursal
  =============================================*/
  static public function mdlEliminarSucursal($tabla, $datos)
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



} // Llave Principal de la Clase ModeloSucursal
