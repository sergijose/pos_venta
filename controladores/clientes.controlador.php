<?php

class ControladorClientes{
   /*=============================================
  REGISTRAR CLIENTES 1
  =============================================*/
 static public function ctrCrearClienteDNI(){ // Inicia llave ctrCrearCliete
    if(isset($_POST["nuevoTipo"])){ // Inicia llave isset

      
          $tabla = "clientes";
          $datos = array(
                       "documento"=>$_POST["nuevoTipo"],
                       "ruc"=>$_POST["dni"],
                       "razon_social"=>$_POST["nombres"],
                       "direccion"=>$_POST["direccion_cliente"],
                       "ruc2"=>$_POST["ruc_cliente"],
                       "telefono"=>$_POST["telefono"],
                       "correo"=>$_POST["correo"]);

          $respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);
               /* var_dump($respuesta);
                return;*/

          if($respuesta == "ok"){

          echo'<script>
          swal({
              type: "success",
              title: "El Cliente ha sido guardado correctamente",
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
  }
/*=============================================
  REGISTRAR CLIENTES 2
=============================================*/

  static public function ctrCrearClienteRUC(){ // Inicia llave ctrCrearCliete
    if(isset($_POST["nuevoTipo"])){ // Inicia llave isset

      
          $tabla = "clientes";
          $datos = array(
                       "documento"=>$_POST["nuevoTipo"],
                       "ruc"=>$_POST["dni"],
                       "razon_social"=>$_POST["nombres"],
                       "direccion"=>$_POST["direccion_cliente"]);

          $respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);
               /* var_dump($respuesta);
                return;*/

          if($respuesta == "ok"){

          echo'<script>
          swal({
              type: "success",
              title: "El Cliente ha sido guardado correctamente",
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

  /*=============================================
  MOSTRAR CLIENTES
  =============================================*/
  static public function ctrMostrarClientes($item, $valor){
    $tabla = "clientes";
    $respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);
    return $respuesta;
  }

  /*=============================================
  MOSTRAR CLIENTES con flitro : RUC y DIRECCION
  =============================================*/
  static public function ctrMostrarFiltroClientes($item, $valor){
    $tabla = "clientes";
    $respuesta = ModeloClientes::mdlMostrarFiltroClientes($tabla, $item, $valor);
    return $respuesta;
  }
  /*=============================================
  EDITAR CLIENTE
  =============================================*/
  static public function ctrEditarCliente(){

    if(isset($_POST["editarCliente"])){
      if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCliente"]) &&
         preg_match('/^[0-9]+$/', $_POST["editarDocumentoId"])){
          
          $tabla = "clientes";
          $datos = array("id"=>$_POST["idCliente"],
                   "nombre"=>$_POST["editarCliente"],
                     "documento"=>$_POST["editarDocumentoId"]);

          $respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);

          if($respuesta == "ok"){
          echo'<script>
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
      }else{
        echo'<script>
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
  }

  /*=============================================
  ELIMINAR CLIENTE
  =============================================*/
  static public function ctrEliminarCliente(){

    if(isset($_GET["idCliente"])){

      $tabla ="clientes";
      $datos = $_GET["idCliente"];
      $respuesta = ModeloClientes::mdlEliminarCliente($tabla, $datos);

      if($respuesta == "ok"){

        echo'<script>
        swal({
            type: "success",
            title: "El cliente ha sido borrado correctamente",
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

  }

} // Llave Principal del ControladorClientes

