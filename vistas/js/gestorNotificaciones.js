/*=============================================
ACTUALIZAR NOTIFICACIONES
=============================================*/

$(".actualizarNotificaciones").click(function(e){

	e.preventDefault();
	var item = $(this).attr("item");
	//console.log("respuestaitem", item);
	var datos = new FormData();
 	datos.append("item", item );

	 if(item == "productosVencidos"){

		window.location = "productos-vencidos";
	}
	if(item == "productosPorVencer"){

		window.location = "productos-por-vencer";
	}

  	$.ajax({

  		 url:"ajax/notificaciones.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){
			  
			//console.log("respuesta", respuesta);
  		  	if(respuesta == "ok"){
				

      	    	if(item == "productosVencidos"){

      	    		window.location = "productos-filtro";
      	    	}

      	    	if(item == ""){

      	    		window.location = "productos-filtro";
      	    	}

      	    

      	    }

      	 }

  	})
})