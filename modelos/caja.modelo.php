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
      return $stmt->fetchAll();
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
    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, id_usuario, id_sucursal, monto_apertura, estado_caja,  monto_cierre_ventas) 
			                                         VALUES (:nombre, :id_usuario, :id_sucursal,:monto_apertura, :estado_caja, :monto_cierre_ventas)");

    $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR); //Cambiar por variable SESSION :id_CajaSucursal ya que saldria
    $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT); // Usuario que realiza Apertura y Cierre
    $stmt->bindParam(":id_sucursal", $datos["id_sucursal"], PDO::PARAM_INT);//Sucursal a la que pertenece la Caja
    $stmt->bindParam(":monto_apertura", $datos["monto_apertura"], PDO::PARAM_STR);//Monto con que se abre Caja
    $stmt->bindParam(":estado_caja", $datos["estado_caja"], PDO::PARAM_STR); // Abierto o Cerrado
    $stmt->bindParam(":monto_cierre_ventas", $datos["monto_cierre_ventas"], PDO::PARAM_STR); //Monto con el que se cierra Caja

    if($stmt->execute()){
      return "ok";}
    else{
      return $stmt->errorInfo(); // Con esto me muestra el error en especifico
    }
    $stmt=null;

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
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado_caja = :estado_caja, fecha_cierre = :fecha_cierre, monto_cierre_ventas = :monto_cierre_ventas,monto_cierre_gastos = :monto_cierre_gastos,monto_cierre_total = :monto_cierre_total WHERE id_caja = :id_caja");


    $stmt->bindParam(":estado_caja", $datos["estado_caja"], PDO::PARAM_STR);
    $stmt->bindParam(":fecha_cierre", $datos["fecha_cierre"], PDO::PARAM_STR);
    $stmt->bindParam(":monto_cierre_ventas", $datos["monto_cierre_ventas"], PDO::PARAM_STR);
    $stmt->bindParam(":monto_cierre_gastos", $datos["monto_cierre_gastos"], PDO::PARAM_STR);
    $stmt->bindParam(":monto_cierre_total", $datos["monto_cierre_total"], PDO::PARAM_STR);
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


   /*===================== 
  APERTURAR CAJA INICIAL
  =============================================*/
  static public function mdlAperturaCajaInicial($tabla, $datos)
  {

    // Se cambio el idEstadoCaja por estado_caja donde se maneja abierto o cerrado
    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_usuario,monto_inicial) 
			                              VALUES (:id_usuario, :monto_inicial)");

    $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT); // Usuario que realiza Apertura y Cierre
    $stmt->bindParam(":monto_inicial", $datos["monto_inicial"], PDO::PARAM_INT);//Monto con que se abre Caja
   
 
    
    if($stmt->execute()){
      return "ok";}
    else{
      return $stmt->errorInfo(); // Con esto me muestra el error en especifico
    }
    $stmt=null;

  }
  static public function mdlMostrarCajaInicial($tabla, $item, $valor)
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

  //ACTUALIZAR CAJA INICIAL
  static public function mdlActualizarCajaInicial($item1,$valor1)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE caja_inicial SET $item1 = :$item1  WHERE id=1");

    $stmt->bindParam(":".$item1, $valor1, PDO::PARAM_STR);

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }
  
  
}
