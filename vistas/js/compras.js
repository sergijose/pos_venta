/*=============================================
CARGAR LA TABLA DINÁMICA DE PRODUCTOS
=============================================*/
// $.ajax({
// 	url: "ajax/datatable-compras.ajax.php",
// 	success:function(respuesta){
// 		console.log("respuesta", respuesta);
// 	}
// })
$('.tablaCompras').DataTable({
    "ajax": "ajax/datatable-compras.ajax.php?sedeoculta="+sedeoculta,
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
  "lengthMenu":[3, 10, 15, 20, 50, 100],
  "pageLength":3

});

/*=============================================
AGREGANDO PRODUCTOS A LA COMPRA DESDE LA TABLA
=============================================*/
$(".tablaCompras tbody").on("click", "button.agregarProducto", function(){

    var idProducto = $(this).attr("idProducto");
    // console.log('idProducto:', idProducto)
    $(this).removeClass("btn-primary agregarProducto");
    $(this).addClass("btn-default");

    var datos = new FormData();
    datos.append("idProducto", idProducto);

    $.ajax({
        url:"ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(respuesta){

            // console.log('respuesta:', respuesta);
            let nombre = respuesta["nombre"];
            let stock = respuesta["stock"];
            let precio = respuesta["precio_compra"];

            $(".nuevoProducto").append(

                '<div class="row" style="padding:5px 15px">'+
                    '<!--Descripción del producto-->'+
                    '<div class="col-xs-6" style="padding-right:0px">'+
                        '<div class="input-group">'+
                            '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
                            '<input type="text" class="form-control agregarProductoCompra" idProducto="'+idProducto+'" name="agregarProductoCompra" value="'+nombre+'" readOnly required>'+
                        '</div>'+
                    '</div>'+
                    '<!-- Cantidad del producto -->'+
                    '<div class="col-xs-3">'+
                        '<input type="number" class="form-control nuevaCantidadProductoC" name="nuevaCantidadProductoC" min="1" value="1" stock="'+stock+'" nuevoStockC="'+(Number(stock) + Number(1))+'" required>'+
                    '</div>'+

                    '<!-- Precio de Venta -->'+
                    '<div class="col-xs-3 ingresoPrecioC" style="padding-left:0px">'+
                        '<div class="input-group">'+
                            '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
                            '<input type="text" class="form-control nuevoPrecioProductoC" precioRealC="'+precio+'" name="nuevoPrecioProductoC" value="'+precio+'" required readonly>'+
                        '</div>'+
                    '</div>'+

                    /*'<!-- Monto Total -->'+
                    '<div class="col-xs-2 ingresoPrecioC" style="padding-left:0px">'+
                        '<div class="input-group">'+
                            '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
                            '<input type="text" class="form-control nuevoPrecioProductoC" precioRealC="'+precio+'" name="nuevoPrecioProductoC" value="'+precio+'" readonly required>'+
                        '</div>'+
                    '</div>'+*/

                '</div>'             
            )
            // Sumar el total de los precios
            sumarTotalPreciosC();
            // Agregar Impuesto
            agregarImpuestoC();
            // AGRUPAR PRODUCTOS EN JSON
            listarProductosC()
            // FORMATO DE PRECIO A LOS PRODUCTOS
            $(".nuevoPrecioProductoC").number(true, 2);
        }
    })
});
/*=============================================
    CARGAR LA TABLA AL NAVEGAR EN ELLA
=============================================*/
$(".tablaCompras").on("draw.dt", function(){
    
    if(localStorage.getItem("quitarProducto")!=null){
        let listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
        for(let i = 0; i<listaIdProductos.length; i++){
            $("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');
            $("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');
        }
    }
})
/*=============================================
    QUITAR PRODUCTOS DE LA COMPRA Y RECUPERAR BOTON
=============================================*/
// let idQuitarProducto = [];
$(".formularioCompra").on("click", "button.quitarProducto", function () {
    $(this).parent().parent().parent().parent().remove();
    let idProducto = $(this).attr("idProducto");
/*=============================================
ALMACENAR EN LOCALSTORAGE EL ID DEL PRODUCTOS A QUITAR
=============================================*/
    if(localStorage.getItem("quitarProducto")==null){
        idQuitarProducto=[];
    }else{
        idQuitarProducto.concat(localStorage.getItem("quitarProducto"))
    }
    idQuitarProducto.push({"idProducto":idProducto});
    localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

    $("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');
    $("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');

    if($(".nuevoProducto").children().length==0){

        $("#nuevoImpuestoCompra").val(0);
        $("#nuevoTotalCompra").val(0);
        $("#totalCompra").val(0);
        $("#nuevoTotalCompra").attr("total", 0);
    }else{
        // Sumar el total de los precios
        sumarTotalPreciosC();
        // Agregar Impuesto
        agregarImpuestoC();
        // AGRUPAR PRODUCTOS EN JSON
        listarProductosC()
    }
})
/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTON PARA DISPOSITVOS
=============================================*/
//  let numProducto = 0;
$(".btnAgregarProductoC").click(function(){

    numProducto ++;
    let idProducto
    let datos = new FormData();
    datos.append("traerProductos", "ok");
    $.ajax({

        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            
            $(".nuevoProducto").append(
                '<div class="row" style="padding:5px 15px">' +
                    '<!--Nombre del producto-->' +
                    '<div class="col-xs-6" style="padding-right:0px">' +
                        '<div class="input-group">' +
                            '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>' +
                            '<select class="form-control nuevoNombreProducto agregarProductoCompra" id="productoC'+numProducto+'" idProducto name="nuevoNombreProducto" required>' +
                                '<option>Seleccione el producto</option>' +
                            '</select>'+
                        '</div>' +
                    '</div>' +

                    '<!-- Cantidad del producto -->' +
                    '<div class="col-xs-3 ingresoCantidadC">' +
                        '<input type="number" class="form-control nuevaCantidadProductoC" name="nuevaCantidadProductoC" min="1" value="1" stock nuevoStockC required>' +
                    '</div>' +

                    '<!-- Precio del producto -->' +
                    '<div class="col-xs-3 ingresoPrecioC" style="padding-left:0px">' +
                        '<div class="input-group">' +
                            '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                            '<input type="text" class="form-control nuevoPrecioProductoC" precioRealC name="nuevoPrecioProductoC" readonly required>' +
                        '</div>' +
                    '</div>' +
                '</div>'
            );
            // AGREGAR PRODUCTOS AL SELECT
            respuesta.forEach(funcionForEach);
            function funcionForEach(item, index){
                $("#productoC"+numProducto).append(
                    '<option idProducto="'+item.id+'" value="'+item.nombre+'">'+item.nombre+'</option>'
                )
            }
            // Sumar el total de los precios
            sumarTotalPreciosC();
            // Agregar Impuesto
            agregarImpuestoC();
            // FORMATO DE PRECIO A LOS PRODUCTOS
            $(".nuevoPrecioProductoC").number(true, 2);
        }
    })
})
/*=============================================
    SELECCIONAR PRODUCTO
=============================================*/
$(".formularioCompra").on("change", "select.nuevoNombreProducto", function () {
    
    let nombreProducto = $(this).val();
    let nuevoPrecioProductoC = $(this).parent().parent().parent().children(".ingresoPrecioC").children().children(".nuevoPrecioProductoC");
    let nuevaCantidadProductoC = $(this).parent().parent().parent().children(".ingresoCantidadC").children(".nuevaCantidadProductoC");
    // console.log('nombreProducto:', nombreProducto)
    let datos = new FormData();
    datos.append("nombreProducto", nombreProducto);

    $.ajax({

        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            
            $(nuevaCantidadProductoC).attr("stock", respuesta["stock"]);
            $(nuevaCantidadProductoC).attr("nuevoStockC", Number(respuesta["stock"])+1);
            $(nuevoPrecioProductoC).val(respuesta["precio_compra"]);
            $(nuevoPrecioProductoC).attr("precioRealC", respuesta["precio_Compra"]);
            // AGRUPAR PRODUCTOS EN JSON
            listarProductosC()
        }
    })
})
/*=============================================
    MODIFICAR LA CANTIDAD
=============================================*/
$(".formularioCompra").on("change", "input.nuevaCantidadProductoC", function () {

    let precioC = $(this).parent().parent().children(".ingresoPrecioC").children().children(".nuevoPrecioProductoC");
    let precioFinalC = $(this).val() * precioC.attr("precioRealC");
    precioC.val(precioFinalC);
    let nuevoStockC = Number($(this).attr("stock")) + Number($(this).val()); // Aumentamos el STOCK
    $(this).attr("nuevoStockC", nuevoStockC); // Le damos el valor del NUEVO STOCK
    // Sumar el total de los precios
    sumarTotalPreciosC();
    // Agregar Impuesto
    agregarImpuestoC();
    // AGRUPAR PRODUCTOS EN JSON
    listarProductosC()
})
/*=======================================================
MODIFICAR EL PRECIO : PARA QUE EL PRECIO SEA EDITABLE
=========================================================*/
/*$(".formularioCompra").on("change", ".nuevoPrecioProductoC", function () {

  var precioC = $(this).val();
  $(this).attr("precioRealC",precioC);
  //Creamos 2 variables a las cuales a las cuales asignamos los valores de las cajas de texto
  var cantidad = $(this).parent().parent().parent().children(".divCantidad").children(".nuevaCantidadProductoC").val();
  var precioTotal=$(this).parent().parent().parent().children(".ingresoPrecioC").children().children(".nuevoPrecioTotalC");
  // console.log(precioTotal);
  var operacion = Number(precioC)*Number(cantidad);
  $(precioTotal).val(operacion);
  // SUMAR TOTAL DE PRECIOS
  sumarTotalPreciosC();
  // AGREGAR IMPUESTO       
  agregarImpuestoC();
  // AGRUPAR PRODUCTOS EN FORMATO JSON
  listarProductosC();
})*/

/*=============================================
    SUMAR TODOS LOS PRECIOS
=============================================*/
function sumarTotalPreciosC(){

    let precioItemC = $(".nuevoPrecioProductoC");
    let arraySumaPrecioC = [];
    for(let i = 0; i < precioItemC.length; i++){

        arraySumaPrecioC.push(Number($(precioItemC[i]).val()));
    }
    function sumaArrayPreciosC(total, numero){
        return total + numero;
    }
    let sumaTotalPrecioC = arraySumaPrecioC.reduce(sumaArrayPreciosC);
    $("#nuevoTotalCompra").val(sumaTotalPrecioC);
    $("#totalCompra").val(sumaTotalPrecioC);
    $("#nuevoTotalCompra").attr("total", sumaTotalPrecioC);
}
/*=============================================
    AGREGAR IMPUESTO
=============================================*/
function agregarImpuestoC(){

    let impuestoC = $("#nuevoImpuestoCompra").val();
    let precioTotalC = $("#nuevoTotalCompra").attr("total");
    let precioImpuestoC = Number(precioTotalC * impuestoC/100);
    let totalConImpuestoC = Number(precioImpuestoC) + Number(precioTotalC);

    $("#nuevoTotalCompra").val(totalConImpuestoC);
    $("#totalCompra").val(totalConImpuestoC);
    $("#nuevoPrecioImpuestoC").val(precioImpuestoC);
    $("#nuevoPrecioNetoC").val(precioTotalC);
}
/*=============================================
    AL CAMBIAR EL IMPUESTO
=============================================*/
$("#nuevoImpuestoCompra").change(function() {
    agregarImpuestoC();
})
// FORMATO AL PRECIO FINAL
$("#nuevoTotalCompra").number(true, 2);
/*=============================================
    seleccionar metodo de pago
=============================================*/
/*$("#nuevoMetodoPagoC").change(function(){
    let metodo = $(this).val();
    if (metodo == "Efectivo"){
        $(this).parent().parent().removeClass("col-xs-6");
        $(this).parent().parent().addClass("col-xs-4");
        $(this).parent().parent().parent().children(".cajasMetodoPagoC").html(
            '<div class="col-xs-4">'+
                '<div class="input-group">'+
                    '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
                    '<input type="text" class="form-control nuevoValorEfectivoC" placeHolder="000000" required>'+
                '</div>'+
            '</div>'+
            '<div class="col-xs-4 capturarCambioEfectivoC" style="padding-left:0px">'+
                '<div class="input-group">'+
                    '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
                    '<input type="text" class="form-control nuevoCambioEfectivoC" placeHolder="000000" required readonly>' +
                '</div>'+
            '</div>'
        )
        // Agregar formato al precio
        $('.nuevoValorEfectivoC').number(true,2);
        $('.nuevoCambioEfectivoC').number(true,2);*/
        // LISTAR METODO EN LA ENTRADA
        /*listarMetodosC()
    }else{
        $(this).parent().parent().removeClass("col-xs-4");
        $(this).parent().parent().addClass("col-xs-6");
        $(this).parent().parent().parent().children(".cajasMetodoPagoC").html(
            '<div class="col-xs-6" style="padding-left:0px">'+
                '<div class="input-group">'+
                    '<input type="text" class="form-control" id="nuevoCodigoTransaccionC" name="nuevoCodigoTransaccionC" placeholder="Código transacción" required>'+
                    '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+
                '</div>'+
            '</div>'
        )
    }
})*/
/*=============================================
    CAMBIO EN EFECTIVO
=============================================*/
$(".formularioCompra").on("change", "input#nuevoValorEfectivoC", function () {

    var efectivoC = $(this).val(); // Obtenemos el valor del efectivo
    if(Number(efectivoC) < Number($('#nuevoTotalCompra').val())){ // Condicion para que el cambio sea positivo
   swal({
          title: "El valor debe ser mayor o igual al Total a Pagar",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
  //  Se limpian las cajas de texto
     $("#nuevoValorEfectivoC").val("");
     $("#nuevoCambioEfectivoC").val("");
 } else{
  // Caso contrario se ejecuta el proceso con normalidad
    var cambioC = Number(efectivoC) - Number($("#nuevoTotalCompra").val());
    $("#nuevoCambioEfectivoC").val(cambioC).number(true,2);
}
})
/*=============================================
    CAMBIO TRANSACCIÓN
=============================================*/
/*$(".formularioCompra").on("change", "input#nuevoCodigoTransaccionC", function () {
    // LISTAR METODO EN LA ENTRADA
    listarMetodosC()
})
*/
/*=============================================
    LISTAR TODOS LOS PRODUCTOS
=============================================*/
function listarProductosC(){
    var listaProductosC = [];
    // let id =;
    var nombre = $(".agregarProductoCompra");
    var cantidad = $(".nuevaCantidadProductoC");
    var precio = $(".nuevoPrecioProductoC");
    // let total = 
    for(let i = 0; i < nombre.length; i++){
        listaProductosC.push({"id":$(nombre[i]).attr("idProducto"), 
                              "nombre":$(nombre[i]).val(),
                              "cantidad":$(cantidad[i]).val(),
                              "stock":$(cantidad[i]).attr("nuevoStockC"),
                              "precio":$(precio[i]).attr("precioRealC"),
                              "total":$(precio[i]).val()
                            })
    }
    console.log('listaProductosC:', JSON.stringify(listaProductosC));
    $("#listaProductosC").val(JSON.stringify(listaProductosC));
    $("#listaProductosC").val(JSON.stringify(listaProductosC));
}
/*=============================================
    LISTAR METODOS DE PAGO
=============================================*/
function listarMetodosC(){
    let listaMetodosC = "";
    if($("#nuevoMetodoPagoC").val()=="Efectivo"){
        $("#listaMetodoPagoC").val("Efectivo");
    }else{
        $("#listaMetodoPagoC").val($("#nuevoMetodoPagoC").val() + "-" + $("#nuevoCodigoTransaccionC").val());
    }
}
/*=============================================
    BOTON EDITAR COMPRA
=============================================*/
/*$(".btnEditarCompra").click(function(){
    let idCompra = $(this).attr("idCompra");
    window.location = "index.php?ruta=editar-compra&idCompra="+idCompra;
})*/
/*=============================================
REVISAR SI EL CODIGO DE FOLIO YA ESTÁ REGISTRADO
=============================================*/
/*$("#nuevaCompra").change(function(){

    $(".alert").remove();
    var codigo = $(this).val();

    var datos = new FormData();
    datos.append("validaCodigo", codigo);

     $.ajax({
        url:"ajax/compras.ajax.php",
        method:"POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(respuesta){

            console.log("respuesta", respuesta);*/
            
            // if(respuesta){

            //     $("#nuevaCompra").parent().after('<div class="alert alert-warning">Codigo Existente...Registre uno Nuevo</div>');
            //     $("#nuevaCompra").val("");
            // }

      //  }

   // })
//})
/*=============================================
 BOTON EDITAR COMPRA
=============================================*/
/*$(".tablaListadoCompras").on("click", ".btnEditarCompra", function () {
  var idCompra = $(this).attr("idCompra");
  window.location = "index.php?ruta=editar-venta&idCompra=" + idCompra;
})*/