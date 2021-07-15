<?php
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";
class AjaxProductos
{ // Inicia la clase AjaxProductos
  
/*================================EDITAR PRODUCTO==========================================*/
  public $idProducto;
  public $traerProductos;
  public $nombreProducto;

  public function ajaxEditarProducto()
  {

    if ($this->traerProductos == "ok") {

      $item = null;
      $valor = null;
      $orden = "id";
      $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
      echo json_encode($respuesta);
    } else if ($this->nombreProducto != "") {

      $item = "nombre";
      $valor = $this->nombreProducto;
      $orden = "id";

      $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
      echo json_encode($respuesta);
    } else {

      $item = "id";
      $valor = $this->idProducto;
      $orden = "id";
      $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
      echo json_encode($respuesta);
    }
  }

/*=============================================
  Validacion para No Repetir Codigo
  =============================================*/
  public $validarCodigo;

  public function ajaxValidarCodigo()
  {

    $item = "codigo";
    $valor = $this->validarCodigo;
    // Aqui se añade el valor para el orden
    $orden = "id";
    // Aqui se añade $orden como tercer parametro
    $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
    echo json_encode($respuesta);
  }


} // Finaliza la clase AjaxProductos

/*=============================================
EDITAR PRODUCTO
=============================================*/
if (isset($_POST["idProducto"])) {

  $editarProducto = new AjaxProductos();
  $editarProducto->idProducto = $_POST["idProducto"];
  $editarProducto->ajaxEditarProducto();
}
/*=============================================
TRAER PRODUCTO
=============================================*/
if (isset($_POST["traerProductos"])) {

  $traerProductos = new AjaxProductos();
  $traerProductos->traerProductos = $_POST["traerProductos"];
  $traerProductos->ajaxEditarProducto();
}
/*=============================================
TRAER PRODUCTO
=============================================*/
if (isset($_POST["nombreProducto"])) {

  $traerProductos = new AjaxProductos();
  $traerProductos->nombreProducto = $_POST["nombreProducto"];
  $traerProductos->ajaxEditarProducto();
}
/*=============================================
Validacion para No Repetir Codigo
=============================================*/
if (isset($_POST["validarCodigo"])) {

  $validarCodigo = new AjaxProductos();
  $validarCodigo->validarCodigo = $_POST["validarCodigo"];
  $validarCodigo->ajaxValidarCodigo();
}
