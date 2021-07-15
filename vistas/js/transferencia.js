/*====================== 
CARGAR LA TABLA DINÁMICA DE PRODUCTOS PRINCIPAL 
=============================================*/
// $.ajax({
//  url: "ajax/datatable-productos.ajax.php",
//  success:function(respuesta){  
//    console.log("respuesta", respuesta);
//  }
// })
var sedeoculta = $("#sedeoculta").val();
$('.tablaTransfiere').DataTable( {
    "ajax": "ajax/datatable-transferencias.ajax.php?sedeoculta="+sedeoculta,
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

/*=============================================
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/
$(".tablaTransfiere tbody").on("click", "button.agregarProducto", function () {

  var idProducto = $(this).attr("idProducto");
  $(this).removeClass("btn-primary agregarProducto");
  $(this).addClass("btn-default");
  var datos = new FormData();
  datos.append("idProducto", idProducto);

  $.ajax({

    url: "ajax/productos-sucursal.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {

      var descripcion = respuesta["nombre"];
      let stock = respuesta["stock"];
      var precio = respuesta["precio_venta"];
      /*=============================================
      EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
      =============================================*/
      if (stock == 0) {

        swal({
          title: "No hay stock disponible",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

        $("button[idProducto='" + idProducto + "']").addClass("btn-primary agregarProducto");
        return;
      }

      $(".nuevaTransferencia").append(
        '<div class="row" style="padding:5px 15px">' +
        '<!-- Descripción del producto -->' +
        '<div class="col-xs-10" style="padding-right:0px">' +
        '<div class="input-group">' +
        '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' + idProducto + '"><i class="fa fa-times"></i></button></span>' +
        '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="' + idProducto + '" name="agregarProducto" value="' + descripcion + '" readonly required>' +
        '</div>' +
        '</div>' +

        '<!-- Cantidad del producto -->' +
        '<div class="col-xs-2 divCantidad">' + // Se asigna una clase llamada divCantidad para identificar los valores
        '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock="' + stock + '" nuevoStock="' + Number(stock - 1) + '" required>' +
        '</div>' +
        '</div>' +


        '</div>')

      // AGRUPAR PRODUCTOS EN FORMATO JSON
      listarTransferencias()
      // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
      $(".nuevoPrecioProducto").number(true, 2);
      localStorage.removeItem("quitarProducto");
    }
  })
});
/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/
$(".tablaTransfiere").on("draw.dt", function () {
  if (localStorage.getItem("quitarProducto") != null) {
    var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
    for (var i = 0; i < listaIdProductos.length; i++) {

      $("button.recuperarBoton[idProducto='" + listaIdProductos[i]["idProducto"] + "']").removeClass('btn-default');
      $("button.recuperarBoton[idProducto='" + listaIdProductos[i]["idProducto"] + "']").addClass('btn-primary agregarProducto');

    }

  }

})

/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/
var idQuitarProducto = [];
localStorage.removeItem("quitarProducto");

$(".formularioTransferencia").on("click", "button.quitarProducto", function () {
  $(this).parent().parent().parent().parent().remove();
  var idProducto = $(this).attr("idProducto");
  /*=============================================
  ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
  =============================================*/
  if (localStorage.getItem("quitarProducto") == null) {

    idQuitarProducto = [];
  } else {

    idQuitarProducto.concat(localStorage.getItem("quitarProducto"))
  }
  idQuitarProducto.push({ "idProducto": idProducto });
  localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));
  $("button.recuperarBoton[idProducto='" + idProducto + "']").removeClass('btn-default');
  $("button.recuperarBoton[idProducto='" + idProducto + "']").addClass('btn-primary agregarProducto');

  if ($(".nuevoProducto").children().length == 0) {

    $("#SubTotal").val(0);
    $("#nuevoImpuestoVenta").val(0);
    $("#nuevoTotalVenta").val(0);
    $("#totalVenta").val(0);
    $("#nuevoTotalVenta").attr("total", 0);

  } else {

    // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarTransferencias();
  }
})

/*========================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARADISPOSITIVOS
 =============================================*/
