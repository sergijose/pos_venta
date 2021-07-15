<?php
class ControladorSucursal
{
  /*================================= 
  Nueva Sucursal 
  =============================================*/
  static public function ctrCrearSucursal()
  {

    if (isset($_POST["nombreSucursal"])) {

      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombreSucursal"]) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaSucursal"])){

        $tabla = "sucursal";
        $datos = array(
          "sede" => $_POST["nombreSucursal"],
          "descripcion" => $_POST["nuevaSucursal"]);

        $respuesta = ModeloSucursal::mdlIngresarSucursal($tabla, $datos);

        if ($respuesta == "ok") {
          echo '<script>
					swal({
						  type: "success",
						  title: "La Nueva Sucursal se ha creado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "nueva-sucursal";
									}
								})
					</script>';
        }
      } else {
        echo '<script>
					swal({
						  type: "error",
						  title: "¡ERROR: No se aceptan caracteres especiales como (.)(,)(;)(@) y otros!!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "nueva-sucursal";
							}
						})
			  	</script>';
      }
    }
  }
  /*=========================================== 
  Mostrando Sucursales 
  =============================================*/
  static public function ctrMostrarSucursal($item, $valor)
  {
    $tabla = "sucursal";
    $respuesta = ModeloSucursal::mdlMostrarSucursal($tabla, $item, $valor);
    return $respuesta;
  }
  /*=============================================
  Editamos la Sucursales
  =============================================*/
  static public function ctrEditarSucursal()
  {

    if (isset($_POST["editameSucursal"])) {

      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editameSucursal"]) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editameDescripcion"])){


        $tabla = "sucursal";

        $datos = array(

          "id" => $_POST["idSucursal"],
          "sede" => $_POST["editameSucursal"],
          "descripcion" => $_POST["editameDescripcion"]);

        $respuesta = ModeloSucursal::mdlEditarSucursal($tabla, $datos);

        //var_dump($respuesta);
        //return;

        if ($respuesta == "ok") {

          echo '<script>

          swal({
              type: "success",
              title: "La Sucursal ha sido cambiada correctamente",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                  if (result.value) {

                  window.location = "nueva-sucursal";

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

               window.location = "nueva-sucursal";

              }
            })

          </script>';
      }
    }
  }

  /*=============================================
  EDITAR 
  =============================================*/
  /*static public function ctrEditarSucursal()
  {

    if (isset($_POST["editameSucursal"])) {

      if (
        preg_match('/^[#\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editameSucursal"]) &&
        preg_match('/^[#\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editameDescripcion"])) {

        $tabla = "sucursal";

        $datos = array(
          "id" => $_POST["idSucursal"],
          "sede" => $_POST["editameSucursal"],
          "descripcion" => $_POST["editameDescripcion"]);

        $respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);

        if ($respuesta == "ok") {

          echo '<script>

          swal({
              type: "success",
              title: "El cliente ha sido cambiado correctamente",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                  if (result.value) {

                  window.location = "clientes";

                  }
                })

          </script>';
        }
      } else {

        echo '<script>

          swal({
              type: "error",
              title: "¡El cliente no puede ir vacío o llevar caracteres especiales!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
              if (result.value) {

              window.location = "clientes";

              }
            })

          </script>';
      }
    }
  }*/
/*=============================================
  ELIMINAR 
  =============================================*/
  static public function ctrEliminarSucursal()
  {

    if (isset($_GET["idSucursal"])) {

      $tabla = "sucursal";
      $datos = $_GET["idSucursal"];

      $respuesta = ModeloSucursal::mdlEliminarSucursal($tabla, $datos);

      if ($respuesta == "ok") {

        echo '<script>

        swal({
            type: "success",
            title: "La Sucursal ha sido borrado correctamente",
            showConfirmButton: true,
            confirmButtonText: "Cerrar",
            closeOnConfirm: false
            }).then(function(result){
                if (result.value) {

                window.location = "nueva-sucursal";

                }
              })

        </script>';
      }
    }
  }


} // Llave de la Clase Principal
