<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
		    <!--
			<a href="<?php echo base_url().'index.php' ?>" class="logo">
			-->
			<a href="#" class="logo">
				<span class="logo-mini"><i class="fa fa-globe"></i></span>
				<?php
				$font_size = 14;
				echo '<span class="logo-lg" style="font-size: '.$font_size.'px">
				<center>
				<img src="'.base_url().'assets/uploads/img/xnativa_logo.png" class="img-responsive" alt="User Image" width="125">
				</center>
				</span>';
				?>
			</a>
			<nav class="navbar navbar-static-top" role="navigation">
	          	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	            	<span class="sr-only">Toggle navigation</span>
	          	</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="hidden-xs"><?php echo lang('usuario') ?></span>
							</a>
							<ul class="dropdown-menu bounceInRight wow" data-wow-duration="2s">
								<li class="user-header">
									<img src="<?php echo base_url().'assets/uploads/img/user.png' ?>" class="img-circle" alt="User Image">
									<p>
										<?php echo $session['usuario'] ?>
										<small><?php echo $session['nombre'].' '.$session['apellido'] ?></small>
									</p>
								</li>
		                  
								<li class="user-footer">
									<div class="text-center">
										<a href="<?php echo base_url().'index.php/Login/logout/'?>" class="btn btn-default btn-flat">
											<i class="fa fa-sign-out"></i> <?php echo lang('salir');?>
										</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>