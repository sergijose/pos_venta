<?php
class ControladorProductos
{
  /*=============================================
  MOSTRAR PRODUCTOS
  =============================================*/
  static public function ctrMostrarProductos($item, $valor, $orden)
  {
    $tabla = "productos";
    $respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $orden);
    return $respuesta;
  }
  /*=============================================
  Mostrar Producto sin Orden
  =============================================*/
  static public function ctrMostrarProductos2($item, $valor)
  {
    $tabla = "productos";
    $respuesta = ModeloProductos::mdlMostrarProductos2($tabla, $item, $valor);
    return $respuesta;
  }
  /*==================== 
  Mostramos Productos por Sucursal 
  =======================================*/
  static public function ctrMostrarProductoSucursal($item, $valor, $orden)
  {
    $tabla = "productos";
    $respuesta = ModeloProductos::mdlMostrarProductoSucursal($tabla, $item, $valor, $orden);
    return $respuesta;
  }

  /*=============================================
  CREAR PRODUCTO
  =============================================*/
  static public function ctrCrearProducto()
  {
    if (isset($_POST["nuevoNombre"])) {

      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/_\- %\()#\.]+$/', $_POST["nuevoNombre"]) &&
        preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&
        preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompra"]) &&
        preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioVenta"])
      ) {
        /*==================
        VALIDAR IMAGEN
        ====================================*/
        $ruta = "vistas/img/productos/default/anonymous.png";
        if (isset($_FILES["nuevaImagen"]["tmp_name"])) {
          list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);
          $nuevoAncho = 500;
          $nuevoAlto = 500;
          /*=====================
          CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
          =======================================*/
          $directorio = "vistas/img/productos/" . $_POST["nuevoCodigo"];
          mkdir($directorio, 0755);
          /*=====================
          DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
          ============================*/
          if ($_FILES["nuevaImagen"]["type"] == "image/jpeg") {
            /*=============================================
            GUARDAMOS LA IMAGEN EN EL DIRECTORIO
            =============================================*/
            $aleatorio = mt_rand(100, 999);
            $ruta = "vistas/img/productos/" . $_POST["nuevoCodigo"] . "/" . $aleatorio . ".jpg";
            $origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);
            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
            imagejpeg($destino, $ruta);
          }

          if ($_FILES["nuevaImagen"]["type"] == "image/png") {

            /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
            $aleatorio = mt_rand(100, 999);
            $ruta = "vistas/img/productos/" . $_POST["nuevoCodigo"] . "/" . $aleatorio . ".png";
            $origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);
            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
            imagepng($destino, $ruta);
          }
        }

        $tabla = "productos";
        $datos = array(
          "id_categoria" => $_POST["nuevaCategoria"],
          "idSucursal" => $_POST["nuevaSucursal"],
          "codigo" => $_POST["nuevoCodigo"],
          "codigo2" => $_POST["nuevoCodigo2"],
          "nombre" => $_POST["nuevoNombre"],
          "stock" => $_POST["nuevoStock"],
          "precio_compra" => $_POST["nuevoPrecioCompra"],
          "precio_venta" => $_POST["nuevoPrecioVenta"],
          "descripcion" => $_POST["nuevaDescripcion"],
          "imagen" => $ruta
        );

        $respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);

        // var_dump($respuesta);
        // return;

        if ($respuesta == "ok") {
          echo '<script>
						swal({
							  type: "success",
							  title: "El producto ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "productos";

										}
									})
						</script>';
        }
      } else {

        echo '<script>

					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "productos";

							}
						})

			  	</script>';
      }
    }
  }
  /*=============================================
  EDITAR PRODUCTO
  =============================================*/
  static public function ctrEditarProducto()
  {

    if (isset($_POST["editarNombre"])) {

      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/_\- %\()#\.]+$/', $_POST["editarNombre"]) &&
        preg_match('/^[0-9]+$/', $_POST["editarStock"]) &&
        preg_match('/^[0-9.]+$/', $_POST["editarPrecioCompra"]) &&
        preg_match('/^[0-9.]+$/', $_POST["editarPrecioVenta"])
      ) {

        /*=============================================
				VALIDAR IMAGEN
				=============================================*/
        $ruta = $_POST["imagenActual"];

        if (isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])) {

          list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);
          $nuevoAncho = 500;
          $nuevoAlto = 500;
          /*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
          $directorio = "vistas/img/productos/" . $_POST["editarCodigo"];
          /*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/
          if (!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png") {

            unlink($_POST["imagenActual"]);
          } else {

            mkdir($directorio, 0755);
          }
          /*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
          if ($_FILES["editarImagen"]["type"] == "image/jpeg") {
            /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
            $aleatorio = mt_rand(100, 999);
            $ruta = "vistas/img/productos/" . $_POST["editarCodigo"] . "/" . $aleatorio . ".jpg";
            $origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);
            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
            imagejpeg($destino, $ruta);
          }

          if ($_FILES["editarImagen"]["type"] == "image/png") {

            /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
            $aleatorio = mt_rand(100, 999);
            $ruta = "vistas/img/productos/" . $_POST["editarCodigo"] . "/" . $aleatorio . ".png";
            $origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);
            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
            imagepng($destino, $ruta);
          }
        }

        $tabla = "productos";

        $datos = array(
          "id_categoria" => $_POST["editarCategoria"],
          "idSucursal" => $_POST["editarSucursal"],       
          "codigo" => $_POST["editarCodigo"],
          "codigo2" => $_POST["editarCodigo2"],
          "nombre" => $_POST["editarNombre"],
          "stock" => $_POST["editarStock"],
          "precio_compra" => $_POST["editarPrecioCompra"],
          "precio_venta" => $_POST["editarPrecioVenta"],
          "descripcion" => $_POST["editarDescripcion"],
          "imagen" => $ruta);

        $respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);
        // var_dump($respuesta);
        // var_dump($datos);
        // var_dump($respuesta);

        if ($respuesta == "ok") {

          echo '<script>

						swal({
							  type: "success",
							  title: "El producto ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "productos";

										}
									})

						</script>';
        }
      } else {

        echo '<script>

					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "productos";

							}
						})

			  	</script>';
      }
    }
  }
  /*=============================================
  BORRAR PRODUCTO
  =============================================*/
  static public function ctrEliminarProducto()
  {

    if (isset($_GET["idProducto"])) {

      $tabla = "productos";
      $datos = $_GET["idProducto"];

      if ($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png") {

        unlink($_GET["imagen"]);
        rmdir('vistas/img/productos/' . $_GET["codigo"]);
      }

      $respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);

      if ($respuesta == "ok") {

        echo '<script>

				swal({
					  type: "success",
					  title: "El producto ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "productos";

								}
							})

				</script>';
      }
    }
  }
  /*=============================================
  MOSTRAR SUMA VENTAS
  =============================================*/
  static public function ctrMostrarSumaVentas()
  {

    $tabla = "productos";
    $respuesta = ModeloProductos::mdlMostrarSumaVentas($tabla);
    return $respuesta;
  }
}
