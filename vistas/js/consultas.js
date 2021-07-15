//Funcion recibir Solo Numeros
function soloNumeros(e){
      tecla = (document.all) ? e.keyCode : e.which;

      //Tecla de retroceso para borrar, siempre la permite
      if (tecla==8){
          return true;
      }
          
      // Patron de entrada, en este caso solo acepta numeros
      patron =/[0-9]/;
      tecla_final = String.fromCharCode(tecla);
      return patron.test(tecla_final);
  }

//Funcion Recibir Solo Letras
function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

//Funcion para Consultar DNI
function consultar(){
        var dni = $("#dni").val();
        $.ajax({
                type: 'GET',
                url: 'https://rest.softdatamen.com/v1/0e622529d7b8d35ba8a9885d334bc84b/reniec/avanzado?dni='+dni,
                success: function(data){
                    //$("#nombres").val(data.nombres + " " + data.apellidoPaterno + " " + data.apellidoMaterno);
                    $("#nombres").val(data.result.nombre_completo);

                }
            });
    }

//Funcion para Consultar RUC
function consultaRUC(){
        var ruc = $("#ruc").val();
        $.ajax({
                type: 'GET',
                url: 'https://rest.softdatamen.com/v1/0e622529d7b8d35ba8a9885d334bc84b/sunat?ruc='+ruc,
                success: function(data){
                    //$("#nombres").val(data.nombres + " " + data.apellidoPaterno + " " + data.apellidoMaterno);
                    $("#razon_social").val(data.result.razon_social);
                    $("#direccion_empresa").val(data.result.direccion);
                }
            });
    }    

//Funcion para Consultar Datos Proveedor

function consultaProvee(){
        var nuevoRUC = $("#nuevoRUC").val();
        $.ajax({
                type: 'GET',
                url: 'https://rest.softdatamen.com/v1/0e622529d7b8d35ba8a9885d334bc84b/sunat?ruc='+nuevoRUC,
                success: function(data){
                    //$("#nombres").val(data.nombres + " " + data.apellidoPaterno + " " + data.apellidoMaterno);
                    $("#nuevaRSocial").val(data.result.razon_social); //Razon Social
                    $("#nuevaMarca").val(data.result.nombre_comercial); //Nombre Comercial
                    $("#nuevaDireccionP").val(data.result.direccion); // Direccion
                    $("#nuevoTipoEmp").val(data.result.tipo); // Tipo Empresa
                    $("#estado").val(data.result.estado); // Estado
                    $("#condicion").val(data.result.condicion); // Condicion
                }
            });
    }   


