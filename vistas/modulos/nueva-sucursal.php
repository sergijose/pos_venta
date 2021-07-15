<?php
if($_SESSION["perfil"] != "Administrador"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}

?>
<div class="content-wrapper">
  <section class="content-header"> 
    <h1><strong>Gestion de Sucursales : Registro de Sucursal</strong></h1>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregaSucursal"><i class="glyphicon glyphicon-plus"></i>   
          Registrar Nueva Sucursal
        </button>
      </div>
      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas text-center" width="100%">
        <thead>
         <tr>
           
           <th style="width:10px">#</th>
           <th>Nombre_de_Sucursal</th>
           <th>Descripcion_Sucursal</th>
           <th>Fecha_Creacion</th>
           <th>Acciones</th>
           

         </tr> 

        </thead>
        <tbody>

        <?php
        $item = null;
        $valor = null;

        $perfil = ControladorSucursal::ctrMostrarSucursal($item, $valor);

       foreach ($perfil as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["sede"].'</td>
                  <td>'.$value["descripcion"].'</td>
                  <td>'.$value["fecha_registro"].'</td>
                <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarSede" data-toggle="modal" data-target="#EditaSucursal" idSucursal="'.$value["id"].'"><i class="fa fa-refresh"></i></button>';

                      if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarSede" idSucursal="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                      }

                      echo '</div>  

                    </td>
                  </tr>';
            }
        ?>
   
        </tbody>
       </table>
      </div>
    </div>
  </section>
</div>
<!--=====================================
MODAL AGREGAR 
======================================-->
<div id="modalAgregaSucursal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
       <!-- modal-lg : Sirve para dar mas ancho al modal sin tocar CSS -->
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modulo Empresa : Sucursales</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->                 
        <div class="modal-body modal-lg">
          <div class="box-body">
             <div class="row">
            <!-- NOMBRE DE SUCURSAL-->
          <div class="col-xs-6">
            <div class="form-group">
              <label>Nombre de la Sucursal:</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa  fa-book"></i></span> 
                <input type="text" class="form-control input-lg" id="nombreSucursal" name="nombreSucursal" placeholder="Nombre de Sucursal" required>
              </div>
            </div>
          </div>   
            <!-- DESCRIPCION DE SUCURSAL-->
        <div class="col-xs-6">  
            <div class="form-group">
              <label>Descripcion Breve de la Sucursal:</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa  fa-book"></i></span> 
                <textarea class="form-control input-lg" id="nuevaSucursal" name="nuevaSucursal" placeholder="Descripcion Breve de Sucursal" required></textarea>
              </div>
            </div>
         </div>

          </div>
        </div>
            </div>   
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>Agregar Sucursal</button>
        </div>
        <?php
          $crearSucursal = new ControladorSucursal();
          $crearSucursal -> ctrCrearSucursal();
        ?>
      </form>
    </div>
  </div>
</div>
<!--=====================================
EDICION DE SUCURSAL
======================================-->
 <div id="EditaSucursal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content"> 
       <form role="form" method="post" enctype="multipart/form-data"> 
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modulo Sucursales: Edicion de Sucursal</h4>
        </div> 
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
         <div class="modal-body">
          <div class="box-body"> 
            <!-- EDITAR NOMBRE DE SUCURSAL-->
             <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="text" class="form-control input-lg" id="editameSucursal" name="editameSucursal" required>
                 <input type="hidden" id="idSucursal" name="idSucursal">
              </div>
            </div> 
            <!-- EDITAR DESCRIPCION DE SUCURSAL-->
             <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="text" class="form-control input-lg" id="editameDescripcion" name="editameDescripcion" required>
              </div>
            </div>
          </div>
        </div> 
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
         <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"></i>Salir</button>
          <button type="submit" class="btn btn-primary">Editar Sucursal</button>
        </div>
    
      </form>
      <?php
          $editarSucursal = new ControladorSucursal();
          $editarSucursal -> ctrEditarSucursal();
        ?> 
    </div>
  </div>
</div> 
<?php
    $borrarSucursal = new ControladorSucursal();
    $borrarSucursal -> ctrEliminarSucursal();
?> 

