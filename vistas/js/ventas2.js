


 //$.ajax({
  //url: "ajax/datatable-listado-ventas.ajax.php",
  //success:function(respuesta){
 // console.log("respuesta", respuesta);
  //}
//});// 


var perfilOculto = $("#perfilOculto").val();
var idUsuario = $("#idUsuario").val();
$('.tablaListadoVentas').dataTable({
  "ajax": "ajax/datatable-listado-ventas.ajax.php?perfilOculto=" +perfilOculto,
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

	}

} );
/*=============================================
BOTON EDITAR VENTA
=============================================*/
$(".tablaListadoVentas").on("click", ".btnEditarVenta", function () {
  var idVenta = $(this).attr("idVenta");
  window.location = "index.php?ruta=editar-venta&idVenta=" + idVenta;
})
/*=============================================IMPRIMIR FACTURA=============================================*/
$(".tablaListadoVentas").on("click", ".btnImprimirFactura", function () {
  var codigoVenta = $(this).attr("codigoVenta");
  window.open("extensiones/tcpdf/pdf/ticket.php?codigo=" + codigoVenta, "_blank");
})

/*=============================================
BORRAR VENTA
=============================================*/
$(".tablaListadoVentas").on("click", ".btnEliminarVenta", function () {

  var idVenta = $(this).attr("idVenta");
console.log(idVenta);
  swal({
    title: '¿Está seguro de borrar la venta?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar venta!'
  }).then(function (result) {
    if (result.value) {

      window.location = "index.php?ruta=ventas&idVenta=" + idVenta;
    }
  })
})
