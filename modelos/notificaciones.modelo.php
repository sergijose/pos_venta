<?php

require_once "conexion.php";

class ModeloNotificaciones{
		
	/*=============================================
	MOSTRAR NOTIFICACIONES
	=============================================*/

	static public function mdlMostrarNotificaciones($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		//$stmt -> close();
		
		$stmt = null;
	
	}



			
	/*=============================================
	MOSTRAR PRODUCTO VENCIDOS
	=============================================*/

	static public function mdlCantidadProductosVencidos(){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM productos where fecha_vencimiento <=NOW()");

		$stmt -> execute();
		return $stmt -> fetchAll();
		
			$stmt = null;
	}

	/*=============================================
	MOSTRAR PRODUCTO QUE VENCERAN DENTRO DE UN MES
	=============================================*/

	static public function mdlProductosPorVencer(){

		$stmt = Conexion::conectar()->prepare(" SELECT * from productos
		WHERE fecha_vencimiento BETWEEN NOW() AND  DATE_ADD(NOW(), interval 1 month);");

		$stmt -> execute();
		return $stmt -> fetchAll();
		
			$stmt = null;
	}

	/*=============================================
	ACTUALIZAR NOTIFICACIONES
	=============================================*/

	static public function mdlActualizarNotificaciones($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		//$stmt -> close();

		$stmt = null;

	}


}