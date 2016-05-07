<?php
if(isset($config)){
	foreach ($config as $row) {
		$config_values = array(
			'mensaje_login'		=> $row->mensaje_login,
		);
	}
}
$loading = "<i class='fa fa-circle-o-notch fa-spin'></i>";	

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $this->lang->line('log_in')?></title>
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<b><?php echo $this->lang->line('log_in')?></b>
			</div>
			<div class="login-box-body">
				<p class="login-box-msg"><?php echo $this->lang->line('ingrese').' '.$this->lang->line('usuario').' '.$this->lang->line('y').$this->lang->line('contraseña'); ?></p>
				
				<form action="<?php echo base_url().'index.php/Login/control'; ?>" method="post">
					<div class="form-group has-feedback">
						<input type="text" onkeypress="return onlyCharInt(event)" name="username" class="form-control" placeholder="<?php echo $this->lang->line('usuario')?>">
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" onkeypress="return onlyCharInt(event)" name="password" class="form-control" placeholder="<?php echo $this->lang->line('contraseña')?>">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-4">
							<button type="submit" data-loading-text="<?php echo $loading ?>" class="btn btn-primary btn-block btn-flat"><?php echo $this->lang->line('log_in')?></button>
						</div>
					</div>
				</form>
				<hr>
				<?php if(isset($error)){
					echo setMensaje($error, 'error'); 
				} 
				$id_modal = 'help'
				?>
				<a href="#" data-toggle="modal" data-target="#<?php echo $id_modal?>">
					<?php echo $this->lang->line('olvidaste_pass');?>
				</a>
				<br>
			</div>
		</div>
   
		<!-- Modal -->
		<?php 
		echo get_modal($id_modal, $config_values['mensaje_login'] );
		?>
	</body>
</html>
<script>
$('.btn').on('click', function() {
	var variable = $(this);
	variable.button('loading');
});
</script>