/*====================== 
CARGAR LA TABLA DINÁMICA DE PRODUCTOS PRINCIPAL 
=============================================*/

var sedeoculta = $("#sedeoculta").val();
$('.tablaN').DataTable( {
    "ajax": "ajax/datatable-ventas-sucursal.ajax.php?sedeoculta="+sedeoculta,
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
$(".tablaN tbody").on("click", "button.agregarProducto", function () {

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

      $(".nuevoProducto").append(
        '<div class="row" style="padding:5px 15px">' +
        '<!-- Descripción del producto -->' +
        '<div class="col-xs-6" style="padding-right:0px">' +
        '<div class="input-group">' +
        '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' + idProducto + '"><i class="fa fa-times"></i></button></span>' +
        '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="' + idProducto + '" name="agregarProducto" value="' + descripcion + '" readonly required>' +
        '</div>' +
        '</div>' +

        '<!-- Cantidad del producto -->' +
        '<div class="col-xs-3 divCantidad">' + // Se asigna una clase llamada divCantidad para identificar los valores
        '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock="' + stock + '" nuevoStock="' + Number(stock - 1) + '" required>' +
        '</div>' +

        '<!-- Precio de Venta del Producto -->' +
        '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">' + // Se asigna una clase llamada ingresoPrecio pra identificar los valores dentro
        '<div class="input-group">' +
        '<span class="input-group-addon"><i>S/</i></span>' +
        '<input type="text" class="form-control nuevoPrecioProducto" precioReal="' + precio + '" name="nuevoPrecioProducto" value="' + precio + '" readonly required>' +
        '</div>' +
        '</div>' +
  


        '</div>')

      // SUMAR TOTAL DE PRECIOS
      sumarTotalPrecios()
      // AGREGAR IMPUESTO
     // agregarImpuesto()
      calcularSubTotal()
      calcularIGV()
      // AGRUPAR PRODUCTOS EN FORMATO JSON
      listarProductos()
      // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
      $(".nuevoPrecioProducto").number(true, 2);
      localStorage.removeItem("quitarProducto");
    }
  })
});
/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/
$(".tablaN").on("draw.dt", function () {
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

$(".formularioVenta").on("click", "button.quitarProducto", function () {
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

    // SUMAR TOTAL DE PRECIOS
    sumarTotalPrecios()
   
    calcularSubTotal()
    calcularIGV()
    // AGRUPAR PRODUCTOS EN FORMATO JSON
    listarProductos();
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
      // SUMAR TOTAL DE PRECIOS
      sumarTotalPrecios()
      // AGREGAR IMPUESTO
      calcularSubTotal()
      calcularIGV()
      // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
      $(".nuevoPrecioProducto").number(true, 2);
    }
  })
})

/*==========================================
SELECCIONAR PRODUCTO
=============================================*/
$(".formularioVenta").on("change", "select.nuevaDescripcionProducto", function () {
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
      listarProductos()
    }
  })
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/
$(".formularioVenta").on("change", ".nuevaCantidadProducto", function () {
  
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
  // SUMAR TOTAL DE PRECIOS
  sumarTotalPrecios()

  calcularSubTotal()
  calcularIGV()
  // AGRUPAR PRODUCTOS EN FORMATO JSON
  listarProductos()
})



/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/
function sumarTotalPrecios() {

  var precioItem = $(".nuevoPrecioProducto");
  var cajasCant=$(".nuevaCantidadProducto");
  var arraySumaPrecio = [];

  for (var i = 0; i < precioItem.length; i++) {
    var totalFinal=Number($(precioItem[i]).attr("precioReal"))*Number($(cajasCant[i]).val());
    // arraySumaPrecio.push(Number($(precioItem[i]).val()));
    arraySumaPrecio.push(Number(totalFinal));
  }

  function sumaArrayPrecios(total,numero) {
    return total + numero;
  }
  var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);

  $("#nuevoTotalVenta").val(sumaTotalPrecio);
  $("#totalVenta").val(sumaTotalPrecio);
  $("#nuevoTotalVenta").attr("total", sumaTotalPrecio);
}
/*=============================================
FUNCIÓN CALCULAR SUBTOTAL
=============================================*/
function calcularSubTotal() {
  var Notas  = "0";
  var facturador = $("#nuevaFactura").val();

  if (facturador == "1") {
  var tamalitos2 = $("#nuevoTotalVenta").attr("total");
  let subtotal = Number(tamalitos2 / 1.18).toFixed(2);
  $("#SubTotal").val(subtotal).number(true,2);
     console.log("subtotal", subtotal);
     
}else{ //Caso contrario valor cero
    $("#SubTotal").val(Notas).number(true,2);
  }

}
/*=============================================
FUNCIÓN CALCULAR IGV
=============================================*/
function calcularIGV() {
  var Boleta  = "0";
  var antes = $("#SubTotal").val();
  var facturita = $("#nuevaFactura").val();

  if (facturita == "1") {  // SI el valor es de 1(Factura)
    let Igv = Number(antes * 0.18 ).toFixed(2);
     $("#nuevoImpuestoVenta").val(Igv);
    console.log("Igv", Igv);
  }else{ //Caso contrario valor cero
    $("#nuevoImpuestoVenta").val(Boleta);
  }
  
}

