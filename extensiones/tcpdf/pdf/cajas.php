<?php
require_once "../../../controladores/caja.controlador.php";
require_once "../../../modelos/caja.modelo.php";



require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";





class imprimirCaja{

public $codigo;

public function traerImpresionCaja(){ // Funcion par Impresion de Datos

	ob_start();
	set_time_limit(250);
	ini_set("memory_limit", "256M");
//TRAEMOS LA INFORMACIÓN DE LA VENTA
$itemCaja = "id_caja";
$valorCaja = $this->codigo;

//Recorremos la tabla de ventas para sacar la informacion
$respuestaCaja = ControladorCaja::ctrMostrarCaja($itemCaja, $valorCaja);
//Sacamos la fecha de la venta
// Le asignamos el siguiente formato a la fecha: dia/mes/año
$fechaInicial = $respuestaCaja["fecha_apertura"];
$fechaFinal = $respuestaCaja["fecha_cierre"];

//Decodificamos el JSON productos que se grabó en la tabla ventas
$montoApertura =  $respuestaCaja["monto_apertura"];
$montoCierreVentas =  $respuestaCaja["monto_cierre_ventas"];
$montoCierreGastos =  $respuestaCaja["monto_cierre_gastos"];
$montoCierreTotal =  $respuestaCaja["monto_cierre_total"];




//TRAEMOS LA INFORMACIÓN DEL CLIENTE
$itemUsuario = "id";
$valorUsuario = $respuestaCaja["id_usuario"];
$respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);


//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');

$medidas = array(80, 217); // Ajustar aqui segun los milimetros necesarios;
$pdf = new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false); // En el objeto PDF colocamos los valores

$pdf->setPrintHeader(false); // Para que no exista Cabecera
$pdf->setPrintFooter(false); // Para que no exista Pie de Pagina

$pdf->AddPage(); // Añadimos la pagina en PDF
$pdf->SetXY(7, 12); // el numero 2 representa el tamaño de la letra
//---------------------------------------------------------
$bloque1 = <<<EOF


<table style="font-size:6px; text-align:left">

	<tr>
		<td style="background-color:white; width:auto">
				
			<div style="font-size:8.5px; text-align:center;">
			
				<b>INFORME DE CIERRE DE CAJA</b>
				<img style="width:60px; height:60px;"src="images/logo-empresa.jpg">

			</div>

		</td>
	</tr>
	<br>
	<tr>
	<td style="width:100%;text-align:left;font-size:9px"><b>FECHA DE CORTE</b></td>
	</tr>
	<br>
	<tr>
	<td style="width:40px;"><b>DESDE:</b></td>
	<td style="width:100px;">$fechaInicial </td>
	</tr>
	<br>

	<tr>
	<td style="width:40px;"><b>HASTA:</b></td>
	<td style="width:100px;">$fechaFinal </td>
	</tr>
	<div  style="text-align:center;font-size:7px;">*******************************************************</div>
	<br>

	<tr>
	<td style="width:60px;"><b>VENDEDOR</b></td>
	<td style="width:100px;">$respuestaUsuario[nombre] </td>
	</tr>
	<br>

	<tr>
	<td style="width:60px;"><b>Monto Inicial:</b></td>
	<td style="width:100px;">S/ $montoApertura</td>
	</tr>


	<tr>
	<td style="width:60px;"><b>Total ventas:</b></td>
	<td style="width:100px;">S/ $montoCierreVentas</td>
	</tr>

	<tr>
	<td style="width:60px;"><b>Total Gastos:</b></td>
	<td style="width:100px;">S/ $montoCierreGastos</td>
	</tr>
	<tr>
	<td style="width:60px;"></td>
	<td style="width:100px;">---------------------</td>
	</tr>
	<br>

	<tr>
	<td style="width:60px;font-size:7px"><b>TOTAL EN CAJA:</b></td>
	<td style="width:100px;font-size:12px">S/ $montoCierreTotal</td>
	</tr>


EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');

//$pdf->SetXY(7, 30);

// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 
//$pdf->Output('factura.pdf', 'D');
ob_end_clean();

$pdf->Output('cajas.pdf');
}
}

$cajas = new imprimirCaja();
$cajas -> codigo =$_GET["idCaja"];
$cajas -> traerImpresionCaja();
?>