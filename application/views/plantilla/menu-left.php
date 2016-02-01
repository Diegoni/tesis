		<aside class="main-sidebar">
        	<section class="sidebar">
				<ul class="sidebar-menu">
					<li class="header">MENU PRINCIPAL</li>
		            <?php
		            $array_maestros = array(
						'ABM Afiliados'			=> '',
						'ABM de Usuarios'		=> '',
						'Copia de Seguridad'	=> '',
						'Parámetros Generales'	=> '',
					);
					
					$array_operaciones = array(
						'Incorporar Pagos'		=> '',
						'Impresión de Boletas'	=> '',
						'Generar Listado de pagos Excel'	=> '',
					);
					
					$array_ayuda = array(
						'Contenidos'			=> '',
						'Acerca de'				=> '',
					);
					
					echo armar_menu('Maestros', 'fa-laptop', $array_maestros);
					echo armar_menu('Operaciones', 'fa-laptop', $array_operaciones);
					echo armar_menu('Ayuda', 'fa-laptop', $array_ayuda);
					?>
          		</ul>
        	</section>
		</aside>

		<div class="content-wrapper">
			<section class="content-header">
          		<h1><?php echo $subjet; ?><small> Sub titulo</small></h1>
			</section>

			