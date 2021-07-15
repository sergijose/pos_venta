<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <span><i class="fa fa-product-hunt"></i></span>
       Modulo de Productos 
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Administrar productos</li>
    </ol>
  </section>
  <section class="content">

    <div class="box box-success">
      <!-- <div class="box-header with-border">
        <button class="btn btn-flat btn-default" data-toggle="modal" data-target="#modalAgregarProducto"> Agregar productos</button>
      </div> -->
      <div class="box-body">
        
        <table class="table table-bordered table-striped dt-responsive tablaProductoSucursal text-center" width="100%">
          
          <thead>
            <tr>
              
              <th style="width:10px">#</th>
              <th>Imagen</th>
              <th>Codigo</th>
              <th>Nombre</th>
              <th>Categoria</th>
              <th>Sucursal</th>
              <th>Stock</th>
              <th>Precio_Compra</th>
              <th>Precio_Venta</th>
              <th>Observaciones</th>
              <th>Agregado</th>
              <th>Acciones</th>

            </tr> 
          </thead>
          <!-- ACA PASAMOS EL ID DE LA SUCURSAL DE MANERA OCULTA -->
          <input type="hidden" value="<?php echo $_SESSION['idSucursal']; ?>" id="sedeoculta">
        </table>     

      </div>
    </div>
  </section>
</div>
