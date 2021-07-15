
<div class="content-wrapper">
  <section class="content">
    <div class="row">

  <!--================================== 
        EL FORMULARIO 
  ====================================-->
    <div class="col-lg-6 col-xs-12">
        <div class="box box-success">
          <section class="content-header">
            <h1>Transferencia Interna - Nuevo Registro</h1>
          </section>
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="formularioTransferencia">
            <div class="box-body">
              <div class="box">
<!--============================================== 
      ENTRADA DEL VENDEDOR 
============================================-->
               <div class="col-xs-6">       
                  <div class="form-group">
                    <label>Registra:</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                      <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">
                    </div>
                  </div>
               </div>    
<!--==================================================
            NTRADA PARA SUCURSAL
 ==================================================-->
                      <input type="hidden" name="idSucursal" value="<?php echo $_SESSION["idSucursal"]; ?>">
<!--=====================================
      DESTINO
======================================-->        
<div class="col-xs-6"> 
        <div class="form-group"> 
            <label>Destino de Gasto:</label>              
              <div class="input-group">           
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <select class="form-control" id="nuevoDestino" name="nuevoDestino">              
                  <option value="">Selecionar Destino</option>
                  <option value="Cocina">Cocina</option>
                  <option value="Cafeteria">Cafeteria</option>
                  <option value="Tienda">Tienda</option>
                  <option value="Restaurante">Restaurante</option>
                </select>
              </div>
        </div> 
</div>                        
<!--=====================================
      NOTA ADICIONAL
======================================-->  
<div class="col-xs-12">             
            <div class="form-group">
              <label>Descripcion Breve:</label>              
              <div class="input-group">           
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <textarea class="form-control" id="nuevaNota" name="nuevaNota" placeholder="Escribe aqui una Descripcion Breve..." required></textarea>
              </div>
            </div>
       </div>     
        
 
<!--=============================================================== 
      ENTRADA PARA AGREGAR PRODUCTO  
==================================================================-->
                <div class="form-group row nuevaTransferencia">
                </div>
                <input type="hidden" id="listaTransferencias" name="listaTransferencias">
<!--======================================================= 
      BOTÓN PARA AGREGAR PRODUCTO 
=========================================================-->
                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                <br>
              </div>
            </div>
            
            <div class="box-footer">
              <button type="submit" class="btn btn-flat btn-dark pull-right">Grabar Informacion</button>
            </div>
          </form>
          <?php
           $nuevaTransferencia = new ControladorTransferencia();
           $nuevaTransferencia->ctrCrearTransferencia();
          ?>
        </div>
      </div>


<!--=====================================
      LA TABLA DE PRODUCTOS 
======================================-->
     <div class="col-lg-6 hidden-md hidden-sm hidden-xs">
        <div class="box box-success">
          <div class="box-header with-border"></div>
          <div class="box-body">
            <table class="table table-bordered table-striped dt-responsive tablaTransfiere text-center">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
<!--                   <th>Codigo</th> -->
                  <th>Producto</th>
                  <th>Nota/Descripcion</th>
<!--                   <th>Sucursal</th> -->
                  <th>Stock_Actual</th>
                  <th>Acciones</th>
                </tr>
              </thead>

              <input type="hidden" value="<?php echo $_SESSION['idSucursal']; ?>" id="sedeoculta">
            </table>
          </div>
        </div>
      </div>




    </div>
  </section>
</div>
