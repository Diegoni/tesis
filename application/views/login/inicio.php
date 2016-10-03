<?php
$loading = "<i class='fa fa-circle-o-notch fa-spin'></i>";	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo lang('log_in')?></title>
	</head>
	<body class="hold-transition login-page">
	    <div class="login-box">
			<div class="login-logo">
				<b><?php echo lang('log_in')?></b>
			</div>
			<?php
            if(isset($error)){
                echo '<div class="login-box-body">';
            }else{
                echo '<div class="login-box-body fadeInDown wow" data-wow-duration="2s">';
            }
            ?>
			    <p class="login-box-msg">
				    <?php echo lang('ingrese').' '.lang('usuario').' '.lang('y').' '.lang('contraseña'); ?>
				</p>
				<form action="<?php echo base_url().'index.php/Login/control'; ?>" method="post">
				    <div class="form-group has-feedback">
						<input type="text" onkeypress="return onlyCharInt(event)" name="username" class="form-control" placeholder="<?php echo lang('usuario')?>">
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" onkeypress="return onlyCharInt(event)" name="password" class="form-control" placeholder="<?php echo lang('contraseña')?>">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-4">
							<button type="submit" data-loading-text="<?php echo $loading ?>" class="btn btn-primary btn-block btn-flat"><?php echo lang('log_in')?></button>
						</div>
					</div>
				</form>
				<hr>
				<?php 
				if(isset($error)){
                    echo ' 
                    <div class="alert alert-danger alert-dismissable divider shake wow" id="alert" data-wow-duration="2s" >
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="fa fa-ban"></i> Error
                        <p>'.$error.'</p>
                    </div>'; 
				} 
				?>
			</div>
		</div>
	</body>
</html>
<script>
$('.btn').on('click', function() {
	var variable = $(this);
	variable.button('loading');
});
</script>