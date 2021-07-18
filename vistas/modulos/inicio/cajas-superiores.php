<?php

$item = null;
$valor = null;
$orden = "id";

//$ventas1 = ControladorVentas::ctrSumaTotalVentas();
$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
$totalVentas = count($ventas);
//var_dump($totalVentas);

//$compras = ControladorCompras::ctrSumaTotalCompras();
$compras = ControladorCompras::ctrMostrarCompras($item, $valor);
$totalCompras = count($compras);

$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
$totalCategorias = count($categorias);

$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
$totalClientes = count($clientes);

$proveedores = ControladorProveedor::ctrMostrarProveedor($item, $valor);
$totalProveedores = count($proveedores);

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
$totalProductos = count($productos);

?>

<div class="col-lg-3 col-xs-6">
  <div class="small-box bg-green">   
    <div class="inner">
     <h3><?php echo number_format($totalVentas); ?></h3>
      <p>Total de Ventas</p>
    </div>   
    <div class="icon">    
      <i>S/ </i>    
    </div>    
    <a href="ventas" class="small-box-footer">
      Más info <i class="fa fa-arrow-circle-right"></i> 
    </a>
  </div>
</div>

<div class="col-lg-3 col-xs-6">
  <div class="small-box bg-aqua">   
    <div class="inner">
      <h3><?php echo number_format($totalCompras); ?></h3>
      <p>Total de Compras</p> 
    </div>  
    <div class="icon">   
      <i class="ion ion-bag"></i>    
    </div>
    <a href="compras" class="small-box-footer">      
      Más info <i class="fa fa-arrow-circle-right"></i>    
    </a>
  </div>
</div>

<div class="col-lg-2 col-xs-4">
  <div class="small-box bg-yellow"> 
    <div class="inner">
      <h3><?php echo number_format($totalClientes); ?></h3>
      <p>Clientes</p>
    </div> 
    <div class="icon">  
      <i class="ion ion-person-add"></i>  
    </div>  
    <a href="clientes" class="small-box-footer">
      Más info <i class="fa fa-arrow-circle-right"></i>
    </a>
  </div>
</div>

<div class="col-lg-2 col-xs-4">
  <div class="small-box bg-purple">  
    <div class="inner">
      <h3><?php echo number_format($totalProveedores); ?></h3>
      <p>Proveedores</p> 
    </div>    
    <div class="icon">
      <i class="ion ion-person-add"></i>
    </div>
    <a href="proveedores" class="small-box-footer">
      Más info <i class="fa fa-arrow-circle-right"></i>
    </a>
  </div>
</div>

<div class="col-lg-2 col-xs-4">
  <div class="small-box bg-red"> 
    <div class="inner">
    
      <h3><?php echo number_format($totalProductos); ?></h3>
      <p>Productos</p>  
    </div>  
    <div class="icon">    
      <i class="ion ion-ios-cart"></i>  
    </div> 
    <a href="productos" class="small-box-footer">  
      Más info <i class="fa fa-arrow-circle-right"></i>
    </a>
  </div>
</div>