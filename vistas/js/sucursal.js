/*=============================================
EDITAR SUCURSAL
=============================================*/
$(".tablas").on("click", ".btnEditarSede", function(){

	var idSucursal = $(this).attr("idSucursal");
	var datos = new FormData();
    datos.append("idSucursal", idSucursal);

    $.ajax({

      url:"ajax/sucursal.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      
         $("#idSucursal").val(respuesta["id"]);
	       $("#editameSucursal").val(respuesta["sede"]);
	       $("#editameDescripcion").val(respuesta["descripcion"]);
         
	  }

  	})
})
/*=============================================
ELIMINAR 
=============================================*/
$(".tablas").on("click", ".btnEliminarSede", function(){

  var idSucursal = $(this).attr("idSucursal");
  
  swal({
        title: '¿Está seguro de borrar la Sucursal?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar Sucursal!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=nueva-sucursal&idSucursal="+idSucursal;
        }

  })

})
