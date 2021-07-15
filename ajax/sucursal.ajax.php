<?php

require_once "../controladores/sucursal.controlador.php";
require_once "../modelos/sucursal.modelo.php";

class AjaxSucursal
{

  /*=============================================
	EDITAR SUCURSAL
	=============================================*/
  public $idSucursal;
  public function ajaxEditarSucursal()
  {

    $item = "id";
    $valor = $this->idSucursal;

    $respuesta = ControladorSucursal::ctrMostrarSucursal($item, $valor);
    echo json_encode($respuesta);
  }
}

/*=============================================
EDITAR SUCURSAL
=============================================*/

if (isset($_POST["idSucursal"])) {

  $sucursal = new AjaxSucursal();
  $sucursal->idSucursal = $_POST["idSucursal"];
  $sucursal->ajaxEditarSucursal();
}
