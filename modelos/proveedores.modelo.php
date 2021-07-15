<?php
require_once "conexion.php";
class ModeloProveedor{
  
  /*=============================================
  MOSTRAR PROVEEDORES
  =============================================*/
  static public function  mdlMostrarProveedor($tabla, $item, $valor){
    if($item != null){

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
      $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetch();

    }else{
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
      $stmt -> execute();
      return $stmt -> fetchAll();
    }

    //$stmt -> close();
    $stmt = null;
  }
    /*=============================================
  Nuevo Proveedor
  =============================================*/
  static public function mdlNuevoProveedor($tabla, $datos){
    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(ruc_proveedor, razon_social, nombre_comercial, direccion_fiscal, tipo_empresa, estado_empresa, condicion_empresa) VALUES (:ruc_proveedor, :razon_social, :nombre_comercial, :direccion_fiscal, :tipo_empresa, :estado_empresa, :condicion_empresa)");

    $stmt->bindParam(":ruc_proveedor", $datos["ruc_proveedor"], PDO::PARAM_STR);
    $stmt->bindParam(":razon_social", $datos["razon_social"], PDO::PARAM_STR);
    $stmt->bindParam(":nombre_comercial", $datos["nombre_comercial"], PDO::PARAM_STR);
    $stmt->bindParam(":direccion_fiscal", $datos["direccion_fiscal"], PDO::PARAM_STR);
    $stmt->bindParam(":tipo_empresa", $datos["tipo_empresa"], PDO::PARAM_STR);
    $stmt->bindParam(":estado_empresa", $datos["estado_empresa"], PDO::PARAM_STR);
    $stmt->bindParam(":condicion_empresa", $datos["condicion_empresa"], PDO::PARAM_STR);
        
    if($stmt->execute()){
      return "ok";
    }else{

      return "error";
    
    }
    //$stmt->close();
    $stmt = null;
  }

  
}