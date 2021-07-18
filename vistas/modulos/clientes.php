  <style>
    #mdialTamanio{
      width: 85% !important;
    }
  </style>

<div class="content-wrapper">
  <section class="content-header">
        <h1><strong>Gestion de Clientes : Información Extraída de RENIEC </strong></h1>
    <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Informacion de Clientes</li>
        </ol>
  </section>
  <section class="content">
    <div class="box">
    
      <div class="box-header with-border">
    
      <button class="btn btn-primary" data-toggle="modal" data-target="#modalDNI">Clientes con DNI</button>

      </div> </br> 
    <!-- INICIA TABLA PARA MOSTRAR DATOS -->
    <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas text-center" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>
           <th>Tipo Documento</th>
           <th>Nº Documento</th>
           <th>DatosCliente</th>
           <th>Direccion</th>
           <th>Nº RUC</th>
           <th>Telefono</th>
           <th>Email</th>
           <th>Reg. Sistema</th>
         
          
         </tr> 
        </thead>
        <tbody>

        <?php
          $item = null;
          $valor = null;
          $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
          foreach ($clientes as $key => $value) {
            echo ' <tr>
                     <td>'.($key+1).'</td> 

                      <td>'.$value["documento"].'</td>
                      <td>'.$value["ruc"].'</td>
                      <td>'.$value["razon_social"].'</td>
                      <td>'.$value["direccion"].'</td> 
                      <td>'.$value["ruc2"].'</td>
                      <td>'.$value["telefono"].'</td>
                      <td>'.$value["correo"].'</td>                   
                      <td>'.date('d/m/Y',strtotime($value["fecha"])).'</td>
                     
                       
                  
                  </tr>';
          }
        ?>


        </tbody>
       </table>
      </div>
<!-- TERMINA TABLA PARA MOSTRAR DATOS -->
    </div>
  </section>
</div>

<!--=====================================
MODAL CLIENTES DNI
======================================-->
 <div id="modalDNI" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" id="mdialTamanio">
    <div class="modal-content">
      <form role="form" method="post">  
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
          <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registro de Clientes  -Extraido de RENIEC</h4>
        </div> 
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
         <div class="modal-body">
          <div class="box-body">

        <div class="col-xs-6">
            <div class="form-group"> 
            <label>Tipo Documento:</label> 
              <div class="input-group">           
                  <span class="input-group-addon"><i class="fa fa-cube"></i></span> 
                    <!-- <input type="text" value="RUC" class="form-control" id="nuevoTipo" name="nuevoTipo"readonly> -->
                    <select class="form-control" id="nuevoTipo" name="nuevoTipo">
                      <option value="">Selecionar Tipo</option>
                      <option value="DNI">D.N.I.</option>
                      <option value="RUC">RUC</option>

                </select>
              </div>
            </div> 
        </div>      
          <div class="col-xs-6">
              <label>Nº D.N.I.:</label>
         <div class="input-group">
            <input type="text" autocomplete="off" class="form-control" id="dni" name="dni" placeholder="Nº de DNI" required>
               <span class="input-group-btn">
                   <a href="#" class="btn btn-info" onclick="consultar()">Buscar<i class="fa fa-search"></i></a>
               </span>
         </div>
           </div>
      
        <div class="col-xs-12">     
            <div class="form-group">
              <label>Informacion de Cliente:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="nombres" name="nombres" required >
              </div>
            </div>
        </div>    
          
        <div class="col-xs-6">     
            <div class="form-group">
              <label>Direccion del Cliente:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente"  autocomplete="off" required>
              </div>
            </div> 
        </div> 
        
        <div class="col-xs-6">     
            <div class="form-group">
              <label>Numero RUC:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="ruc_cliente" name="ruc_cliente"  autocomplete="off">
              </div>
            </div> 
        </div> 

        <div class="col-xs-6">     
            <div class="form-group">
              <label>Telefono:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="text" class="form-control" id="telefono" name="telefono"  autocomplete="off">
              </div>
            </div> 
        </div> 

        <div class="col-xs-6">     
            <div class="form-group">
              <label>Correo Electronico:</label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                <input type="email" class="form-control" id="correo" name="correo"  autocomplete="off">
              </div>
            </div> 
        </div> 

             
            </div>
        </div>  
        <!--=====================================
        PIE DEL MODAL
        =====================================-->
           <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Grabar Informacion</button>
        </div> 
       <?php
        $cliente = new ControladorClientes();
        $cliente -> ctrCrearClienteDNI();
       ?>
      </form>
    </div>
  </div>
</div> 
 