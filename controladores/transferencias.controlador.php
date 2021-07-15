<?php

class ControladorTransferencia
{

  /*=============================================
	CREAR TRANSFERENCIA
	=============================================*/
  static public function ctrCrearTransferencia()
  {

    if (isset($_POST["nuevoDestino"])) {
      /*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/
      if ($_POST["listaTransferencias"] == "") { // Si no hay productos en la lista de ventas
        echo '<script>
				swal({
					  type: "error",
					  title: "La Transferencia no se ejecuta si no hay productos",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "transferencia";
								}
							})
				</script>';
        return;
      }

     //Declaramos una variable y le asignamos el valor del JSON y la decodificamos
    $listaTransferencias = json_decode($_POST["listaTransferencias"], true);
       //var_dump($listaTransferencias);
      
      foreach ($listaTransferencias as $key => $value) {
         
        //Mostramos los item(transferencias) que vamos a registrar como entradas
         $tablaProductos = "productos";
         $tablaTransferencia = "transferencias";
          $item = "id";
          $valor = $value["id"];
          $orden = "id";
          $traerTransferencia = ModeloTransferencia::mdlMostrarTransferencia($tablaTransferencia, $item, $valor);
         //var_dump($traerTransferencia);
         //Actualizamos el stock
         $item1b = "stock";
         $valor1b = $value["stock"];
         $nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor); 
        
      }


      /*=============================================
      GUARDAMOS LA TRANSFERENCIA
      =============================================*/ 

      $tabla = "transferencias";

      $datos = array(
        "id_vendedor" => $_POST["idVendedor"],
        "destino" => $_POST["nuevoDestino"],
        "productos" => $_POST["listaTransferencias"],
        "nota" => $_POST["nuevaNota"]);

      $respuesta = ModeloTransferencia::mdlNuevaTransferencia($tabla, $datos);

      if ($respuesta == "ok") {
        
        echo '<script>
				localStorage.removeItem("rango");
				swal({
					  type: "success",
					  title: "Transferencia guardada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "transferencia";
								}
							})
				</script>';
      }
    }
  }
/*=============================================
       MOSTRAR TRANSFERENCIAS
=============================================*/
static public function ctrMostrarTransferencias($item, $valor)
  {
    $tabla = "transferencias";
    $respuesta = ModeloTransferencia::mdlMostrarTransferencia($tabla, $item, $valor);
    return $respuesta;
  }


} // Llave Principal
