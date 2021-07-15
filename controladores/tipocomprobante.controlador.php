<?php

class ControladorComprobante
{
  /*==================================== 
  MOSTRAR LO EXISTENTE EN CAJA 
  =============================================*/
  static public function ctrMostraTipo($item, $valor)
  {

    $tabla = "tipo_comprobante";
    $respuesta = ModeloTipo::mdlMostrarComprobante($tabla, $item, $valor);
    return $respuesta;
  }

}  