var numProducto = 0;
$(".btnAgregarProducto").click(function () {

  numProducto++;

  var datos = new FormData();
  datos.append("traerProductos", "ok");

  $.ajax({

    url: "ajax/productos-sucursal.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {

      $(".nuevoProducto").append(

        '<div class="row" style="padding:5px 15px">' +
        '<!-- Descripción del producto -->' +
        '<div class="col-xs-6" style="padding-right:0px">' +
        '<div class="input-group">' +
        '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>' +
        '<select class="form-control nuevaDescripcionProducto" id="producto' + numProducto + '" idProducto name="nuevaDescripcionProducto" required>' +
        '<option>Seleccione el producto</option>' +
        '</select>' +
        '</div>' +
        '</div>' +
        '<!-- Cantidad del producto -->' +
        '<div class="col-xs-3 ingresoCantidad">' +
        '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="0" stock nuevoStock required>' +
        '</div>' +
        '<!-- Precio del producto -->' +
        '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">' +
        '<div class="input-group">' +
        '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
        '<input type="text" class="form-control nuevoPrecioProducto" precioReal="" name="nuevoPrecioProducto" readonly required>' +
        '</div>' +
        '</div>' +
        '</div>');

      // AGREGAR LOS PRODUCTOS AL SELECT 
      respuesta.forEach(funcionForEach);
      function funcionForEach(item, index) {
        if (item.stock != 0) {
          $("#producto" + numProducto).append(
            '<option idProducto="' + item.id + '" value="' + item.descripcion + '">' + item.descripcion + '</option>'
          )
        }
      }

      // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
      $(".nuevoPrecioProducto").number(true, 2);
    }
  })
})

/*==========================================
SELECCIONAR PRODUCTO 
formularioTransferencia
=============================================*/
$(".formularioTransferencia").on("change", "select.nuevaDescripcionProducto", function () {
  var nombreProducto = $(this).val();
  var nuevaDescripcionProducto = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionProducto");
  var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
  var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");
  var datos = new FormData();
  datos.append("nombreProducto", nombreProducto);

  $.ajax({

    url: "ajax/productos-sucursal.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {

      $(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
      $(nuevaCantidadProducto).attr("stock", respuesta["stock"]);
      $(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["stock"]) - 1);
      $(nuevoPrecioProducto).val(respuesta["precio_venta"]);
      $(nuevoPrecioProducto).attr("precioReal", respuesta["precio_venta"]);

      // AGRUPAR PRODUCTOS EN FORMATO JSON
      listarTransferencias()
    }
  })
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/
$(".formularioTransferencia").on("change", ".nuevaCantidadProducto", function () {

  let nuevoStock = Number($(this).attr("stock")) - $(this).val();
  $(this).attr("nuevoStock", nuevoStock);

  if (Number($(this).val()) > Number($(this).attr("stock"))) {
    /*===========================================
    SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES 
    =============================================*/
    $(this).val(0);
    $(this).attr("nuevoStock", $(this).attr("stock"));

    sumarTotalPrecios();

    swal({
      title: "La cantidad supera el Stock",
      text: "¡Sólo hay " + $(this).attr("stock") + " unidades!",
      type: "error",
      confirmButtonText: "¡Cerrar!"
    });

    return;

  }

  // AGRUPAR PRODUCTOS EN FORMATO JSON
  listarTransferencias()
})


/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/
function listarTransferencias() {

  var listaTransferencias = [];
  var descripcion = $(".nuevaDescripcionProducto");
  let cantidad = $(".nuevaCantidadProducto");
  var precio = $(".nuevoPrecioProducto");

  for (var i = 0; i < descripcion.length; i++) {
    var total=Number($(precio[i]).attr("precioReal"))*Number($(cantidad[i]).val()); // Caculamos el Total
    console.log("total", total);

    listaTransferencias.push({
      "id": $(descripcion[i]).attr("idProducto"),
      "descripcion": $(descripcion[i]).val(),
      "cantidad": $(cantidad[i]).val(),
      "stock": $(cantidad[i]).attr("nuevoStock"),
      "precio": $(precio[i]).attr("precioReal"),
      "total": total // Mostramos el Total a Pagar
    })
  }
  $("#listaTransferencias").val(JSON.stringify(listaTransferencias));
  console.log(listaTransferencias,"listaTransferencias");
}



/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/
function quitarAgregarProducto() {

  var idProductos = $(".quitarProducto");
 
  var botonesTabla = $(".tablaTransfiere tbody button.agregarProducto");

  for (var i = 0; i < idProductos.length; i++) {
  
    var boton = $(idProductos[i]).attr("idProducto");
    for (var j = 0; j < botonesTabla.length; j++) {

      if ($(botonesTabla[j]).attr("idProducto") == boton) {

        $(botonesTabla[j]).removeClass("btn-primary agregarProducto");
        $(botonesTabla[j]).addClass("btn-default");

      }
    }
  }
}
/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/
$('.tablaTransfiere').on('draw.dt', function () {
  quitarAgregarProducto();

})


