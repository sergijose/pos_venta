<?php

class ControladorCaja
{
  /*==================================== 
  MOSTRAR LO EXISTENTE EN CAJA 
  =============================================*/
  static public function ctrMostrarCaja($item, $valor)
  {

    $tabla = "caja";
    $respuesta = ModeloCaja::mdlMostrarCaja($tabla, $item, $valor);
    return $respuesta;
  }
  /*=============================== 
  APERTURA DE CAJA 
  =============================================*/
  static public function ctrAperturaCaja()
  {

    if (isset($_POST["estadoCaja"])) {

      // Se cambia el estadoFinal a 2 opciones o abierto o cerrado
      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombreCaja"]) &&
        preg_match('/^[0-9.]+$/', $_POST["montoInicial"]) &&
        preg_match('/^(abierto|cerrado)$/', $_POST["estadoCaja"]) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["montoFinal"])
      ) {

        $tabla = "caja";
        $datos = array(
          "nombre" => $_POST["nombreCaja"],
          "id_usuario" => $_POST["idVendedor"],
          "id_sucursal" => $_POST["idSucursal"],
          "monto_apertura" => $_POST["montoInicial"],
          "estado_caja" => $_POST["estadoCaja"],
          "monto_cierre" => $_POST["montoFinal"]
        );

        $respuesta = ModeloCaja::mdlAperturaCaja($tabla, $datos);

        if ($respuesta == "ok") {

          echo '<script>

					swal({
						  type: "success",
						  title: "CAJA APERTURADA",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "caja";

									}
								})

					</script>';
        }
      } else {
        echo '<script>
					swal({
						  type: "error",
						  title: "¡NO SE PUEDE APERTURAR CAJA. Consulte con el Admin del Sistema!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "caja";

							}
						})

			  	</script>';
      }
    }
  }
  // INICIO DE CODIGO PARA CERRAR CAJA
  static public function ctrCierreCaja()
  {

    if (isset($_POST["estadoFinal"])) {
      // Se añade el id
      // Se cambia el estadoFinal a 2 opciones o abierto o cerrado
      if (
        preg_match('/^[0-9]+$/', $_POST["idCaja"]) &&
        preg_match('/^(abierto|cerrado)$/', $_POST["estadoFinal"]) &&
        preg_match('/^[0-9.]+$/', $_POST["monto_final"])
      ) {

        $tabla = "caja";
        $datos = array(
          "id_caja" => $_POST["idCaja"],
          "estado_caja" => $_POST["estadoFinal"],
          "fecha_cierre" => $_POST["fechaCierre"],
          "monto_cierre" => $_POST["monto_final"]
        );


        $respuesta = ModeloCaja::mdlCierreCaja($tabla, $datos);

        if ($respuesta == "ok") {
          echo '<script>

					swal({
						  type: "success",
						  title: "Cierre de Caja Exitoso!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "caja";

									}
								})

					</script>';
        }
      } else {
        echo '<script>
					swal({
						  type: "error",
						  title: "¡NO SE PUEDE CERRAR CAJA. Consulte con el Admin del Sistema!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "caja";

							}
						})

			  	</script>';
      }
    }
  }
} // FINAL DE LA CLASE ControladorCaja