/*============================ 
FORMATO AL PRECIO FINAL 
============================================*/
$("#nuevoTotalVenta").number(true, 2);
/*============================ 
FORMATO AL SUBTOTAL 
============================================*/  
$('SubTotal.number').number(true, 2);
/*============================ 
FORMATO AL IGV
============================================*/
$("#nuevoImpuestoVenta").number(true, 2);
/*================================ 
SELECCIONAR MÉTODO DE PAGO 
============================================*/
$("#nuevoMetodoPago").change(function () {

  var metodo = $(this).val();
  if (metodo == "Efectivo") {

    $(this).parent().parent().removeClass("col-xs-6");
    $(this).parent().parent().addClass("col-xs-4");
    $(this).parent().parent().parent().children(".cajasMetodoPago").html(

      '<div class="col-xs-4">' +

      '<div class="input-group">' +
      '<span class="input-group-addon"><i>S/</i></span>' +
      '<input type="text" class="form-control" name="nuevoValorEfectivo" id="nuevoValorEfectivo" placeholder="000000" required>' +
      '</div>' +
      '</div>' +
      '<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">' +
      '<div class="input-group">' +
      '<span class="input-group-addon"><i>S/</i></span>' +
      '<input type="text" class="form-control" style="height:60px"  name="nuevoCambioEfectivo" id="nuevoCambioEfectivo" placeholder="000000" readonly required>' +
      '</div>' +
      '</div>'
    )

    // Agregar formato al precio
    $('#nuevoValorEfectivo').number(true, 2);
    $('#nuevoCambioEfectivo').number(true, 2);
    // Listar método en la entrada
    listarMetodos()
  } else {

    $(this).parent().parent().removeClass('col-xs-4');
    $(this).parent().parent().addClass('col-xs-6');
    $(this).parent().parent().parent().children('.cajasMetodoPago').html(

      '<div class="col-xs-6" style="padding-left:0px">' +
      '<div class="input-group">' +
      '<input type="number" min="0" class="form-control" id="nuevoCodigoTransaccion" placeholder="Código transacción"  required>' +
      '<span class="input-group-addon"><i class="fa fa-lock"></i></span>' +
      '</div>' +
      '</div>')
  }
})


/*=============================================
CAMBIO TRANSACCIÓN
=============================================*/
$(".formularioVenta").on("change", "input#nuevoCodigoTransaccion", function () {
  // Listar método en la entrada
  listarMetodos()
})

/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/
function listarProductos() {

  var listaProductos = [];
  var descripcion = $(".nuevaDescripcionProducto");
  let cantidad = $(".nuevaCantidadProducto");
  var precio = $(".nuevoPrecioProducto");

  for (var i = 0; i < descripcion.length; i++) {
    var total=Number($(precio[i]).attr("precioReal"))*Number($(cantidad[i]).val()); // Caculamos el Total
    console.log("total", total);

    listaProductos.push({
      "id": $(descripcion[i]).attr("idProducto"),
      "descripcion": $(descripcion[i]).val(),
      "cantidad": $(cantidad[i]).val(),
      "stock": $(cantidad[i]).attr("nuevoStock"),
      "precio": $(precio[i]).attr("precioReal"),
      "total": total // Mostramos el Total a Pagar
    })
  }
  $("#listaProductos").val(JSON.stringify(listaProductos));
}

/*=============================================
LISTAR MÉTODO DE PAGO
=============================================*/
function listarMetodos() {

  var listaMetodos = "";
  if ($("#nuevoMetodoPago").val() == "Efectivo") {

    $("#listaMetodoPago").val("Efectivo");
  } else {
    $("#listaMetodoPago").val($("#nuevoMetodoPago").val());
    $("#codigoTransaccion").val($("#nuevoCodigoTransaccion").val());
  }
}

