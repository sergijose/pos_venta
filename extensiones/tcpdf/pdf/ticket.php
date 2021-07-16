<?php
require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";



class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){ // Funcion par Impresion de Datos

	ob_start();
	set_time_limit(250);
	ini_set("memory_limit", "256M");
//TRAEMOS LA INFORMACIÓN DE LA VENTA
$itemVenta = "codigo";
$valorVenta = $this->codigo;

//Recorremos la tabla de ventas para sacar la informacion
$respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);
//Sacamos la fecha de la venta
// Le asignamos el siguiente formato a la fecha: dia/mes/año
$fecha = date('d/m/Y',strtotime(substr($respuestaVenta[0]["fecha"],0,-8)));

//Decodificamos el JSON productos que se grabó en la tabla ventas
$productos = json_decode($respuestaVenta[0]["productos"], true);

//Sacamos los datos que queremos mostrar 
$neto = number_format($respuestaVenta[0]["neto"],2);
$impuesto = number_format($respuestaVenta[0]["impuesto"],2);
$pagado = number_format($respuestaVenta[0]["pagocon"],2);
$devuelto = number_format($respuestaVenta[0]["vuelto"],2);
$total = number_format($respuestaVenta[0]["total"],2);
$metodopago = $respuestaVenta[0]["metodo_pago"];
$codigotransaccion = $respuestaVenta[0]["codigoTransaccion"];


//TRAEMOS LA INFORMACIÓN DEL CLIENTE
$itemCliente = "id";
$valorCliente = $respuestaVenta[0]["id_cliente"];
$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR
$itemVendedor = "id";
$valorVendedor = $respuestaVenta[0]["id_vendedor"];
$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

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
				<b>SECURITY AND HADWARE PERU</b>
				<img style="width:60px; height:60px;"src="images/logo-empresa.jpg">

			</div>

		</td>
	</tr>
	<br>

	<tr>
	<td style="width:40px;"><b>Ruc:</b></td>
	<td style="width:100px;">20603001401</td>
	</tr>
	
	<tr>
	<td style="width:40px;"><b>Telefono:</b></td>
	<td style="width:100px;">938133130</td>
	</tr>


	<tr>
	<td style="width:40px;"><b>Direccion:</b></td>
	<td style="width:100px;">Jr Bolognesi 1031</td>
	</tr>


	<tr>
	<td style="width:40px;"><b>Ticket:</b></td>
	<td style="width:50px;">$valorVenta</td>
	<td style="width:40px;"><b>Fecha:</b></td>
	<td style="width:50px;">$fecha</td>
	</tr>
	<br>

	<tr>
	<div style="font-size:7.5px; text-align:left;">
	<b>Datos del Cliente</b>
	</div>
	</tr>

	<br>

	<tr>
	<td style="width:40px;"><b>Nombre:</b></td>
	<td style="width:100px;">$respuestaCliente[razon_social]</td>
	</tr>

	<tr>
	<td style="width:40px;"><b>DNI:</b></td>
	<td style="width:100px;">$respuestaCliente[ruc]</td>
	</tr>

	<tr>
	<td style="width:40px;"><b>Telefono:</b></td>
	<td style="width:100px;">$respuestaCliente[telefono]</td>
	</tr>
	
	<tr>
	<td style="width:40px;"><b>Dirección:</b></td>
	<td style="width:100px;">$respuestaCliente[direccion]</td>
	</tr>

	

</table>

<div  style="text-align:center;font-size:7px;">*******************************************************</div>

<tr>
<div style="font-size:7.5px; text-align:left;">
<b>Detalles del producto</b>
</div>
</tr>

<br>

<table style="font-size:6px; text-align:left">
	<tr style="text-align:left; font-weight: bold">
		<td style="width:25px;">CANT</td>
		<td style="width:75px;">DETALLE</td>
		<td style="width:40px; text-align: right;">P.U</td>
		<td style="width:30px; text-align: right;">TOTAL</td>
	</tr>
</table>

EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');
// ---------------------------------------------------------
// Aca colocamos losdatos de la tabla de arriba CANT DETALLE P.U y TOTAL
foreach ($productos as $key => $item) {

$valorUnitario = number_format($item["precio"], 2);
$precioTotal = number_format($item["total"], 2);
$bloque2 = <<<EOF
<table id="valoresProducto" style="font-size:5px;">
	<tr style="text-align:left;">
		<td style="width:25px;text-align: center;">$item[cantidad]</td>
		<td style="width:75px;">$item[descripcion]</td>
		<td style="width:35px; text-align: right;">$valorUnitario</td>
		<td style="width:30px; text-align: right;">$precioTotal</td>
	</tr>
</table>
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');
}
// ---------------------------------------------------------
$bloque3 = <<<EOF
<table style="font-size:6px; text-align:right; padding-right: 5px">
<br>
<br>
<br>
<tr>
<td style="width:30px;"></td>
<td style="width:10px;"></td>
<td style="width:90px;">Sub Total:</td>
<td style="text-align: right;">$neto</td>
<td style="width:30px;"></td>
</tr>
<tr>
<td style="width:30px;"></td>
<td style="width:10px;"></td>
<td style="width:90px;">IGV:</td>
<td style="text-align: right;">$impuesto</td>
<td style="width:30px;"></td>
</tr>

	<tr>
		<td style="width:30px;"></td>
		<td style="width:10px;"></td>
		<td style="width:90px;"><b>Total:</b></td>
		<td style="text-align: right;">$total</td>
		<td style="width:30px;"></td>
	</tr>
	<tr>
        <td style="width:30px;"></td>
		<td style="width:10px;"></td>
		<td style="width:90px;">Metodo Pago:</td>
		<td style="text-align: right;">$metodopago</td>
	</tr>
	<tr>
        <td style="width:30px;"></td>
		<td style="width:10px;"></td>
		<td style="width:90px;">Nº OP:</td>
		<td style="text-align: right;">$codigotransaccion</td>
	</tr>

	
</table>

<div  style="text-align:center;font-size:7px;">  *****************************************************</div>
<table style="text-align:center;font-size:6px;">
	
	<tr   style="font-size:6px;">
			<td >Nota de Venta</td>
	</tr>

	<tr>
		<td>Atendido por: $respuestaVendedor[nombre]</td>
	</tr>

	<tr   style="font-weight: bold">
			<td >Gracias por su preferencia</td>
	</tr>
	
	


</table>

EOF;
//$pdf->SetXY(7, 30);
$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 
//$pdf->Output('factura.pdf', 'D');
ob_end_clean();

$pdf->Output('factura.pdf');
}
}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();
?>