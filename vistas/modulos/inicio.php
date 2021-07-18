<div class="content-wrapper">
  <!-- SECCION PARA QUE APAREZCAN LAS CAJAS CON DESCRIPCION -->
  <section class="content">
    
    <!-- Codigo para Descripocion Total del Sistema 
    <div class="box">
      <div class="box-header with-border">
        <h1 class="box-title"><strong>Sistema de Ventas y Facturacion</strong> </h1>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        </br>
        <strong>Estas son las actividades que podras realizar dentro del sistema:</strong></br></br>
       
        <strong>1. Módulo Usuarios: Registro y Edicion de Usuarios.</strong></br>
        <strong>2. Módulo Clientes: Registro y Edicion de Clientes.</strong></br>
        <strong>3. Módulo Proveedores</strong></br>
        <strong>5. Módulo de Compras</strong></br>
        <strong>6. Módulo de Ventas </strong></br>
        <strong>7. Módulo de Productos </strong></br></br>

        <strong>Soporte o dudas al correo electronico: piurasofteirl@gmail.com / juanpatinhopf@gmail.com</strong></br>
        <strong>Celular - WhatsApp : (+51) 968 119 674 </strong>
      </div>
    </div>
    -->
 <!-- Final de Codigo : Descripcion Breve del Sistema -->
 <!-- Inicio de Cajas Superiores -->
<div class="row"> 
    <?php
      include "inicio/cajas-superiores.php";
    ?>
</div> <!-- Final de Cajas Superiores -->

     <div class="row">
        <div class="col-lg-12">
          <!-- Código para Grafico de Ventas -->
          <?php         
            include "reportes/grafico-ventas.php";         
          ?>
        </div>
       <!-- Código para Productos Mas Vendidos -->
        <div class="col-lg-6">
          <?php
            include "reportes/compradores.php";
          ?>
        </div>
       <!-- Código para Productos Mas Vendidos --> 


        <!-- Código para vendedores-->
         <div class="col-lg-6">
          <?php
            include "reportes/vendedores.php";
          ?>
        </div>

      
          <!-- Código para Productos Agregados Recientemente -->
          <div class="col-lg-6">
          <?php
            include "inicio/productos-recientes.php";
          ?>
        </div>
        
 <!-- Código para Productos Mas Vendidos -->
        <div class="col-lg-6">
          <?php
            include "reportes/productos-mas-vendidos.php";
          ?>
        </div>
        

        <!-- Código para Perfil Diferente al Administrador -->
         <div class="col-lg-12">
          <?php
          if($_SESSION["perfil"] =="Vendedor"){

             echo '<div class="box box-success">
             <div class="box-header">
             <h1>Bienvenid@ ' .$_SESSION["nombre"].'</h1>
             </div>
             </div>';
          }
          ?>
         </div>

     </div>

  </section>
</div>

