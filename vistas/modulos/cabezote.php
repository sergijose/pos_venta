 <?php
 /*=============================================
					ACTUALIZAR NOTIFICACIONES NUEVOS PRODUCTOS VENCIDOS Y POR VENCER
					=============================================*/  
          $productosVencidos =ModeloNotificaciones::mdlCantidadProductosVencidos();
          $totalProductosVencidos=count($productosVencidos);
          //var_dump($totalProductosVencidos);
					ModeloNotificaciones::mdlActualizarNotificaciones("notificaciones", "nuevos_productos_vencidos", $totalProductosVencidos);

          /*=============================================
					ACTUALIZAR NOTIFICACIONES NUEVOS PRODUCTOS VENCIDOS Y POR VENCER
					=============================================*/  
          $productosPorVencer =ModeloNotificaciones::mdlProductosPorVencer();
          $totalProductosPorVencer=count($productosPorVencer);
        //  var_dump($totalProductosVencidos);
					ModeloNotificaciones::mdlActualizarNotificaciones("notificaciones", "nuevos_productos_por_vencer", $totalProductosPorVencer);

					?>
 <header class="main-header">
<!--=====================================BARRA DE NAVEGACIÓN======================================-->
	 <nav class="navbar navbar-static-top" role="navigation">
	<!-- <nav class="navbar navbar-static-top" role="navigation"> -->
		<!-- Botón de navegación -->
	 	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">  	 	
      	</a>
		<!-- perfil de usuario -->
		<div class="navbar-custom-menu">			
			<ul class="nav navbar-nav">

			<?php

		include "cabezote/notificaciones.php";



				?>
				
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<?php
					if($_SESSION["foto"] != ""){
						echo '<img src="'.$_SESSION["foto"].'" class="user-image">';
					}else{
						echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';
					}
					?>
						<span class="hidden-xs"><?php  echo $_SESSION["nombre"]; ?></span>				
					</a>
					<!-- AQUI SALIR DEL SISTEMA -->
					<ul class="dropdown-menu">
						<li class="user-body">	
							<div class="pull-right">	
								<a href="salir" class="btn btn-default btn-flat">Salir</a>
							</div>
							<!-- INICIO PARA QUE MUESTRE EL NOMBRE DE LA SUCURSAL -->
							<!-- <div class="pull-left"> -->
								<!-- CONSULTAMOS A BD Y MOSTRAMOS LA SUCURSAL A LA QUE PERTEENCE -->
								<!-- <span class="btn btn-default btn-flat hidden-xs"><?php  echo $_SESSION["idSucursal"]; ?></span> -->
							<!-- </div> -->
							<!-- FINAL PARA QUE MUESTRE EL NOMBRE DE LA SUCURSAL -->

						</li>
					</ul>
					<!-- FINAL DE  SALIR DEL SISTEMA -->
				</li>
			</ul>
		</div>
	</nav>
 </header>