/*====================== 
CARGAR LA TABLA DINÁMICA DE PRODUCTOS PRINCIPAL 
=============================================*/
// $.ajax({
// 	url: "ajax/datatable-productos.ajax.php",
// 	success:function(respuesta){	
// 		console.log("respuesta", respuesta);
// 	}
// })
var perfilOculto = $("#perfilOculto").val();
$('.tablaGastos').DataTable( {
    "deferRender": true,
	"retrieve": true,
	"processing": true,
  
	 "language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

	},
  "lengthMenu":[5, 10, 15, 20, 50, 100],
  "pageLength":5

});
/* Funcion suma.
function SumarAutomatico (valor) {
	var TotalSuma = 0;  
    valor = parseInt(valor); // Convertir a numero entero (número).
    totalCierre = document.getElementById('monto_cierre_ventas').value;
    totalGastos = document.getElementById('monto_cierre_gastos').value;
    console.log(totalCierre);
    console.log(totalGastos);
  //  console.log(totalSuma);
    // Valida y pone en cero "0".
  
    Variable genrando la suma. 
    TotalSuma = Number(totalCierre) - Number(totalGastos);
    console.log(TotalSuma);
    // Escribir el resultado en una etiqueta "span".
	document.getElementById("monto_cierre_final").value=TotalSuma;  
    //$("#monto_cierre_final").val(TotalSuma);
   

*/
