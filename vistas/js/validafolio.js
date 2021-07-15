/*============================================   
Revisar si codigo esta registrado 
=============================================*/
$("#nuevaCompra").change(function () {

  $(".alert").remove()
  // Se añade .trim() para eliminar espacios en blanco antes o despues del valor
  var codigo = $(this).val().trim()
  var datos = new FormData()
  datos.append("validameCodigo", codigo)

  $.ajax({
    url: "ajax/compras.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {

      // console.log("Hola que hace");


       if (respuesta) 
      {
         $("#nuevaCompra").parent().after('<div class="alert alert-info">Codigo/Folio Existente. Ingresa uno nuevo</div>')
         $("#nuevaCompra").val("")
       }

    }

  })
})