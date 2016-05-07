<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<?php
			if($session_data['id_perfil'] == 2){
				$url = base_url().'index.php/home/ente/';
			} else {
				$url = base_url().'index.php/Home/home_banco';
			}
			?>
			<a href="<?php echo $url?>" class="logo">
				<span class="logo-mini"><i class="fa fa-briefcase"></i></span>
				<?php
				$font_size = 14;
				echo '<span class="logo-lg" style="font-size: '.$font_size.'px" title="'.$session_data['ente'].'">'. $session_data['ente'].'</span>';
				?>
			</a>
			<nav class="navbar navbar-static-top" role="navigation">
	          	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	            	<span class="sr-only">Toggle navigation</span>
	          	</a>
				
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<?php
						if($config['alertas'] == 1){
						?>
						<li class="dropdown notifications-menu">
							<?php
							if(isset($alertas_user)){
								$cantidad_alertas	= count($alertas_user);
								$icon_alertas		= setSpan($cantidad_alertas, 'warning');
								$header_alertas		= 'Tienes '.$cantidad_alertas.' alertas';
								$footer_alertas		= '<a href="#" onclick="set_vistas()">Marcar como vistas</a>';
							}else{
								$cantidad_alertas	= 0;
								$icon_alertas		= '';
								$header_alertas		= 'No tienes alertas';
								$footer_alertas		= '';
							}
							?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bell-o"></i>
								<?php echo $icon_alertas?>
							</a>
							<ul class="dropdown-menu">
								<li class="header"><?php echo $header_alertas?></li>
								<li>
									<ul class="menu">
										<?php
										if(isset($alertas_user)){
											foreach ($alertas_user as $row) {
												echo '<li class="alerta_li">'.$row->alerta.'</li>';
											}
										}
										?>
									</ul>
								</li>
	                  			<li class="footer"><?php echo $footer_alertas?></li>
                			</ul>
              			</li>
						<?php 
						}
						if($session_data['id_perfil'] == 2){
						?>
						<li class="dropdown messages-menu">
                			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  				<?php echo $this->lang->line('entes') ?>
                			</a>
                			<ul class="dropdown-menu">
	                  			<li class="header">
	                  				<?php echo $this->lang->line('cambiar_ente') ?>
								</li>
                  				<li>
								<ul class="menu">
								<?php
								foreach ($session_data['entes'] as $row) {
									echo '<li>';
									echo '<a href="'.base_url().'index.php/home/ente/'.$row['id_ente'].'">';
									echo '<h4>';
									echo $row['ente'];
									echo '</h4>';
									echo '<p>'.$this->lang->line('codigo').' : '.$row['codigo'].'</p>';
									echo '</li>';
								}?>
                    			</ul>
                  				</li>
                  				<li class="footer">
                  					<a href="<?php echo base_url().'index.php/home/ente/'?>">
                  						<?php echo $this->lang->line('ver').' '.$this->lang->line('entes')?>
                  					</a>
                  				</li>
                			</ul>
              			</li>
              			<?php
              			}
						?>
						
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="hidden-xs"><?php echo $session_data['usuario'] ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-header">
									<img src="<?php echo base_url().'uploads/img/user.png' ?>" class="img-circle" alt="User Image">
									<p>
										<?php echo $session_data['usuario'] ?>
										<small><?php echo $this->lang->line('date_add').' '.formatDate($session_data['date_add']) ?></small>
									</p>
								</li>
		                  
								<li class="user-footer">
									<div class="text-center">
										<a href="<?php echo base_url().'index.php/Login/logout/'?>" class="btn btn-default btn-flat">
											<i class="fa fa-sign-out"></i> <?php echo $this->lang->line('salir');?>
										</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
<script>
function set_vistas(){
	$.ajax({
	 	type: 'POST',
	 	url: '<?php echo base_url(); ?>index.php/alertas/marcar_leidas/',
	 	data: { 
	 			id_usuario: <?php echo $session_data['id_usuario']; ?>, 
	 			id_ente: <?php echo $session_data['id_ente']; ?>,
	 			id_perfil: <?php echo $session_data['id_perfil']; ?>
	 		},
	 	success: function(resp) { 
	 		if("<?php echo $this->uri->segment(2)?>" == "do_upload"){
	 			if("<?php echo $this->uri->segment(1)?>" == "Pagos_tarjetas" || "<?php echo $this->uri->segment(1)?>" == "Pagos_boletas"){
	 				window.location.href = 'upload';
	 			} else {
	 				window.location.href = 'table';
	 			}	 			
	 		}else{
	 			location.reload();
	 		}
	 	}
	});
}
</script>