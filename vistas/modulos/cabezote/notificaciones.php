<?php

//if($_SESSION["perfil"] == "administrador"){


//return ;
//}

$notificaciones = ControladorNotificaciones::ctrMostrarNotificaciones();

$totalNotificaciones = $notificaciones["nuevos_productos_vencidos"] + $notificaciones["nuevos_productos_por_vencer"];

?>

<!--=====================================
NOTIFICACIONES
======================================-->

<!-- notifications-menu -->
<li class="dropdown notifications-menu">
	
	<!-- dropdown-toggle -->
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		
		<i class="fa fa-bell-o"></i>
		
		<span class="label label-warning"><?php  echo $totalNotificaciones; ?></span>
	
	</a>
	<!-- dropdown-toggle -->

	<!--dropdown-menu -->
	<ul class="dropdown-menu">

		<li class="header" >Tu tienes <?php  echo $totalNotificaciones; ?> notificaciones</li>

		<li>
			<!-- menu -->
			<ul class="menu">

				<!-- usuarios -->
				<li>
				
					<a href="" class="actualizarNotificaciones" item="productosVencidos">
					
						<i class="fa fa-users text-aqua"></i> <?php  echo $notificaciones["nuevos_productos_vencidos"] ?> productos vencidos
					
					</a>

				</li>

				<!-- ventas -->
				<li>
				
					<a href="" class="actualizarNotificaciones" item="productosPorVencer">
					
						<i class="fa fa-shopping-cart text-aqua"></i> <?php  echo $notificaciones["nuevos_productos_por_vencer"] ?> productos que venceran pronto
					
					</a>

				</li>
				
			

			</ul>
			<!-- menu -->

		</li>

	</ul>
	<!--dropdown-menu -->

</li>
<!-- notifications-menu -->	
<script src="vistas/js/gestorNotificaciones.js"></script>