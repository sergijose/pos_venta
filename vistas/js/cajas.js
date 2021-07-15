
/*PASAMOS LA VARIABLE CON LA QUE SE REALIZA EL FILTRADO EN LA TABLA*/
//var sedeoculta = $("#sedeoculta").val();
var idUsuario = $("#idUsuario").val();

/*HACEMOS MENCION A LA CLASE DE LA TABLA Y AL AJAX QUE UTILIZAREMOS*/
$(".tablaListadoCajas").DataTable({
    "ajax": "ajax/datatable-listado-cajas.ajax.php?idUsuario="+idUsuario,
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