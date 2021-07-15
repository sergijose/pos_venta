<?php
//REQUEIRMOS CONTROLADORES Y MODELOS A UTILIZAR
require_once "../../controladores/productos.controlador.php";
require_once "../../modelos/productos.modelo.php";

require_once "../../controladores/proveedores.controlador.php";
require_once "../../modelos/proveedores.modelo.php";

require_once "../../controladores/compras.controlador.php";
require_once "../../modelos/compras.modelo.php";

require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";

require_once "../../controladores/sucursal.controlador.php";
require_once "../../modelos/sucursal.modelo.php";


$reporte_compras = new ControladorCompras();
$reporte_compras -> ctrDescargarReporte();