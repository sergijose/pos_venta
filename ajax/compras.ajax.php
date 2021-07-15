<?php
require_once "../controladores/compras.controlador.php";
require_once "../modelos/compras.modelo.php";

class AjaxCompras
{ // Inicia la lase AjaxCompras

  /*=============================================
  Validacion para No Repetir Código
  =============================================*/
  public $validameCodigo;
  public function ajaxValidaCodigo()
  {

    $item = "codigo";
    $valor = $this->validameCodigo;
    // Aquí se añade el valor para el orden
    //$orden = "id";
    // Aquí se añade $orden como tercer parametro
    $respuesta = ControladorCompras::ctrMostrarCompras($item, $valor);
    echo json_encode($respuesta);
  }
} // Finaliza la clase AjaxCompras

/*=============================================
Validacion para No Repetir Código
=============================================*/
if (isset($_POST["validameCodigo"])) {

  $validameCodigo = new AjaxCompras();
  $validameCodigo->validameCodigo = $_POST["validameCodigo"];
  $validameCodigo->ajaxValidaCodigo();
}
