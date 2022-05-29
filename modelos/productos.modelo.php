<?php
require_once "conexion.php";
class ModeloProductos
{
  /*=============================================
  MOSTRAR PRODUCTOS
  =============================================*/
  static public function mdlMostrarProductos($tabla, $item, $valor, $orden)
  {

    if ($item != null) {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha,DATE_FORMAT(fecha_vencimiento, '%d/%m/%Y') AS fecha_vencimiento FROM $tabla ORDER BY $orden DESC");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    // $stmt->close();
    $stmt = null;
  }

  /*=============================================
  Mostrar Productos sin Filtro de Orden
  =============================================*/
  static public function mdlMostrarProductos2($tabla, $item, $valor)
  {

    if ($item != null) {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha  FROM $tabla");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    // $stmt->close();
    $stmt = null;
  }

  /*========================= 
  Mostramos Productos  - Sucursal 
  =====================================*/
  static public function mdlMostrarProductoSucursal($tabla, $item, $valor, $orden)
  {

    if ($item != null) {

      // Aquí se compara con el valor que viene dinamico que vendria siendo id_vendedor
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
      // Aquí se pasa el parametro con los valores...
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetchAll();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha  FROM $tabla ORDER BY $orden DESC");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    // $stmt->close();
    $stmt = null;
  }
  /*========================= 
  Registrar Nuevo Producto 
  ===========================================*/
  static public function mdlIngresarProducto($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_categoria, idSucursal, codigo, nombre, imagen, stock, precio_compra, precio_venta, descripcion,fecha_vencimiento) VALUES (:id_categoria, :idSucursal, :codigo,  :nombre, :imagen, :stock, :precio_compra, :precio_venta, :descripcion,:fecha_vencimiento)");

    $stmt->bindParam(":id_categoria",  $datos["id_categoria"],  PDO::PARAM_INT);
    $stmt->bindParam(":idSucursal",    $datos["idSucursal"],    PDO::PARAM_INT);
    $stmt->bindParam(":codigo",        $datos["codigo"],        PDO::PARAM_STR);
    $stmt->bindParam(":nombre",        $datos["nombre"],        PDO::PARAM_STR);
    $stmt->bindParam(":imagen",        $datos["imagen"],        PDO::PARAM_STR);
    $stmt->bindParam(":stock",         $datos["stock"],         PDO::PARAM_STR);
    $stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
    $stmt->bindParam(":precio_venta",  $datos["precio_venta"],  PDO::PARAM_STR);
    $stmt->bindParam(":descripcion",   $datos["descripcion"],   PDO::PARAM_STR);
    $stmt->bindParam(":fecha_vencimiento",   $datos["fecha_vencimiento"],   PDO::PARAM_STR);

    if($stmt->execute()){
      return "ok";}
    else{
      return $stmt->errorInfo(); // Con esto me muestra el error en especifico
    }
    $stmt=null;

    
  }
  /*=============================== 
  Edicion de Productos 
  ========================================*/
  static public function mdlEditarProducto($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria=:id_categoria,idSucursal=:idSucursal ,codigo=:codigo, nombre=:nombre, imagen=:imagen, stock=:stock, precio_compra=:precio_compra, precio_venta=:precio_venta,fecha_vencimiento=:fecha_vencimiento, descripcion= :descripcion where id=:id");

    $stmt->bindParam(":id_categoria",  $datos["id_categoria"],  PDO::PARAM_INT);
    $stmt->bindParam(":idSucursal",    $datos["idSucursal"],    PDO::PARAM_INT);
    $stmt->bindParam(":codigo",        $datos["codigo"],        PDO::PARAM_STR);
    $stmt->bindParam(":id",             $datos["id"],      PDO::PARAM_INT);
    $stmt->bindParam(":nombre",        $datos["nombre"],        PDO::PARAM_STR);
    $stmt->bindParam(":imagen",        $datos["imagen"],        PDO::PARAM_STR);
    $stmt->bindParam(":stock",         $datos["stock"],         PDO::PARAM_STR);
    $stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
    $stmt->bindParam(":precio_venta",  $datos["precio_venta"],  PDO::PARAM_STR);
    $stmt->bindParam(":fecha_vencimiento",   $datos["fecha_vencimiento"],   PDO::PARAM_STR);
    $stmt->bindParam(":descripcion",   $datos["descripcion"],   PDO::PARAM_STR);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }
  /*=============================================
  Eliminar un Producto Existente
  =============================================*/
  static public function mdlEliminarProducto($tabla, $datos)
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
  /*=============================================
  ACTUALIZAR PRODUCTO
  =============================================*/
  static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");
    $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
    $stmt->bindParam(":id", $valor, PDO::PARAM_STR);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    // $stmt->close();
    $stmt = null;
  }
  /*=======================
  Mostramos la Suma de las Ventas 
  =========================================*/
  static public function mdlMostrarSumaVentas($tabla)
  {

    $stmt = Conexion::conectar()->prepare("SELECT SUM(ventas) as total FROM $tabla");
    $stmt->execute();
    return $stmt->fetch();
    // $stmt->close();
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

		$stmt = Conexion::conectar()->prepare("SELECT * from productos
		WHERE fecha_vencimiento BETWEEN NOW() AND  DATE_ADD(NOW(), interval 1 month);");

		$stmt -> execute();
		return $stmt -> fetchAll();
		
			$stmt = null;
	}

}
