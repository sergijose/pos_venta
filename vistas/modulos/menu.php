<aside class="main-sidebar">
	 <section class="sidebar">
		<ul class="sidebar-menu">

					<li>
						<a href="inicio">
							<i class="fa fa-home"></i>
							<span>Inicio</span>
						</a>
					</li>
		

			<?php
				if($_SESSION["perfil"] == "Administrador"){
			echo '<li>
						<a href="usuarios">
							<i class="fa fa-user"></i>
							<span>Usuarios</span>
						</a>
					</li>';
				}


				if($_SESSION["perfil"] == "Administrador"){
					echo '
					<!--
					<li>
						<a href="categorias">
							<i class="fa fa-th"></i>
							<span>Categorías</span>
						</a>
					</li>
					<!--
                    <li>
						
						<a href="proveedores">
							<i class="fa fa-th"></i>
							<span>Proveedores</span>
						</a>
					</li>-->';
				}

              if($_SESSION["perfil"] == "Administrador"){
			       echo '
					<li>
						<a href="productos">
							<i class="fa fa-product-hunt"></i>
							<span>Productos</span>
						</a>
					</li>
					<li>';
				}


				if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){
					echo '<li>
						<a href="clientes">
							<i class="fa fa-users"></i>
							<span>Clientes</span>
						</a>
					</li>';
				}

				if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){
					echo '<li class="treeview">
						<a href="#">
							<i class="fa fa-usd"></i>							
							<span>Crear Venta</span>							
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">						
                            <li>
								<a href="crear-venta">									
									<i class="fa fa-plus"></i>
									<span>Crear Venta</span>
								</a>
							</li>
							<li>
								<a href="ventas">									
									<i class="fa fa-file-o"></i>
									<span>Listado de Ventas</span>
								</a>
							</li>
						</ul>
					</li>';
				}


				if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor"){
					echo '<li class="treeview">
						<a href="#">
							<i class="glyphicon glyphicon-repeat"></i>							
							<span>Transferencia Interna</span>							
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">						
                            <li>
								<a href="transferencia">									
									<i class="glyphicon glyphicon-arrow-left"></i>
									<span>Transferencia Interna</span>
								</a>
							</li>
							<li>
								<a href="listado-transferencias">									
									<i class="glyphicon glyphicon-arrow-left"></i>
									<span>Listado Transferencias</span>
								</a>
							</li>

						</ul>
					</li>';
				}

				if($_SESSION["perfil"] == "SuperAdmin"){
					echo '<li class="treeview">
							<a href="#">
								<i class="fa fa-shopping-cart"></i>
								<span>Compras</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">							
								<li>
									<a href="crear-compra">										
										<i class="fa fa-plus"></i>
										<span>Nueva Compra</span>
								   </a>
								</li>
                                <li>
									<a href="compras">									
										<i class="fa fa-file-o"></i>
										<span>Listado de Compras</span>
									</a>
								</li>

							</ul>
						</li>';
				}

               // REPORTES DE COMPRAS Y VENTAS

				if($_SESSION["perfil"] == "Administrador"){
					echo '<li class="treeview">
							<a href="#">
								<i class="fa fa-area-chart"></i>
								<span>REPORTES</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
							    <li>
									<a href="reportes">										
										<i class="fa fa-money"></i>
										<span>Reporte de Ventas</span>
								   </a>
								</li>


							</ul>

						</li>';
				}
			?>
			
		</ul>
	 </section>
</aside>