<body class="login-page">
<section class="content">
	<div class="row">
		<section class="col-lg-12">
			
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="box box-default">
                		<div class="box-header with-border text-center">
                  			<h3 class="box-title">
                  				<?php echo $this->lang->line('seleccione').' '.$this->lang->line('ente')?>
                  			</h3>
                  		</div>
					</div>
				</div>
			</div>
			
			<?php 
			if(isset($mensajes)){
				echo setMensaje($mensajes, 'ok');
			}
			
			if($registros){
				foreach ($registros as $row) {
					if(isset($session_data['id_ente']) && $row->id_ente == $session_data['id_ente']){
						$class	= 'bg-green';
						$icon	= '<i class="fa fa-check-square-o"></i>';
						$link 	= '<div class=" pull-right">
										<p><a href="'.base_url().'index.php/afiliados/table" title="'.$this->lang->line('afiliados').'"><i class="fa fa-user margin-r-5"></i> <i class="fa fa-arrow-circle-right"></i></a></p>';
						if($session_data['boletas'] == 1){
							$link 	.='<p><a href="'.base_url().'index.php/boletas/table" title="'.$this->lang->line('boletas').'"><i class="fa fa-file-text-o margin-r-5"></i> <i class="fa fa-arrow-circle-right"></i></a></p>';
						}
						if($session_data['tarjetas'] == 1){
							$link 	.='<p><a href="'.base_url().'index.php/tarjetas/table" title="'.$this->lang->line('tarjetas').'"><i class="fa fa-credit-card margin-r-5"></i> <i class="fa fa-arrow-circle-right"></i></a></p>';
						}					
										
						$link 	.='</div>';
					}else{
						$class	=  'bg-default';
						$icon	= '<i class="fa fa-square-o"></i>';
						$link 	= '';
					}
					
					if(strlen($row->nombre) > 25){
						$nombre_cor = substr($row->nombre, 0, 25);	
						$nombre_cor = $nombre_cor.'...';
					}else{
						$nombre_cor = $row->nombre;
					}

					$html = '<div class="col-md-4">';
					$html .= '<div class="info-box" title="'.$row->nombre.'">';
					$html .= '<a href="'.base_url().'index.php/home/ente/'.$row->id_ente.'">';
					$html .= '<span class="info-box-icon '.$class.'">'.$icon.'</span>';
					$html .= '</a>';
					
					$html .= '<div class="info-box-content">';
					$html .= '<h2 class="info-box-text">'.$link.'</h2>';
					
					
					$html .= '<h2 class="info-box-text" title="'.$row->nombre.'">'.$nombre_cor.'</h2>';
					$html .= '</div>';
					
					$html .= '</div>';
					$html .= '</div>';
					
					echo $html;
				}
			} else {
				$mensaje = $this->lang->line('no_entes');
				$mensaje .= ' <a href="'.base_url().'index.php/Login/logout/" class="btn btn-default btn-flat" style="color: #000;">';
				$mensaje .=	'<i class="fa fa-sign-out"></i> '.$this->lang->line('salir');
				$mensaje .=	'</a>';
				
				echo setMensaje($mensaje, 'info');
			}
			?>
		</section>
	</div>	
</section>
