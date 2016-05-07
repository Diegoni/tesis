		<aside class="main-sidebar">
        	<section class="sidebar">
				<ul class="sidebar-menu">
					<li class="header">
						<?php
						if(file_exists($session_data['imagen'])){
							echo '<img src="'.$session_data['imagen'].'" class="img-rounded img-responsive" alt="Responsive image" >';
						}
						?>
					</li>
		            <?php
		            if($permisos_menu){
		            	foreach ($permisos_menu as $row) {
		            		$permisos_menu_array[$row->seccion] = $row->ver;
						}
		            }

		            $array_menu[]	= array(
						'title'	=> 'Maestros',
						'icon'	=> 'fa-circle-o',
						'submenu' => array(
							'Entes'			=> array(
								'permiso'	=> 'entes',
								'vista'		=> 'table',
								'icono'		=> '<i class="fa fa-briefcase"></i>',
							),
							'Usuarios'		=> array(
								'permiso'	=> 'usuarios',
								'vista'		=> 'table',
								'icono'		=> '<i class="fa fa-sign-out"></i>',
							),
							'Archivos'		=> array(
								'permiso'	=> 'archivos',
								'vista'		=> 'table',
								'icono'		=> '<i class="fa fa-file-o"></i>',
							),
						),
					);
					
					$array_menu[]	= array(
						'title'	=> 'AFiliados',
						'icon'	=> 'fa-user',
						'submenu' => array(
							'Afiliados'		=> array(
								'permiso'	=> 'afiliados',
								'vista'		=> 'table',
								'icono'		=> '<i class="fa fa-table"></i>',
							),
							'Importar afiliados'	=> array(
								'permiso'	=> 'afiliados',
								'vista'		=> 'upload',
								'icono'		=> '<i class="fa fa-plus-square-o"></i>',
							),
						),
					);
					
					if($session_data['id_perfil'] == 2){
						if($session_data['boletas'] == 1){
							$array_menu[]	= array(
								'title'	=> 'Boletas',
								'icon'	=> 'fa-file-text-o',
								'submenu' => array(
									'Boletas'		=> array(
										'permiso'	=> 'boletas',
										'vista'		=> 'table',
										'icono'		=> '<i class="fa fa-table"></i>',
									),
									'Generación boletas' => array(
										'permiso'	=> 'boletas',
										'vista'		=> 'alta',
										'icono'		=> '<i class="fa fa-plus-square-o"></i>',
									),
									'Impresión boletas' => array(
										'permiso'	=> 'boletas',
										'vista'		=> 'generar_impresion',
										'icono'		=> '<i class="fa fa-print"></i>',
									),
									'Importar pagos' => array(
										'permiso'	=> 'pagos_boletas',
										'vista'		=> 'upload',
										'icono'		=> '<i class="fa fa-money"></i>',	
									),
								),
							);
						}
					
					
						if($session_data['tarjetas'] == 1){
							$array_menu[]	= array(
								'title'	=> 'Tarjetas',
								'icon'	=> 'fa-credit-card',
								'submenu' => array(
									'Tarjetas'		=> array(
										'permiso'	=> 'tarjetas',
										'vista'		=> 'table',
										'icono'		=> '<i class="fa fa-table"></i>',
									),
									'Importar pagos' => array(
										'permiso'	=> 'pagos_tarjetas',
										'vista'		=> 'upload',
										'icono'		=> '<i class="fa fa-money"></i>',	
									),
									'Generación tarjetas' => array(
										'permiso'	=> 'tarjetas',
										'vista'		=> 'alta',
										'icono'		=> '<i class="fa fa-plus-square-o"></i>',
									),
									'Generación archivo' => array(
										'permiso'	=> 'tarjetas',
										'vista'		=> 'crear_archivo',
										'icono'		=> '<i class="fa fa-file-o"></i>',
									),
								),
							);
						}
					}
					
					$array_menu[]	= array(
						'title'	=> 'Config',
						'icon'	=> 'fa-circle-o',
						'submenu' => array(
							'Impresión'			=> array(
								'permiso'	=> 'config',
								'vista'		=> 'impresion',
								'icono'		=> '<i class="fa fa-print"></i>',
							),
							'Config'			=> array(
								'permiso'	=> 'config',
								'vista'		=> 'aplicacion',
								'icono'		=> '<i class="fa fa-cogs"></i>'
							),
						),
					);
										
					$array_menu[]	= array(
						'title'	=> 'Diccionarios',
						'icon'	=> 'fa-circle-o',
						'submenu' => array(
							'Leyendas'			=> array(
								'permiso'	=> 'diccionarios',
								'vista'		=> 'leyendas',
								'icono'		=> '<i class="fa fa-tags"></i>',
							),
							'Convenios'			=> array(
								'permiso'	=> 'diccionarios',
								'vista'		=> 'convenios',
								'icono'		=> '<i class="fa fa-university"></i>',
							),
							'Provincias'		=> array(
								'permiso'	=> 'diccionarios',
								'vista'		=> 'provincias',
								'icono'		=> '<i class="fa fa-map-marker"></i>',
							),
							'Localidades'		=> array(
								'permiso'	=> 'diccionarios',
								'vista'		=> 'localidades',
								'icono'		=> '<i class="fa fa-thumb-tack"></i>',
							),
							'Feriados'		=> array(
								'permiso'	=> 'diccionarios',
								'vista'		=> 'feriados',
								'icono'		=> '<i class="fa fa-calendar"></i>',
							),
						),
					);
					
					foreach ($array_menu as $menu) {
						$bandera = permisos_menu($menu['submenu'],	$permisos_menu_array, $session_data['id_perfil']);
						
						if($bandera){
							echo armar_menu($menu['title'], $menu['icon'], $bandera);
						}
					}
					?>
          		</ul>
        	</section>
		</aside>

		<div class="content-wrapper">
			<section class="content-header">
          		<h1>
          			<?php 
          			$titulo = str_replace("_", " ", $subjet);
					$subtitulo = str_replace("_", " ", $this->uri->segment(2));
					echo $titulo; 
					echo '<small>'.$subtitulo.'</small>';
					?>
          		</h1>
			</section>

			