<?php
require_once "conexion.php";
class ModeloCaja
{
  /*==================================
 MUESTRA INFORMACION DE LAS CAJAS 
 =============================================*/
  static public function mdlMostrarCaja($tabla, $item, $valor)
  {
    if ($item != null) {
      // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item LIMIT 1");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // $stmt->close();
    $stmt = null;
  }
  /*===================== 
  APERTURAR CAJA 
  =============================================*/
  static public function mdlAperturaCaja($tabla, $datos)
  {

    // Se cambio el idEstadoCaja por estado_caja donde se maneja abierto o cerrado
    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, monto_apertura, estado_caja,  monto_cierre) 
			                                         VALUES (:nombre, :monto_apertura, :estado_caja, :monto_cierre)");

    $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
    $stmt->bindParam(":monto_apertura", $datos["monto_apertura"], PDO::PARAM_STR);
    $stmt->bindParam(":estado_caja", $datos["estado_caja"], PDO::PARAM_STR); // Aquí se cambio el bindParam
    $stmt->bindParam(":monto_cierre", $datos["monto_cierre"], PDO::PARAM_STR);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }
  /*===================== 
  CIERRE DE  CAJA 
  =============================================*/
  static public function mdlCierreCaja($tabla, $datos)
  {

    /*$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idEstadoCaja, fecha_cierre, monto_cierre) 
			                                  VALUES (:idEstadoCaja, :fecha_cierre, :monto_cierre)");*/

    // $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idEstadoCaja = :idEstadoCaja, fecha_cierre = :fecha_cierre, monto_cierre = :monto_cierre");

    // Se añade el id para hacer la consulta a un item especifico
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado_caja = :estado_caja, fecha_cierre = :fecha_cierre, monto_cierre = :monto_cierre WHERE id_caja = :id_caja");


    $stmt->bindParam(":estado_caja", $datos["estado_caja"], PDO::PARAM_STR);
    $stmt->bindParam(":fecha_cierre", $datos["fecha_cierre"], PDO::PARAM_STR);
    $stmt->bindParam(":monto_cierre", $datos["monto_cierre"], PDO::PARAM_STR);
    // Se añade el id para hacer la consulta a un item especifico
    $stmt->bindParam(":id_caja", $datos["id_caja"], PDO::PARAM_INT);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }
  // static public function mdlCierreCaja($tabla, $datos){
  // 	$stmt = Conexion::conectar()->prepare("UPDATE INTO $tabla(categoria) VALUES (:categoria)");
  // 	$stmt->bindParam(":categoria", $datos, PDO::PARAM_STR);
  // 	if($stmt->execute()){
  // 		return "ok";
  // 	}else{
  // 		return "error";
  // 	}
  // 	$stmt->close();
  // 	$stmt = null;
  // }
  /*=============================================
EDITAR USUARIO
=============================================*/
  /*	static public function mdlEditarUsuario($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, password = :password, perfil = :perfil, foto = :foto WHERE usuario = :usuario");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();

		$stmt = null;

	}	*/
  /*===================== VALIDA CAJA DE  CAJA =============================================*/
  /*	static public function mdlValidaCaja($tabla, $item, $valor){
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
	}*/
}