/*=============================================
  REGISTRA EL CODIGO DE TRANSACCION
=============================================*/
 var codigoTransaccion = $("#nuevoCodigoTransaccion").val();
/*=============================================
CAMBIO EN EFECTIVO
=============================================*/
$(".formularioVenta").on("change", "input#nuevoValorEfectivo", function () {
  
  
  var efectivo = $(this).val(); // Obtenemos el valor del efectivo
  
 if(Number(efectivo) < Number($('#nuevoTotalVenta').val())){ // Condicion para que el cambio sea positivo
   swal({
          title: "El valor debe ser mayor o igual al Total a Pagar",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
  //  Se limpian las cajas de texto
   $("#nuevoValorEfectivo").val("");
   $("#nuevoCambioEfectivo").val("");
 } else{
  // Caso contrario se ejecuta el proceso con normalidad
  var cambio = Number(efectivo) - Number($('#nuevoTotalVenta').val());
  $("#nuevoCambioEfectivo").val(cambio).number(true,2);
}

})
/*=============================================
BOTON EDITAR VENTA
=============================================*/
$(".tablas").on("click", ".btnEditarVenta", function () {

  var idVenta = $(this).attr("idVenta");
  window.location = "index.php?ruta=editar-venta&idVenta=" + idVenta;


})

/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/
function quitarAgregarProducto() {
  //Capturamos todos los id de productos que fueron elegidos en la venta
  var idProductos = $(".quitarProducto");
  //Capturamos todos los botones de agregar que aparecen en la tabla
  var botonesTabla = $(".tablaVentas tbody button.agregarProducto");
  //Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
  for (var i = 0; i < idProductos.length; i++) {
    //Capturamos los Id de los productos agregados a la venta
    var boton = $(idProductos[i]).attr("idProducto");
    //Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
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
$('.tablaN').on('draw.dt', function () {
  quitarAgregarProducto();

})
/*=============================================
BORRAR VENTA
=============================================*/
$(".tablas").on("click", ".btnEliminarVenta", function () {

  var idVenta = $(this).attr("idVenta");

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
/*=============================================
IMPRIMIR FACTURA
=============================================*/
$(".tablas").on("click", ".btnImprimirFactura", function () {
  var codigoVenta = $(this).attr("codigoVenta");
  window.open("extensiones/tcpdf/pdf/ticket.php?codigo=" + codigoVenta, "_blank");
})
/*=============================================
RANGO DE FECHAS
=============================================*/
$('#daterange-btn').daterangepicker(
  {
    ranges: {
      'Hoy': [moment(), moment()],
      'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes': [moment().startOf('month'), moment().endOf('month')],
      'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate: moment()
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var fechaInicial = start.format('YYYY-MM-DD');
    var fechaFinal = end.format('YYYY-MM-DD');
    var capturarRango = $("#daterange-btn span").html();
    localStorage.setItem("capturarRango", capturarRango);
    window.location = "index.php?ruta=ventas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;

  }

)
/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/
$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function () {

  localStorage.removeItem("capturarRango");
  localStorage.clear();
  window.location = "ventas";
})
/*=============================================
CAPTURAR HOY
=============================================*/
$(".daterangepicker.opensleft .ranges li").on("click", function () {
  var textoHoy = $(this).attr("data-range-key");

  if (textoHoy == "Hoy") {

    var d = new Date();

    var dia = d.getDate();
    var mes = d.getMonth() + 1;
    var año = d.getFullYear();


    dia = ("0" + dia).slice(-2);
    mes = ("0" + mes).slice(-2);

    var fechaInicial = año + "-" + mes + "-" + dia;
    var fechaFinal = año + "-" + mes + "-" + dia;

    localStorage.setItem("capturarRango", "Hoy");
    window.location = "index.php?ruta=ventas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal;
  }
})
/*=============================================
ABRIR ARCHIVO XML EN NUEVA PESTAÑA
=============================================*/
$(".abrirXML").click(function () {

  var archivo = $(this).attr("archivo");
  window.open(archivo, "_blank");
})
/*=============================================
SELECCIONAR EL ITEM POR DEFECTO EN EL COMBOBOX
 Para este caso: CLIENTE GENERAL 
=============================================*/
$(document).ready(function(){
    $('#seleccionarCliente > option[value="1"]').attr('selected', 'selected');
});


