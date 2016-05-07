<?php
foreach ($usuarios as $row) {
	$usuario['usuario']	= $row->usuario;
	$usuario['id_perfil']	= $row->id_perfil;
}
?>

<section class="content">
	<div class="row">
		<section class="col-lg-12 connectedSortable">
			<div class="box box-info">
				
				<div class="box-header">
					<i class="fa fa-envelope"></i>
					<h3 class="box-title"><?php echo $this->lang->line('usuario')?></h3>
					<div class="pull-right box-tools">
						<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="col-md-6 col-md-offset-3">
						<div class="box box-widget widget-user">
                			<!-- Add the bg color to the header using any of the bg-* classes -->
                			<div class="widget-user-header bg-aqua-active">
                  				<h3 class="widget-user-username"><?php echo $usuario['usuario'] ?></h3>
                  				<h5 class="widget-user-desc"><?php echo $usuario['id_perfil']?></h5>
                			</div>
                			<div class="widget-user-image">
                  				<img class="img-circle" src="<?php echo base_url().'librerias/user.png'?>" alt="User Avatar">
                			</div>
                
                			<div class="box-footer">
                  				<div class="row">
                    				<a href="<?php echo base_url().'index.php/Afiliados/table/'?>" class="col-sm-4 border-right">
										<div class="description-block">
			 				 				<h5 class="description-header">0</h5>
			 				 				<span class="description-text"><?php echo $this->lang->line('entes')?></span>
                   						</div><!-- /.description-block -->
                    				</a><!-- /.col -->
                    				<div class="col-sm-4 border-right">
                    					<div class="description-block">
                        					<h5 class="description-header">0</h5>
                        					<span class="description-text"><?php echo $this->lang->line('afiliados')?></span>
                      					</div><!-- /.description-block -->
                    				</div><!-- /.col -->
                    				<div class="col-sm-4">
                      					<div class="description-block">
                        					<h5 class="description-header">0</h5>
                        					<span class="description-text"><?php echo $this->lang->line('boletas')?></span>
                      					</div><!-- /.description-block -->
                    				</div><!-- /.col -->
                  				</div><!-- /.row -->
                			</div>
              			</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</section>