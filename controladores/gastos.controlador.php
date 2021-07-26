<?php

class ControladorGastos
{

  /*=============================================
	CREAR CATEGORIAS
	=============================================*/
  static public function ctrCrearGastos()
  {

    if (isset($_POST["nuevoDestino"])) {
      if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/_\-\'  ]+$/', $_POST["nuevoDestino"])) {

        $tabla ="gastos";

        $datos = array(
          "id_usuario" => $_POST["idVendedor"],
          "destino" => $_POST["nuevoDestino"],       
          "descripcion" => $_POST["nuevoGasto"],
          "cantidad" => $_POST["nuevaCantidad"],
          "precio" => $_POST["nuevoPrecio"]);

        $respuesta = ModeloGastos::mdlIngresarGastos($tabla, $datos);
		var_dump($datos);
			var_dump($respuesta);
        if ($respuesta == "ok") {
          echo '<script>
					swal({
						  type: "success",
						  title: "Se registro el gasto  correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "gastos";
									}
								})
					</script>';
        }
      } else {

        echo '<script>

					swal({
						  type: "error",
						  title: "¡el gasto no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "gastos";

							}
						})

			  	</script>';
      }
    }
  }

  /*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/
  static public function ctrMostrarGastos($item, $valor)
  {

    $tabla ="gastos";
    $respuesta = ModeloGastos::mdlMostrarGastos($tabla, $item, $valor);
    return $respuesta;
  }

  public static function ctrSumaTotalGastosXdia($item,$valor)
  {

    $tabla = "gastos";
    $respuesta = ModeloGastos::mdlSumaTotalGastosXdia($tabla,$item,$valor);
    return $respuesta;
  }

  /*=============================================
	EDITAR CATEGORIA
	=============================================
  static public function ctrEditarCategoria()
  {

    if (isset($_POST["editarCategoria"])) {

      if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/_\-\'  ]+$/', $_POST["editarCategoria"])) {

        $tabla = "categorias";

        $datos = array(
          "categoria" => $_POST["editarCategoria"],
          "id" => $_POST["idCategoria"]
        );

        $respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $datos);

        if ($respuesta == "ok") {

          echo '<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "categorias";

									}
								})

					</script>';
        }
      } else {

        echo '<script>

					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "categorias";

							}
						})

			  	</script>';
      }
    }
  }

  =============================================
	BORRAR CATEGORIA
	=============================================

  static public function ctrBorrarCategoria()
  {

    if (isset($_GET["idCategoria"])) {

      $tabla = "Categorias";
      $datos = $_GET["idCategoria"];

      $respuesta = ModeloCategorias::mdlBorrarCategoria($tabla, $datos);

      if ($respuesta == "ok") {

        echo '<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "categorias";

									}
								})

					</script>';
      }
    }
  }
  */
}
