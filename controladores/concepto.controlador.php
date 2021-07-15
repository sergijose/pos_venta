<?php

class ControladorConcepto
{
  /*==================================== 
  MOSTRAR LO EXISTENTE EN CAJA 
  =============================================*/
  static public function ctrMostraConcepto($item, $valor)
  {

    $tabla = "concepto";
    $respuesta = ModeloConcepto::mdlMostrarConcepto($tabla, $item, $valor);
    return $respuesta;
  }

}  