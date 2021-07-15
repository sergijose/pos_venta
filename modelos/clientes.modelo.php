<?php
require_once "conexion.php";
class ModeloClientes{
  /*=============================================
  Nuevo Cliente
  =============================================*/
  static public function mdlIngresarCliente($tabla, $datos){
    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(documento, ruc, razon_social, direccion, ruc2, telefono,correo) 
                                               VALUES (:documento, :ruc, :razon_social, :direccion, :ruc2, :telefono, :correo)");

    $stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
    $stmt->bindParam(":ruc", $datos["ruc"], PDO::PARAM_STR);
    $stmt->bindParam(":razon_social", $datos["razon_social"], PDO::PARAM_STR);
    $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);

    $stmt->bindParam(":ruc2", $datos["ruc2"], PDO::PARAM_STR);
    $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
    $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        
    if($stmt->execute()){
      return "ok";
    }else{

      return "error";
    
    }
    $stmt->close();
    $stmt = null;
  }

  
  /*=============================================
  Mostramos Todos los Clientes
  =============================================*/
  static public function  mdlMostrarClientes($tabla, $item, $valor){
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

    $stmt -> close();
    $stmt = null;
  }

/*=============================================================
  Mostramos Todos los Clientes con Filtro: RUC y DIRECCION
static public function  mdlMostrarFiltroClientes($tabla, $idCliente){
  SELECT direccion, ruc FROM $tabla
    where id = $idCliente(este es el id que nosotros elegimos)
    $stmt -> execute();
    return $stmt -> fetchAll();
    $stmt -> close();
    $stmt = null;
  }
============================================================*/
  static public function mdlGetCliente($tabla){

      //select direccion, ruc from tabla
          //where id = li_id
    
      $stmt = Conexion::conectar()->prepare("SELECT direccion,ruc FROM $tabla WHERE $id = :$idCliente");
      $stmt -> execute();

      return $stmt -> fetchAll();
      $stmt -> close();
      $stmt = null;
    }
/*=======================================================================================================*/
  static public function  mdlMostrarFiltroClientes($tabla, $item, $valor){
    if($item != null){

      $stmt = Conexion::conectar()->prepare("SELECT direccion, ruc FROM $tabla WHERE $item = :$item");
      $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetch();

    }else{
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
      $stmt -> execute();
      return $stmt -> fetchAll();
    }

    $stmt -> close();
    $stmt = null;
  }
  /*=============================================
  Edicion de Clientes
  =============================================*/
 static public function mdlEditarCliente($tabla, $datos){
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, documento = :documento, email = :email, telefono = :telefono, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento WHERE id = :id");

    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
    $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
    $stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_INT);
    
    if($stmt->execute()){
      return "ok";
    }else{
      return "error";
    }
    $stmt->close();
    $stmt = null;
  }

/*=============================================
  ELIMINAR CLIENTE
=============================================*/
  static public function mdlEliminarCliente($tabla, $datos){
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

  /*=============================================
  ACTUALIZAR CLIENTE
  =============================================*/
  /*tatic public function mdlActualizarCliente($tabla, $item1, $valor1, $valor){
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");
    $stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
    $stmt -> bindParam(":id", $valor, PDO::PARAM_STR);
    if($stmt -> execute()){
      return "ok";
    }else{
      return "error"; 
    }
    $stmt -> close();
    $stmt = null;
  }*/

}