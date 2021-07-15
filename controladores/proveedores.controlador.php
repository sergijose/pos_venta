<?php

class ControladorProveedor{

  /*=============================================
  MOSTRAR PROVEEDORES
  =============================================*/
  static public function ctrMostrarProveedor($item, $valor){
    $tabla = "proveedor";
    $respuesta = ModeloProveedor::mdlMostrarProveedor($tabla, $item, $valor);
    return $respuesta;
  }
  /*=============================================
  REGISTRAR PROVEEDORES
  =============================================*/
  // static public function ctrNuevoProveedor(){

  //  if(isset($_POST["nuevaRSocial"])){

  //    if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoDNI"]) &&      
 //               preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevaRSocial"]) && 
 //               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaMarca"]) &&
 //               preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevaDireccionP"]) &&
 //               preg_match('/^[()\-0-9 ]+$/', $_POST["nuevoTelefono"])){

  //        $tabla = "proveedor";
  //        $datos = array(
  //                     "ruc_proveedor"=>$_POST["nuevoRUC"],
  //                     "razon_social"=>$_POST["nuevaRSocial"],
  //                     "nombre_comercial"=>$_POST["nuevaMarca"],
  //                     "direccion_fiscal"=>$_POST["nuevaDireccionP"],
  //                     "tipo_empresa"=>$_POST["nuevoTipoEmp"], 
  //                     "estado_empresa"=>$_POST["estado"]),
  //                       "condicion_empresa"=>$_POST["condicion"]);

  //        $respuesta = ModeloProveedor::mdlNuevoProveedor($tabla, $datos);

  //        if($respuesta == "ok"){

  //        echo'<script>
  //        swal({
  //            type: "success",
  //            title: "Nuevo Proveedor Grabado Exitosamente",
  //            showConfirmButton: true,
  //            confirmButtonText: "Cerrar"
  //            }).then(function(result){
  //                if (result.value) {
  //                window.location = "proveedores";
  //                }
  //              })
  //        </script>';
  //      }
  //    }else{
  //      echo'<script>
  //        swal({
  //            type: "error",
  //            title: "¡Error. No se puede grabar. Consulte con el Soporte del Sistema!",
  //            showConfirmButton: true,
  //            confirmButtonText: "Cerrar"
  //            }).then(function(result){
  //            if (result.value) {
  //            window.location = "proveedores";
  //            }
  //          })
  //        </script>';
  //    }
  //  }
  // }

  /*=============================================
  REGISTRAR PROVEEDORES
  =============================================*/

static public function ctrNuevoProveedor(){
    if(isset($_POST["nuevoRUC"])){ // Inicia llave isset

      
         $tabla = "proveedor";
          $datos = array(
                       "ruc_proveedor"=>$_POST["nuevoRUC"],
                       "razon_social"=>$_POST["nuevaRSocial"],
                       "nombre_comercial"=>$_POST["nuevaMarca"],
                       "direccion_fiscal"=>$_POST["nuevaDireccionP"],
                       "tipo_empresa"=>$_POST["nuevoTipoEmp"], 
                       "estado_empresa"=>$_POST["estado"],
                        "condicion_empresa"=>$_POST["condicion"]);

          $respuesta = ModeloProveedor::mdlNuevoProveedor($tabla, $datos);

                /*var_dump($respuesta);
                return;*/

          if($respuesta == "ok"){

          echo'<script>
          swal({
              type: "success",
              title: "Nuevo Proveedor Grabado Exitosamente",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                  if (result.value) {
                  window.location = "proveedores";
                  }
                })
          </script>';
        }
      }
  }







}
