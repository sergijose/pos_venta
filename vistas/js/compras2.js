
//var idSede=$("#idSede").val();

/*$.ajax({
  url: "ajax/datatable-listado-compras.ajax.php?idUsuario="+idUsuario,
  success:function(respuesta){
    console.log("respuesta", respuesta);
  }
})*/
var idUsuario = $("#idUsuario").val();
$('.tablaListadoCompras').dataTable({
  "ajax": "ajax/datatable-listado-compras.ajax.php?idUsuario="+idUsuario,
  //"ajax": "ajax/datatable-listado-compras.ajax.php?idSede="+idSede,
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "language": {

    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
      "sFirst": "Primero",
      "sLast": "Último",
      "sNext": "Siguiente",
      "sPrevious": "Anterior"
    },
    "oAria": {
      "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }

  },
  "lengthMenu": [3, 10, 15, 20, 50, 100],
  "pageLength": 3

});
/*=============================================
    BOTON EDITAR COMPRA
=============================================*/
/*$(".btnEditarCompra").click(function(){
    let idCompra = $(this).attr("idCompra");
    window.location = "index.php?ruta=editar-compra&idCompra="+idCompra;
})
*//*=============================================
 BOTON EDITAR COMPRA
=============================================*/
$(".tablaListadoCompras").on("click", ".btnEditarCompra", function () {
  var idCompra = $(this).attr("idCompra");
  window.location = "index.php?ruta=editar-compra&idCompra="+idCompra;
})