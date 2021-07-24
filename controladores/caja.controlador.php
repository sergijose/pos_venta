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
          "monto_cierre_caja" => $_POST["montoFinal"]
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
        preg_match('/^(abierto|cerrado)$/', $_POST["estadoFinal"])
      
      ) {

        $tabla = "caja";
        $datos = array(
          "id_caja" => $_POST["idCaja"],
          "estado_caja" => $_POST["estadoFinal"],
          "fecha_cierre" => $_POST["fechaCierre"],
          "monto_cierre_ventas" => $_POST["monto_cierre_ventas"],
          "monto_cierre_gastos" => $_POST["monto_cierre_gastos"],
          "monto_cierre_total" => $_POST["monto_cierre_final"]
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


  /*=============================== 
  APERTURA DE CAJA INICIAL
  =============================================*/
  static public function ctrAperturaCajaInicial()
  {

    if (isset($_POST["idVendedor"])) {

      // Se cambia el estadoFinal a 2 opciones o abierto o cerrado
      if (
        preg_match('/^[0-9.]+$/', $_POST["montoInicial"]) 
        
      ) {

        $tabla = "caja_inicial";
        $datos = array(
  
          "id_usuario" => $_POST["idVendedor"],
          "monto_inicial" => $_POST["montoInicial"],
         
        );

        $respuesta = ModeloCaja::mdlAperturaCajaInicial($tabla, $datos);

        if ($respuesta == "ok") {

          echo '<script>

					swal({
						  type: "success",
						  title: "CAJA INICIADA",
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
						  title: "¡NO SE PUEDE INICIAR CAJA. Consulte con el Admin del Sistema!",
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



  /*==================================== 
  MOSTRAR LO EXISTENTE EN CAJA 
  =============================================*/
  static public function ctrMostrarCajaInicial($item, $valor)
  {

    $tabla = "caja_inicial";
    $respuesta = ModeloCaja::mdlMostrarCajaInicial($tabla, $item, $valor);
    return $respuesta;
  }
} // FINAL DE LA CLASE ControladorCaja
