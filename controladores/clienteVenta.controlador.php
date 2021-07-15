<?php

class ControladorClienteVenta
{

  /*=============================================
	CREAR CLIENTES
	=============================================*/
  static public function ctrCrearClienteVenta()
  {

    if (isset($_POST["nuevoCliente"])) {

      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCliente"]) &&
        preg_match('/^[0-9]+$/', $_POST["nuevoDocumentoId"]) &&
        preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["nuevoEmail"]) &&
        preg_match('/^[()\-0-9 ]+$/', $_POST["nuevoTelefono"]) &&
        preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevaDireccion"])
      ) {

        $tabla = "clientes";
        /* ucwords : Esta funcion convierte a formato Nombre Propio, ejemplo juan manuel lo convierte en Juan Manuel*/
        $datos = array(
          "nombre" => ucwords($_POST["nuevoCliente"]),
          "documento" => $_POST["nuevoDocumentoId"],
          "email" => $_POST["nuevoEmail"],
          "telefono" => $_POST["nuevoTelefono"],
          "direccion" => $_POST["nuevaDireccion"]
        );

        $respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);

        if ($respuesta == "ok") {

          echo '<script>

					swal({
						  type: "success",
						  title: "El cliente ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "crear-venta";
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

							window.location = "crear-venta"; 

							}
						})
			  	</script>';
      }
    }
  }

 



} // Llave Principal de la Clase ControladorClientes
