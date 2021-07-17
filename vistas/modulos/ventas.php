<div class="content-wrapper">
  <section class="content-header">
    <h1><strong>Listado de Ventas del Usuario : <?php echo $_SESSION["nombre"]; ?></strong> </h1>
  </section>

  <section class="content">

    <div class="box-header with-border">
      <a href="crear-venta">
        <button class="btn btn-primary">Agregar venta</button>
      </a>
      <!-- <button type="button" class="btn btn-default pull-right" id="daterange-btn">
            <span><i class="fa fa-calendar"></i> Rango de fecha</span><i class="fa fa-caret-down"></i>
         </button> -->
    </div>


    <div class="box-body">

      <table class="table table-bordered table-striped dt-responsive tablaListadoVentas text-center" width="100%">

        <thead>
          <tr>
            <th style="width:10px">#</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Cantidad</th>
            <th>Producto</th>
            <th>TotalXProducto</th>
            <th>Forma_Pago</th>
            <th>Comprobante</th>
            <th>Precio_Neto</th>
            <th>Costo_Total</th>
            <th>Fecha</th>
            <th>Acciones</th>

          </tr>
        </thead>
      </table>
      <input type="hidden" value="<?php echo $_SESSION['id']; ?>" id="idUsuario">
      <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto" class="perfilOculto">
    </div>
  </section>
</div>
<?php
$eliminarVenta = new ControladorVentas();
$eliminarVenta->ctrEliminarVenta();
?>